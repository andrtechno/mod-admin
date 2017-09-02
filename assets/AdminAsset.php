<?php

namespace panix\mod\admin\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle {

    public $sourcePath = '@webroot/themes/admin/assets';
    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );
    public $css = [
        'css/bootstrap-theme.css',
        'css/dashboard.css',
        'css/breadcrumbs.css',
    ];
    public $js = [
        'js/translitter.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'panix\engine\assets\CommonAsset'
    ];

}
