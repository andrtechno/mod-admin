<?php
namespace panix\mod\admin\models;

use panix\engine\SettingsModel;
class SettingsDatabaseForm extends SettingsModel {


    protected $module = 'admin';
    protected $category = 'db';

    public $backup = false; //no record in db
    public $backup_limit = 1;


    public function rules() {
        return [
            [["backup_limit"], "required"],
            ["backup", "boolean"],
            [['backup_limit'], "number"],

        ];
    }

    


    public function save() {
       // unset($this->backup);
        parent::save();
    }

}
