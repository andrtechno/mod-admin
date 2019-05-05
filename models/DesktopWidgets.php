<?php

namespace panix\mod\admin\models;

use Yii;
use panix\engine\db\ActiveRecord;

class DesktopWidgets extends ActiveRecord
{
    const MODULE_ID = 'admin';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%desktop_widgets}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['desktop_id', 'widget', 'col'], 'required'],
            [['widget'], 'string', 'max' => 255],
            [['desktop_id', 'col', 'ordern'], 'integer'],

        ];
    }


    public function getDesktop()
    {
        return $this->hasOne(Desktop::class, ['object_id' => 'id']);
    }

    public function getColumnsRange()
    {
        $desktop = Desktop::findOne((int)$_GET['id']);
        if (isset($desktop)) {
            $columns = array();
            foreach (range(1, $desktop->columns) as $col) {
                $columns[$col] = $col;
            }
            return $columns;
        } else {
            return false;
        }
    }

    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {
            if (isset($_POST['column_new'])) {
                Yii::debug('test');
                $this->column = (int)Yii::$app->request->post('column_new');
                // $this->save(false,false,false);
            }
        }
        return parent::beforeSave($insert);
    }

}