<?php

namespace panix\mod\admin\models;

use panix\engine\Html;
use panix\engine\SettingsModel;
use yii\web\UploadedFile;
use Yii;

class SettingsForm extends SettingsModel
{
    const NAME = 'app';
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


    public $attachment_image_type;
    public $attachment_image_resize;
    public $attachment_wm_active;
    public $attachment_wm_path;
    public $attachment_wm_corner;
    public $attachment_wm_offsetx;
    public $attachment_wm_offsety;

    public $mailer_transport_smtp_enabled;
    public $mailer_transport_smtp_host;
    public $mailer_transport_smtp_username;
    public $mailer_transport_smtp_password;
    public $mailer_transport_smtp_port;
    public $mailer_transport_smtp_encryption;

    public function renderWatermarkImage()
    {
        if (file_exists(Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . 'watermark.png'))
            return Html::img('/uploads/watermark.png?' . time(), ['class' => 'img-fluid']);
    }

    public function validateWatermarkFile($attr)
    {
        $file = UploadedFile::getInstance($this, 'attachment_wm_path');
        if ($file) {
            $allowedExts = ['jpg', 'gif', 'png'];
            if (!in_array($file->getExtension(), $allowedExts))
                $this->addError($attr, self::t('ERROR_WM_NO_IMAGE'));
        }
    }

    public function getWatermarkCorner()
    {
        return array(
            1 => self::t('CORNER_LEFT_TOP'),
            2 => self::t('CORNER_RIGHT_TOP'),
            3 => self::t('CORNER_LEFT_BOTTOM'),
            4 => self::t('CORNER_RIGHT_BOTTOM'),
            5 => self::t('CORNER_CENTER'),
        );
    }

    public function rules()
    {

        return [
            //Mailer smtp
            [['mailer_transport_smtp_host', 'mailer_transport_smtp_username', 'mailer_transport_smtp_password', 'mailer_transport_smtp_encryption'], "string"],
            [['mailer_transport_smtp_port'], 'integer'],
            [['mailer_transport_smtp_port', 'mailer_transport_smtp_host', 'mailer_transport_smtp_username', 'mailer_transport_smtp_password', 'mailer_transport_smtp_encryption'], 'trim'],
            ['mailer_transport_smtp_encryption', 'in', 'range' => ['ssl', 'tls']],
            ['mailer_transport_smtp_enabled', 'boolean'],


            [['attachment_wm_corner', 'attachment_wm_offsety', 'attachment_wm_offsetx'], 'integer'],
            [['email', 'sitename', 'pagenum', 'maintenance_allow_users', 'timezone', 'theme', 'attachment_wm_offsetx', 'attachment_wm_offsety', 'attachment_wm_corner', 'attachment_image_type'], "required"],
            ['email', 'email'],
            ['attachment_wm_path', 'validateWatermarkFile'],
            [['theme', 'censor_words', 'censor_replace', 'maintenance_text', 'maintenance_allow_ips', 'maintenance_allow_users', 'timezone', 'attachment_wm_active', 'attachment_image_resize'], "string"],
            [['maintenance', 'censor'], 'boolean'],
            ['email', 'filter', 'filter' => 'trim'],
        ];
    }

    public function getThemes()
    {
        $themes = [];
        $themesList = array_filter(glob('web/themes/*'), 'is_dir');
        foreach ($themesList as $theme) {

            if (basename($theme) != 'dashboard') {
                $themes[basename($theme)] = ucfirst(basename($theme));
            }
        }
        return $themes;
    }

}
