<?php

namespace panix\mod\admin;

use Yii;
//use yii\base\BootstrapInterface; // implements BootstrapInterface
use panix\engine\WebModule;
use yii\base\BootstrapInterface;

/**
 * Class Module
 * @package panix\mod\admin
 */
class Module extends WebModule { // implements BootstrapInterface

    public function bootstrap2($app)
    {
        $app->urlManager->addRules(
            [
                'admin' => 'admin/admin/default/index',
                'admin/auth' => 'admin/auth/index',
            ],
            true
        );

    }

    public function getInfo() {
        return [
            'label' => Yii::t('admin/default', 'MODULE_NAME'),
            'author' => 'dev@pixelion.com.ua',
            'version' => '1.0',
            'icon' => 'icon-tools',
            'description' => Yii::t('admin/default', 'MODULE_DESC'),
            'url' => ['/admin/app'],
        ];
    }

    public function getAdminMenu() {
        return [
            'system' => [
                'items' => [
                    [
                        'label' => Yii::t('app/default', 'SETTINGS'),
                        'url' => ['/admin/app/settings'],
                        'icon' => 'settings',
                        'visible' => true
                    ],
                    [
                        'label' => Yii::t('admin/default', 'LANGUAGES'),
                        'url' => ['/admin/app/languages'],
                        'icon' => 'language',
                        'visible' => YII_DEBUG
                    ],
                    [
                        'label' => Yii::t('admin/default', 'WIDGETS'),
                        'url' => ['/admin/app/widgets'],
                        'icon' => 'chip',
                        'visible' => YII_DEBUG
                    ],
                    [
                        'label' => Yii::t('admin/default', 'Mails tpl'),
                        'url' => ['/admin/app/mail-template'],
                        'icon' => 'mail',
                        'visible' => YII_DEBUG
                    ],
                    [
                        'label' => Yii::t('admin/default', 'DATABASE'),
                        'url' => ['/admin/app/database'],
                        'icon' => 'database',
                        'visible' => true
                    ],
                    [
                        'label' => Yii::t('admin/default', 'LOGS'),
                        'url' => ['/admin/app/logs'],
                        'icon' => 'log',
                    ],
                    [
                        'label' => Yii::t('admin/default', 'MODULES'),
                        'url' => ['/admin/app/modules'],
                        'icon' => 'puzzle',
                        'visible' => YII_DEBUG
                    ],
                    [
                        'label' => Yii::t('admin/default', 'DYNAMIC_FORM'),
                        'url' => ['/admin/app/dynamic-form'],
                        'icon' => 'arrow-right',
                        'visible' => YII_DEBUG
                    ],
                    [
                        'label' => Yii::t('admin/default', 'HELP'),
                        'url' => ['/admin/app/help'],
                        'icon' => 'info',
                        'visible' => true
                    ],
                    [
                        'label' => Yii::t('admin/default', 'TEMPLATE'),
                        'url' => ['/admin/app/template'],
                        'icon' => 'template',
                        'visible' => YII_DEBUG
                    ],
                ]
            ]
        ];
    }

    public function getAdminSidebar()
    {
        return (new \panix\mod\admin\widgets\sidebar\BackendNav)->findMenu('system')['items'];
    }

}
