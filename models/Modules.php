<?php

namespace panix\mod\admin\models;

use Yii;
use panix\mod\admin\models\search\ModulesSearch;

class Modules extends \panix\engine\db\ActiveRecord
{

    const MODULE_ID = 'admin';

    /**
     * Cache enabled modules for request
     */
    protected static $cache = null;

    /**
     * Module info
     */
    protected $_info = array();
    public static $denieMods = array(
        'admin',
        'install',
        'seo',
        'users',
    );

    /*  public static function find() {
      return new ModulesSearch(get_called_class());
      } */

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%modules}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            // ['switch', 'numerical'],
            // The following rule is used by search()
            [['name', 'switch', 'access'], 'safe'],
        ];
    }

    public function getIsInsertSql()
    {
        if (file_exists(Yii::getAlias("mod.{$this->name}.sql") . DS . 'insert.sql')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Load enabled modules and cache for current request
     * @return array Enabled modules
     */
    public function getEnabled()
    {
        if (self::$cache)
            return self::$cache;

        try {
            $tableSchema = Yii::$app->db->schema->getTableSchema(static::tableName());
            if ($tableSchema !== null) {
                // Table does not exist

                self::$cache = static::find()
                    ->select(['name', 'access', 'className'])
                    ->all();
            }
        } catch (\yii\db\Exception $e) {

        }
        return self::$cache;
    }

    /**
     * Check if module is installed
     * @param string $name
     * @return boolean
     */
    public static function isModuleInstalled($name)
    {
        return (boolean)self::find()->where(['name' => $name])->count();
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function loadModuleClass($name)
    {
        return new \panix\engine\WebModule($name);
    }

    /**
     * Install module
     * @param string $name module name
     * @return boolean
     */
    public static function install($name)
    {

        if (self::loadModuleClass($name)->afterInstall()) {
            $model = new Modules;
            $model->name = $name;
            $model->access = 0; //Устанавливаем модуль с доступом "Все посетители"
            if ($model->save()) {

                Yii::$app->session->addFlash('success', Yii::t('admin/default', 'SUCCESS_INSTALL_MODULE', ['name' => Yii::t("{$name}/default", 'MODULE_NAME')]));
            }
        } else {
            Yii::$app->session->addFlash('error', Yii::t('admin/default', 'ERROR_INSTALL_MODULE'));
            // Yii::app()->controller->setFlashMessage(Yii::t('admin', 'ERROR_INSTALL_MODULE'));
            return false;
        }
        self::deleteCaches();
        // self::buildEventsFile();

        return true;
    }

    /**
     * After delete module
     */
    public function afterDelete()
    {
        self::loadModuleClass($this->name)->afterUninstall();
        self::deleteCaches();
        // self::buildEventsFile();
        return parent::afterDelete();
    }

    /**
     * Deletes cache
     */
    public static function deleteCaches()
    {
        Yii::$app->cache->delete('url_manager_urls');
    }

    /**
     * Load module description file
     * @param string $name module name
     * @return array
     */
    public static function loadInfo($name = null)
    {
        if ($name) {
            $mod = self::loadModuleClass($name);
            return (object)[
                'name' => $mod->name,
                'author' => $mod->author,
                'description' => $mod->description,
                'icon' => $mod->icon,
                'version' => $mod->version,
            ];
        }
    }

    public function getAvailable()
    {
        $result = array();


        $files = glob(Yii::getAlias('@app/modules/*') . DIRECTORY_SEPARATOR . "Module.php");

        if (!sizeof($files))
            return array();

        foreach ($files as $file) {
            $parts = explode(DIRECTORY_SEPARATOR, $file);
            $moduleName = basename($parts[sizeof($parts) - 2]);

            if (!self::isModuleInstalled($moduleName)) {
                if (!in_array($moduleName, self::$denieMods)) {

                    $result[$moduleName] = self::loadInfo($moduleName);
                }
            }
        }
        return $result;
    }

    /**
     * Get module info
     * @return string
     */
    public function getInfo()
    {
        $mod = Yii::$app->getModule($this->name);
        return (object)array(
            'label' => $mod->name,
            'author' => $mod->author,
            'description' => $mod->description,
            'icon' => $mod->icon,
            'version' => $mod->version,
        );
    }

    public static function getModules($remove = array())
    {
        $modules = array();

        foreach (self::find()->published()->where(['NOT IN', 'name', CMap::mergeArray(self::$denieMods, $remove)])->all() as $mod) {
            //Yii::import('mod.' . $mod->name . '.' . ucfirst($mod->name) . 'Module');
            $modules[$mod->name] = Yii::t($mod->name . '/default', 'MODULE_NAME');
        }
        return $modules;
    }

    public static function getAccessList()
    {
        return [
            0 => 'Все посетители',
            1 => 'Пользователи',
            2 => 'Только администраторы'
        ];
    }
}
