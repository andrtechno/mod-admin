<?php

namespace panix\mod\admin\assets;

use yii\web\AssetBundle;

class AdminCountersAsset extends AssetBundle {

    public $sourcePath = '@admin/assets';
    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );

    public $js = [
        'js/jquery.playSound.js',
        'js/counters.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
        'panix\engine\assets\CommonAsset'
    ];

}
