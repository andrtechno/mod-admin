<?php

namespace panix\mod\admin;

use Yii;
//use yii\base\BootstrapInterface; // implements BootstrapInterface
use panix\engine\WebModule;

/**
 * Class Module
 * @package panix\mod\admin
 */
class Module extends WebModule {

    public function getInfo() {
        return [
            'label' => Yii::t('admin/default', 'MODULE_NAME'),
            'author' => 'dev@pixelion.com.ua',
            'version' => '1.0',
            'icon' => 'icon-tools',
            'description' => Yii::t('admin/default', 'MODULE_DESC'),
            'url' => ['/app'],
        ];
    }

    public function getAdminMenu() {
        return [
            'system' => [
                'items' => [
                    [
                        'label' => Yii::t('app', 'SETTINGS'),
                        'url' => ['/app/settings'],
                        'icon' => 'settings',
                        'visible' => true
                    ],
                    [
                        'label' => Yii::t('admin/default', 'LANGUAGES'),
                        'url' => ['/app/languages'],
                        'icon' => 'language',
                        'visible' => true
                    ],
                    [
                        'label' => Yii::t('admin/default', 'EDIT_FILES'),
                        'url' => ['/app/editorfile'],
                        'icon' => 'file',
                        'visible' => true
                    ],
                    [
                        'label' => Yii::t('admin/default', 'WIDGETS'),
                        'url' => ['/app/widgets'],
                        'icon' => 'chip',
                        'visible' => true
                    ],
                    [
                        'label' => Yii::t('admin/default', 'DATABASE'),
                        'url' => ['/app/database'],
                        'icon' => 'database',
                        'visible' => true
                    ],
                    [
                        'label' => Yii::t('admin/default', 'MODULES'),
                        'url' => ['/app/modules'],
                        'icon' => 'puzzle',
                        'visible' => true
                    ],
                ]
            ]
        ];
    }

    public function getAdminSidebar() {
        $items = $this->getAdminMenu();
        return $items['system']['items'];
    }

}
