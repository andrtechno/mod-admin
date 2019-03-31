<?php

namespace panix\mod\admin\models\chat;

use Yii;
use yii\web\AssetBundle;

/**
 * Class ChatAsset
 * @package panix\mod\admin\models\chat
 */
class ChatAsset extends AssetBundle {

    public $sourcePath = '@admin/assets';
    public $js = [
        'js/chat.js',
    ];
    public $css = [
        'css/chat.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'panix\engine\emoji\EmojiAsset',
    ];

}
