<?php

namespace panix\mod\admin\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle {

    public $sourcePath = '@admin/assets';
    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );
    public $css = [
        // 'css/bootstrap-theme.css',
        'css/dashboard.css',
        'css/breadcrumbs.css',
        'css/ui.css',
    ];
    public $js = [
        'js/translitter.js',
       // 'js/chat.js'
    ];
    public $depends = [
        'panix\engine\assets\CommonAsset',
        'panix\mod\admin\assets\AdminCountersAsset',
    ];

}
