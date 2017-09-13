<?php

namespace panix\mod\admin\models;
use Yii;
use panix\mod\admin\models\search\ModulesSearch;
class Modules extends \panix\engine\db\ActiveRecord {
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
        'main'
    );
  /*  public static function find() {
        return new ModulesSearch(get_called_class());
    }*/
    /**
     * @return string the associated database table name
     */
    public static function tableName() {
        return '{{%modules}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return [
            [['name', 'switch', 'access'], 'required'],
           // ['switch', 'numerical'],
            // The following rule is used by search()
            [['name', 'switch', 'access'], 'safe'],
        ];
    }

    public function getIsInsertSql() {
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
    public static function getEnabled() {
        if (self::$cache)
            return self::$cache;

        self::$cache = self::find()
                ->select(['name', 'access', 'namespace'])
                ->all();

        
        return self::$cache;
    }

    /**
     * Check if module is installed
     * @param string $name
     * @return boolean
     */
    public static function isModuleInstalled($name) {
        return (boolean) self::find()->where(['name' => $name])->count();
    }

    /**
     * Install module
     * @param string $name module name
     * @return boolean
     */
    public static function install($name) {

        if (self::loadModuleClass($name)->afterInstall()) {
            $model = new ModulesModel;
            $model->name = $name;
            $model->access = 0; //Устанавливаем модуль с доступом "Все посетители"
            if ($model->save()) {
                $modname = ucfirst($name);
                Yii::app()->user->setFlash('success', Yii::t('admin', 'SUCCESS_INSTALL_MODULE', array('{name}' => Yii::t("{$modname}Module.default", 'MODULE_NAME'))));
            }
        } else {
            Yii::app()->user->setFlash('error', Yii::t('admin', 'ERROR_INSTALL_MODULE'));
            // Yii::app()->controller->setFlashMessage(Yii::t('admin', 'ERROR_INSTALL_MODULE'));
            return false;
        }
        self::deleteCaches();
        self::buildEventsFile();

        return true;
    }

    /**
     * After delete module
     */
    public function afterDelete() {
        self::loadModuleClass($this->name)->afterUninstall();
        self::deleteCaches();
        self::buildEventsFile();
        return parent::afterDelete();
    }

    /**
     * Deletes cache
     */
    public static function deleteCaches() {
        Yii::$app->cache->delete('url_manager_urls');
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function loadModuleClass($name) {
        $class = $name;
       // Yii::import("mod.{$name}." . $class);
Yii::getAlias('@vendor/panix/*');
        
        return new $class($name, null);
    }

    /**
     * Load module description file
     * @param string $name module name
     * @return array
     */
    public static function loadInfo($name = null) {
        die($name);
        $mod = self::loadModuleClass($name);

        return (object) array(
                    'name' => $mod->name,
                    'author' => $mod->author,
                    'description' => $mod->description,
                    'icon' => $mod->icon,
                    'version' => $mod->version,
                    'adminHomeUrl' => $mod->adminHomeUrl,
        );
        //if (isset($module->info)) {
        //    return $module->info;
        //} else {
        //    return false;
        // }
    }




    /**
     * @return string
     */
    public static function allEventsFilePath() {
        return Yii::getAlias('application.runtime.all_events') . '.php';
    }

    public function getAvailable() {
        $result = array();
        //$DS = DIRECTORY_SEPARATOR;
      
        $files = glob(Yii::getAlias('@vendor/panix/*') . DIRECTORY_SEPARATOR."Module.php");
       // print_r($files);
        
        $themesList = array_filter(glob(Yii::getAlias('@vendor/panix/*')), 'is_dir');
        print_r($files);
        die;
        foreach ($themesList as $theme) {
            if(strpos($theme,'mod-') === true){
            //echo str_replace('mod-','',basename($theme));
            //echo '<br>';
            }
            ///$themes[basename($theme)] = ucfirst(basename($theme));
        }
        
        
//die();
        if (!sizeof($files))
            return array();

        foreach ($files as $file) {
            $parts = explode(DIRECTORY_SEPARATOR, $file);
            $moduleName = $parts[sizeof($parts) - 2];
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
    public function getInfo() {
        $mod = Yii::$app->getModule($this->name);
        return (object) array(
                    'label' => $mod->name,
                    'author' => $mod->author,
                    'description' => $mod->description,
                    'icon' => $mod->icon,
                    'version' => $mod->version,
                    'adminHomeUrl' => $mod->adminHomeUrl,
        );
    }

    public static function getModules($remove = array()) {
        $modules = array();
        $criteria = new CDbCriteria;
        $criteria->addNotInCondition('name', CMap::mergeArray(self::$denieMods, $remove));
        foreach (self::find()->published()->findAll($criteria) as $mod) {
            Yii::import('mod.' . $mod->name . '.' . ucfirst($mod->name) . 'Module');
            $modules[$mod->name] = Yii::t($mod->name . '/default', 'MODULE_NAME');
        }
        return $modules;
    }

}
