<?php

namespace panix\mod\admin\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle {

    public $sourcePath = '@admin/assets';
    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );
    public $css = [
        'css/dashboard.css',
        'css/breadcrumbs.css',
        'css/dark.css',
       // 'css/ui.css',
    ];
    public $js = [

    ];
    public $depends = [
        'panix\engine\assets\CommonAsset',
        'panix\engine\assets\ClipboardAsset',
        'panix\mod\admin\assets\AdminCountersAsset',
    ];

}
