<?php

namespace panix\mod\admin\models;

use Yii;
/**
 * This is the model class for table "EngineLanguage".
 *
 * The followings are the available columns in table 'EngineLanguage':
 * @property integer $id
 * @property string $name Language name
 * @property string $code Url prefix
 * @property string $locale Language locale
 * @property boolean $default Is lang default
 * @property boolean $flag_name Flag image name
 */
class Languages extends \yii\db\ActiveRecord {

    private static $_languages;

    /**
     * @return string the associated database table name
     */
    public static function tableName() {
        return '{{%language}}';
    }

    public function rules() {
        return [
            [['name', 'code', 'locale'], 'required'],
            [['flag_name'], 'string', 'max' => 255],
            [['locale', 'name'], 'string', 'max' => 100],
            [['code'], 'string', 'max' => 25],
            [['is_default'], 'in', 'range' => [0, 1]],
        ];
    }

    public function beforeDelete() {
        if ($this->is_default)
            return false;
        return parent::beforeDelete();
    }

    public static function getArrayLanguage() {
        if ($this->is_default)
            return false;
        return parent::beforeDelete();
    }

    public static function getFlagImagesList() {
        Yii::import('system.utils.CFileHelper');
        $flagsPath = 'webroot.uploads.language';

        $result = array();
        $flags = CFileHelper::findFiles(Yii::getPathOfAlias($flagsPath));

        foreach ($flags as $f) {
            $parts = explode(DIRECTORY_SEPARATOR, $f);
            $fileName = end($parts);
            $result[$fileName] = $fileName;
        }

        return $result;
    }
    static $current = null;

//Получение текущего объекта языка
    static function getCurrent() {
        if (self::$current === null) {
            self::$current = self::getDefaultLang();
        }
        return self::$current;
    }

//Установка текущего объекта языка и локаль пользователя
    static function setCurrent($url = null) {
        $language = self::getLangByUrl($url);
        self::$current = ($language === null) ? self::getDefaultLang() : $language;
        Yii::$app->language = self::$current->code;
    }

//Получения объекта языка по умолчанию
    static function getDefaultLang() {
        return Languages::find()->where('`is_default` = :default', [':default' => 1])->one();
    }

//Получения объекта языка по буквенному идентификатору
    static function getLangByUrl($url = null) {
        if ($url === null) {
            return null;
        } else {
            $language = Languages::find()->where('code = :url', [':url' => $url])->one();
            if ($language === null) {
                return null;
            } else {
                return $language;
            }
        }
    }
    
    
        public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['date_create', 'date_update'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
            ],
                ],
        ];
    }

}

