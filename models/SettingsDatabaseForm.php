<?php

namespace panix\mod\admin\models;

use Yii;
use panix\engine\SettingsModel;

class SettingsDatabaseForm extends SettingsModel
{

    protected $module = 'admin';
    public static $category = 'db';

    public $backup = false; //no record in db
    public $backup_limit = 1;


    public function rules()
    {
        return [
            [["backup_limit"], "required"],
            ["backup", "boolean"],
            [['backup_limit'], "number"],

        ];
    }

    public function beforeValidate()
    {
        if (!Yii::$app->db->checkLimit()) {
            return true;
        }
        return parent::beforeValidate();
    }


    public function save()
    {
        // unset($this->backup);
        parent::save();
    }

}
