<?php

namespace panix\mod\admin\models\chat;

use Yii;
use yii\web\AssetBundle;

/**
 * Class ChatJs
 * @package panix\mod\admin\models\chat
 */
class ChatJs extends AssetBundle {

    public $sourcePath = '@admin/assets';
    public $js = [
        'js/chat.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'panix\engine\emoji\EmojiAsset',
    ];

}
