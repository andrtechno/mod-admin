<?php

namespace panix\mod\admin\models;

use panix\engine\Html;
use panix\engine\SettingsModel;
use yii\web\UploadedFile;
use Yii;

class SettingsForm extends SettingsModel
{
    protected $module = 'admin';
    public static $category = 'app';
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
    public $favicon;
    public $session_timeout;
    public $cookie_lifetime;

    public $watermark_enable;
    public $attachment_image_type;
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
    public $captcha_class;
    public $recaptcha_key;
    public $recaptcha_secret;


    private $extensionFavicon = ['ico', 'png'];
    private $extensionWatermark = ['png'];

    public static function defaultSettings()
    {
        return [
            'email' => 'dev@pixelion.com.ua',
            'pagenum' => 20,
            'sitename' => 'Pixelion',
            'theme' => 'basic',
            'backup_limit' => 10,
            'timezone' => 'Europe/Kiev',
            'site_close' => 0,
            'censor' => 1,
            'session_timeout' => 86000,
            'cookie_lifetime' => 86000,
            'censor_words' => 'bad',
            'censor_replace' => '***',
            'watermark_enable' => true,
            'attachment_wm_path' => 'watermark.png',
            'attachment_image_type' => 'render',
            'attachment_wm_offsety' => 10,
            'attachment_wm_offsetx' => 10,
            'attachment_wm_corner' => 5,
            'mailer_transport_smtp_enabled' => '',
            'mailer_transport_smtp_username' => '',
            'mailer_transport_smtp_password' => '',
            'mailer_transport_smtp_host' => 'smtp.gmail.com',
            'mailer_transport_smtp_port' => '465',
            'mailer_transport_smtp_encryption' => 'ssl',
            'captcha_class' => '\yii\captcha\Captcha',
            'recaptcha_key' => '',
            'recaptcha_secret' => '',
            'favicon' => 'favicon.ico',
        ];
    }

    public static function captchaList()
    {
        return [
            '\yii\captcha\Captcha' => 'Core captcha',
            '\panix\engine\widgets\recaptcha\v2\ReCaptcha' => 'ReCaptcha (v2)',
            '\panix\engine\widgets\recaptcha\v3\ReCaptcha' => 'ReCaptcha (v3)',
        ];
    }

    public static function captchaConfig()
    {
        return [
            '\yii\captcha\Captcha' => [
                'captchaAction' => '/captcha',
            ],
            '\panix\engine\widgets\recaptcha\v2\ReCaptcha' => [

            ],
            '\panix\engine\widgets\recaptcha\v3\ReCaptcha' => [
                //'threshold' => 0.5,
                // 'action' => 'homepage',
            ],
        ];
    }

    public function rules()
    {

        return [
            //Mailer smtp
            [['mailer_transport_smtp_host', 'mailer_transport_smtp_username', 'mailer_transport_smtp_password', 'mailer_transport_smtp_encryption', 'captcha_class'], "string"],
            [['mailer_transport_smtp_port'], 'integer'],
            [['email', 'mailer_transport_smtp_port', 'mailer_transport_smtp_host', 'mailer_transport_smtp_username', 'mailer_transport_smtp_password', 'mailer_transport_smtp_encryption'], 'trim'],
            ['mailer_transport_smtp_encryption', 'in', 'range' => ['ssl', 'tls']],
            [['mailer_transport_smtp_enabled', 'watermark_enable'], 'boolean'],
            [['attachment_wm_corner', 'attachment_wm_offsety', 'attachment_wm_offsetx'], 'integer'],

            [['session_timeout'], 'integer','max'=>Yii::$app->session->timeout_default],
            [['cookie_lifetime'], 'integer','max'=>Yii::$app->session->lifetime_default],



            [['email', 'sitename', 'pagenum', 'timezone', 'theme', 'attachment_wm_offsetx', 'attachment_wm_offsety', 'attachment_wm_corner', 'attachment_image_type'], "required"],
            ['email', 'email'],
            ['attachment_wm_path', 'validateWatermarkFile'],
            ['favicon', 'validateFaviconFile'],
            [['theme', 'censor_words', 'censor_replace', 'maintenance_text', 'maintenance_allow_ips', 'maintenance_allow_users', 'timezone', 'recaptcha_key', 'recaptcha_secret'], "string"],
            [['maintenance', 'censor'], 'boolean'],


            [['attachment_wm_path'], 'file', 'skipOnEmpty' => true, 'extensions' => $this->extensionWatermark],
            [['favicon'], 'file', 'skipOnEmpty' => true, 'checkExtensionByMimeType' => false, 'extensions' => $this->extensionFavicon],
            [['captcha_class'], 'default'],

            //[['email', 'recaptcha_key', 'recaptcha_secret'], 'filter', 'filter' => 'trim'],
        ];
    }

    public function renderWatermarkImage()
    {
        $config = Yii::$app->settings->get('app');
        if (isset($config->attachment_wm_path) && file_exists(Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . $config->attachment_wm_path))
            return Html::img("/uploads/{$config->attachment_wm_path}?" . time(), ['class' => 'img-fluid img-thumbnail mt-3']);
    }

    public function renderFaviconImage()
    {
        $config = Yii::$app->settings->get('app');
        if (isset($config->favicon) && file_exists(Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . $config->favicon)) {
            return Html::img("/uploads/{$config->favicon}?" . time(), ['class' => 'img-fluid img-thumbnail mt-3']);
        } elseif (isset($config->favicon) && file_exists(Yii::getAlias('@app/web') . DIRECTORY_SEPARATOR . $config->favicon)) {
            return Html::img("/{$config->favicon}?" . time(), ['class' => 'img-fluid img-thumbnail mt-3']);
        }
    }


    public function validateWatermarkFile($attribute)
    {
        $file = UploadedFile::getInstance($this, 'attachment_wm_path');
        if ($file && !in_array($file->extension, $this->extensionWatermark))
            $this->addError($attribute, self::t('ERROR_WM_NO_IMAGE'));

    }

    public function validateFaviconFile($attribute)
    {
        $file = UploadedFile::getInstance($this, 'favicon');
        if ($file && !in_array($file->extension, $this->extensionFavicon))
            $this->addError($attribute, self::t('Error format image'));

    }

    public function getWatermarkCorner()
    {
        return [
            1 => self::t('WM_POS_LEFT_TOP'),
            2 => self::t('WM_POS_RIGHT_TOP'),
            3 => self::t('WM_POS_LEFT_BOTTOM'),
            4 => self::t('WM_POS_RIGHT_BOTTOM'),
            5 => self::t('WM_POS_CENTER'),
            6 => self::t('WM_POS_CENTER_TOP'),
            7 => self::t('WM_POS_CENTER_BOTTOM'),
            8 => self::t('WM_POS_LEFT_CENTER'),
            9 => self::t('WM_POS_RIGHT_CENTER'),
            10 => self::t('WM_POS_REPEAT'),
        ];
    }


    public function themesList()
    {
        $themes = [];
        $themesList = array_filter(glob(Yii::getAlias('@app/web/themes') . '/*'), 'is_dir');
        foreach ($themesList as $theme) {
            if (basename($theme) != 'dashboard') {
                $themes[basename($theme)] = ucfirst(basename($theme));
            }
        }
        return $themes;
    }

}
