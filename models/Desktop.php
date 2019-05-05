<?php

namespace panix\mod\admin\models;

use Yii;
use panix\engine\db\ActiveRecord;

class Desktop extends ActiveRecord
{
    const MODULE_ID = 'admin';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%desktop}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'columns'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['addons'], 'boolean'],
            [['columns', 'user_id', 'private'], 'integer'],

        ];
    }


    /**
     * Relation desktop widgets
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWidgets()
    {
        return $this->hasMany(DesktopWidgets::class, ['desktop_id' => 'id']);
    }

    public function accessControlDesktop()
    {
        if (!$this->isNewRecord) {
            if ($this->user_id) {
                if ($this->user_id != Yii::$app->user->id) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    public function accessPrivateDesktop()
    {
        if (!$this->isNewRecord) {
            if ($this->private) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
}