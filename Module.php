<?php

namespace panix\mod\admin;

use Yii;
//use yii\base\BootstrapInterface; // implements BootstrapInterface
use panix\engine\WebModule;

class Module extends WebModule {

    //public $controllerNamespace = 'panix\admin\controllers';

    //public $routes = [
    //    'admin' => 'admin/default/index',
    //];


    protected function getDefaultModelClasses() {
        return [];
    }
    public function getInfo() {
        return [
            'name' => Yii::t('admin/default', 'MODULE_NAME'),
            'author' => 'dev@corner-cms.com',
            'version' => '1.0',
            'icon' => 'icon-tools',
            'description' => Yii::t('admin/default', 'MODULE_DESC'),
            'url' => ['/admin/app'],
        ];
    }
    public function getNav() {
        return [
            [
                'label' => Yii::t('app','SETTINGS'),
                'url' => ['/admin/app/settings'],
                'icon' => 'icon-settings',
                'visible' => true
            ],
            [
                'label' => Yii::t('app','LANGUAGES'),
                'url' => ['/admin/app/languages'],
                'icon' => 'icon-language',
                'visible' => true
            ]
        ];
    }

}
