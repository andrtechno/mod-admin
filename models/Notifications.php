<?php

namespace panix\mod\admin\models;

use Yii;
use panix\mod\admin\models\query\NotificationsQuery;
use panix\engine\db\ActiveRecord;

/**
 * Class Notifications
 * @property string $type Type
 * @property string $sound Sound Path
 * @property string $text Content
 * @package panix\mod\admin\models
 */
class Notifications extends ActiveRecord {

    const MODULE_ID = 'admin';

    public static function find() {
        return new NotificationsQuery(get_called_class());
    }

    public static function tableName() {
        return '{{%notifications}}';
    }

}
