<?php

namespace panix\admin\models;

use panix\engine\SettingsModel;

class SettingsForm extends SettingsModel {

    protected $module = 'admin';
    protected $category = 'app';
    public $sitename;
    public $pagenum;
    public $email;
    public $grid_btn_icon_size;

    public function rules() {
        return [
            [["email", 'sitename', 'pagenum'], "required"],
            ["email", "email"],
            [['grid_btn_icon_size'], "string"],
            ["email", "filter", "filter" => "trim"],
        ];
    }



    public static function getButtonIconSizeList() {
        return [
            ''=>'Normal',
            'fa-lg'=>'x1',
            'fa-2x'=>'x2',
            'fa-3x'=>'x3',
            //'fa-4x'=>'x4',
            //'fa-5x'=>'x5',
        ];
    }

}