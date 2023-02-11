<?php

namespace panix\mod\admin\models;


use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


class Timeline extends ActiveRecord
{
    const MODULE_ID = 'admin';


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%timeline}}';
    }

    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }

    public function getActionData()
    {
        $data = [];
        $data['icon'] = '';
        $data['value'] = 'Unknown';
        $data['title'] = 'Unknown';
        if ($this->action == 'login') {
            $data['icon'] = 'icon-key';
            $data['value'] = 'Вошел';
            $data['title'] = 'Вошел';
        } elseif ($this->action == 'logout') {
            $data['icon'] = 'icon-logout';
            $data['value'] = 'Вышел';
            $data['title'] = 'Вышел';
        } elseif ($this->action == 'user_register') {
            $data['icon'] = 'icon-add';
            $data['value'] = 'Зарегистрировался';
            $data['title'] = 'Зарегистрировался';
        }
        return $data;
    }

    /**
     * @param $action
     * @param array $fields
     * @throws \Throwable
     */
    public static function add($action, $fields = [])
    {
        $model = new static;
        $model->user_id = (isset($fields['user_id'])) ? $fields['user_id'] : Yii::$app->user->id;
        $model->action = $action;
        //$model->text = '';
        $model->insert(false);
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at'],
                ]
            ]
        ];
    }
}
