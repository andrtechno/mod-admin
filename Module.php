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
                        'visible' => Yii::$app->user->can('/admin/admin/settings/index') || Yii::$app->user->can('/admin/admin/settings/*')
                    ],
                    [
                        'label' => Yii::t('admin/default', 'LANGUAGES'),
                        'url' => ['/admin/app/languages'],
                        'icon' => 'language',
                        'visible' => Yii::$app->user->can('/admin/admin/languages/index') || Yii::$app->user->can('/admin/admin/languages/*')
                    ],
                    [
                        'label' => Yii::t('admin/default', 'WIDGETS'),
                        'url' => ['/admin/app/widgets'],
                        'icon' => 'chip',
                        'visible' => Yii::$app->user->can('/admin/admin/widgets/index') || Yii::$app->user->can('/admin/admin/widgets/*')
                    ],
                    [
                        'label' => Yii::t('admin/default', 'Mails tpl'),
                        'url' => ['/admin/app/mail-template'],
                        'icon' => 'mail',
                        'visible' => Yii::$app->user->can('/admin/admin/mail-template/index') || Yii::$app->user->can('/admin/admin/mail-template/*')
                    ],
                    [
                        'label' => Yii::t('admin/default', 'DATABASE'),
                        'url' => ['/admin/app/database'],
                        'icon' => 'database',
                        'visible' => Yii::$app->user->can('/admin/admin/database/index') || Yii::$app->user->can('/admin/admin/database/*')
                    ],
                    [
                        'label' => Yii::t('admin/default', 'LOGS'),
                        'url' => ['/admin/app/logs'],
                        'icon' => 'log',
                        'visible' => Yii::$app->user->can('/admin/admin/logs/index') || Yii::$app->user->can('/admin/admin/logs/*')
                    ],
                    [
                        'label' => Yii::t('admin/default', 'MODULES'),
                        'url' => ['/admin/app/modules'],
                        'icon' => 'puzzle',
                        'visible' => Yii::$app->user->can('/admin/admin/modules/index') || Yii::$app->user->can('/admin/admin/modules/*')
                    ],
                    [
                        'label' => Yii::t('admin/default', 'DYNAMIC_FORM'),
                        'url' => ['/admin/app/dynamic-form'],
                        'icon' => 'arrow-right',
                        'visible' => Yii::$app->user->can('/admin/admin/dynamic-form/index') || Yii::$app->user->can('/admin/admin/dynamic-form/*')
                    ],
                    [
                        'label' => Yii::t('admin/default', 'HELP'),
                        'url' => ['/admin/app/help'],
                        'icon' => 'info',
                        'visible' => Yii::$app->user->can('/admin/admin/help/index') || Yii::$app->user->can('/admin/admin/help/*')
                    ],
                    [
                        'label' => Yii::t('admin/default', 'TEMPLATE'),
                        'url' => ['/admin/app/template'],
                        'icon' => 'template',
                        'visible' => Yii::$app->user->can('/admin/admin/template/index') || Yii::$app->user->can('/admin/admin/template/*')
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
