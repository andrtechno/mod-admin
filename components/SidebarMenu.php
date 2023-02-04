<?php
namespace panix\mod\admin\components;

use panix\engine\CMS;
use panix\mod\admin\models\Modules;
use Yii;
use panix\engine\data\Widget;
use yii\helpers\ArrayHelper;

class SidebarMenu extends Widget
{

    private $_items;
    public $type = 'top';

    const CACHE_ID = 'EngineMainMenu';

    public function init()
    {
        // Minimum configuration
        $this->_items = array(
            'system' => array(
                'label' => Yii::t('app/default', 'SYSTEM'),
                'icon' => 'icon-wrench'
            ),
            'modules' => array(
                'label' => Yii::t('app/default', 'MODULES'),
                'icon' => 'icon-menu'
            ),
        );
    }


    /**
     * Find and load module menu.
     */
    public function findMenu($mod = false)
    {
        $result = [];
        //$installedModules = Modules::getEnabled();
        $installedModules = Yii::$app->getModules();

        foreach ($installedModules as $module) {
            //Yii::import('mod.' . $module->name . '.' . ucfirst($module->name) . 'Module');
            //if (method_exists($class, 'getAdminMenu')) {
            //    $result = CMap::mergeArray($result, $class::getAdminMenu());
            //}
            if (Yii::$app->hasModule($module->name)) {
                if (method_exists(Yii::$app->getModule($module->name),'getAdminMenu')) {
                //if (isset(Yii::$app->getModule($module->name)->adminMenu)) {
                    $result = ArrayHelper::merge($result, Yii::$app->getModule($module->name)->getAdminMenu());
                }
            }
        }

        return ($mod) ? $result[$mod] : $result;

    }

}