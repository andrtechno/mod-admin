<?php

namespace panix\mod\admin\models;

use Yii;
use panix\engine\db\ActiveRecord;

class DynamicForm extends ActiveRecord
{
    const MODULE_ID = 'admin';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dynamic_form}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
          //  [['columns', 'user_id', 'count_submit'], 'integer'],

        ];
    }

}