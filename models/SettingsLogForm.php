<?php

namespace panix\mod\admin\models;

use panix\engine\Html;
use panix\engine\SettingsModel;
use yii\web\UploadedFile;
use Yii;

class SettingsLogForm extends SettingsModel
{
    protected $module = 'admin';
    public static $category = 'logs';

    public $emails;
    public $query_execute;
    public $query_query;

    public static function defaultSettings()
    {
        return [
            'emails' => 'dev@pixelion.com.ua',
        ];
    }

    public function rules()
    {
        return [
            [['emails'], "string"],

            //[['email'], 'trim'],
            //[['mailer_transport_smtp_enabled', 'watermark_enable'], 'boolean'],
            //[['attachment_wm_corner', 'attachment_wm_offsety', 'attachment_wm_offsetx'], 'integer'],
            //[['email', 'sitename'], "required"],
            //['email', 'email'],
            //[['theme', 'censor_words'], "string"],
            [['query_query', 'query_execute'], 'boolean'],

            //[['captcha_class'], 'default'],

            //[['email', 'recaptcha_key', 'recaptcha_secret'], 'filter', 'filter' => 'trim'],
        ];
    }

}
