<?php

namespace panix\mod\admin\models;

use Yii;
use panix\mod\admin\models\query\NotificationQuery;
use panix\engine\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * Class Notification
 * @property integer $id ID
 * @property string $type Type
 * @property string $sound Sound Path
 * @property string $text Content
 * @property integer $status
 * @property string $url
 * @package panix\mod\admin\models
 */
class Notification extends ActiveRecord
{

    const MODULE_ID = 'admin';
    const STATUS_NO_READ = 0;
    const STATUS_READ = 1;
    const STATUS_NOTIFY = 2;

    public static function find()
    {
        return new NotificationQuery(get_called_class());
    }

    public static function tableName()
    {
        return '{{%notifications}}';
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at'],
                ]
            ]
        ]);
    }

}
