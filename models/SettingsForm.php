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
    public $maintenance;
    public $maintenance_text;
    public $maintenance_allow_users;
    public $maintenance_allow_ips;
    public $censor;
    public $censor_words;
    public $censor_replace;
    public $timezone;
    public function rules() {
        return [
            [["email", 'sitename', 'pagenum','maintenance_allow_users','timezone'], "required"],
            ["email", "email"],
            [['theme', 'censor_words', 'censor_replace', 'maintenance_text', 'maintenance_allow_ips', 'maintenance_allow_users','timezone'], "string"],
            [['maintenance', 'censor'], 'boolean'],
            ["email", "filter", "filter" => "trim"],
        ];
    }

    public function getThemes() {
        return [
            'corner' => 'Corner',
            'test' => 'test',
        ];
    }

}
