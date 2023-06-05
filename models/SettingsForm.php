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

    public $mailer_transport_smtp_enabled;
    public $mailer_transport_smtp_host;
    public $mailer_transport_smtp_username;
    public $mailer_transport_smtp_password;
    public $mailer_transport_smtp_port;
    public $mailer_transport_smtp_encryption;
    public $mailer_sender_name;

    public $captcha_class;
    public $recaptcha_key;
    public $recaptcha_secret;

    public $no_image;
    public static $extensionFavicon = ['ico', 'png'];
    public static $extensionNoImage = ['jpg'];


    public static function defaultSettings()
    {
        return [
            'email' => 'dev@pixelion.com.ua',
            'pagenum' => 20,
            'sitename' => 'Pixelion',
            'theme' => 'basic',
            'backup_limit' => 10,
            'no_image' => 'no-image.jpg',
            'timezone' => 'Europe/Kiev',
            'site_close' => 0,
            'censor' => 1,
            'session_timeout' => 86000,
            'cookie_lifetime' => 86000,
            'censor_words' => 'bad',
            'censor_replace' => '***',
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
            'mailer_sender_name' => '',
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
            [['mailer_transport_smtp_host', 'mailer_transport_smtp_username', 'mailer_transport_smtp_password', 'mailer_transport_smtp_encryption', 'captcha_class', 'mailer_sender_name'], "string"],
            [['mailer_transport_smtp_port'], 'integer'],
            [['email', 'mailer_transport_smtp_port', 'mailer_transport_smtp_host', 'mailer_transport_smtp_username', 'mailer_transport_smtp_password', 'mailer_transport_smtp_encryption'], 'trim'],
            ['mailer_transport_smtp_encryption', 'in', 'range' => ['ssl', 'tls']],
            [['mailer_transport_smtp_enabled'], 'boolean'],

            [['session_timeout'], 'integer', 'max' => Yii::$app->session->timeout_default],
            [['cookie_lifetime'], 'integer', 'max' => Yii::$app->session->lifetime_default],


            [['email', 'sitename', 'pagenum', 'timezone', 'theme'], "required"],
            [['email'], 'email'],

            ['no_image', 'validateNoImageFile'],
            ['favicon', 'validateFaviconFile'],
            [['theme', 'censor_words', 'censor_replace', 'maintenance_text', 'maintenance_allow_ips', 'maintenance_allow_users', 'timezone', 'recaptcha_key', 'recaptcha_secret'], "string"],
            [['maintenance', 'censor'], 'boolean'],


            [['no_image'], 'file', 'skipOnEmpty' => true, 'extensions' => self::$extensionNoImage],
            //@todo need testing min params for PNG and ICO
            [['favicon'], 'image', 'skipOnEmpty' => true, 'checkExtensionByMimeType' => false, 'extensions' => self::$extensionFavicon,
                'minWidth' => 57,
                'minHeight' => 57],
            [['captcha_class'], 'default'],

            //[['email', 'recaptcha_key', 'recaptcha_secret'], 'filter', 'filter' => 'trim'],
        ];
    }


    public function renderNoImage()
    {
        $config = Yii::$app->settings->get('app');
        if (isset($config->no_image) && file_exists(Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . $config->no_image))
            return Html::img("/uploads/{$config->no_image}?" . time(), ['class' => 'img-fluid img-thumbnail mt-3']);
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



    public function validateNoImageFile($attribute)
    {
        $file = UploadedFile::getInstance($this, 'no_image');
        if ($file && !in_array($file->extension, self::$extensionNoImage))
            $this->addError($attribute, self::t('Error format image'));

    }

    public function validateFaviconFile($attribute)
    {
        $file = UploadedFile::getInstance($this, 'favicon');
        if ($file && !in_array($file->extension, self::$extensionFavicon))
            $this->addError($attribute, self::t('Error format image'));

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
