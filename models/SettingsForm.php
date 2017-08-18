<?php

namespace panix\mod\admin\models;

use panix\engine\SettingsModel;
use yii\helpers\FileHelper;

class SettingsForm extends SettingsModel {

    protected $module = 'admin';
    protected $category = 'app';
    public $sitename;
    public $pagenum;
    public $email;
    public $theme;

    public function rules() {
        return [
            [["email", 'sitename', 'pagenum'], "required"],
            ["email", "email"],
            [['theme'], "string"],
            ["email", "filter", "filter" => "trim"],
        ];
    }



    public static function getThemes() {
        return [
            'corner'=>'Corner',
            'test'=>'test',
        ];
    }

}