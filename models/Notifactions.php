<?php

namespace panix\mod\admin\models;

use Yii;
use panix\mod\admin\models\query\NotifactionsQuery;

class Notifactions extends \panix\engine\db\ActiveRecord {

    const MODULE_ID = 'admin';

    public static function find() {
        return new NotifactionsQuery(get_called_class());
    }

    public static function tableName() {
        return '{{%notifactions}}';
    }

    public function rules2() {
        return [
            [['name', 'code', 'locale'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['code'], 'string', 'max' => 2],
            [['locale'], 'string', 'max' => 5],
            [['is_default'], 'in', 'range' => [0, 1]],
        ];
    }

}
