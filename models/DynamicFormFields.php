<?php

namespace panix\mod\admin\models;

use panix\engine\CMS;
use Yii;
use panix\engine\db\ActiveRecord;
use yii\helpers\Json;

class DynamicFormFields extends ActiveRecord
{
    const MODULE_ID = 'admin';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dynamic_form_fields}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['csrf'], 'boolean'],
            [['name'], 'string', 'max' => 255],
            [['rules'], 'safe'],
            [['rules'], 'default'],
            //  [['columns', 'user_id', 'count_submit'], 'integer'],

        ];
    }

    public function beforeSave($insert)
    {
        if ($this->rules) {
            $this->rules = Json::encode(array_values($this->rules));
            //CMS::dump($this->rules);die;
        }
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->rules = Json::decode($this->rules, true);
        parent::afterFind();

    }

}
