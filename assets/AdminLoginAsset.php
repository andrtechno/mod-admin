<?php

namespace panix\mod\admin\assets;

use yii\web\AssetBundle;

class AdminLoginAsset extends AssetBundle {

    public $sourcePath = '@admin/assets';
    public $css = [
        'css/bootstrap-theme.css',
        'css/dashboard.css',
        'css/login.css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'panix\engine\assets\CommonAsset'
    ];

}
