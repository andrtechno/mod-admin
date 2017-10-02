<?php

/**
 * @link https://github.com/sintret/yii2-chat-adminlte
 * @copyright Copyright (c) 2014 Andy fitria 
 * @license MIT
 */

namespace panix\mod\admin\models\chat;

use Yii;
use yii\web\AssetBundle;

/**
 * @author Andy Fitria <sintret@gmail.com>
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
