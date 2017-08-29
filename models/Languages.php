<?php

namespace panix\mod\admin\models;

use Yii;

class Languages extends \panix\engine\WebModel {
    const MODULE_ID = 'admin';
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
            [['name'], 'string', 'max' => 100],
            [['code'], 'string', 'max' => 2],
            [['locale'], 'string', 'max' => 5],
            [['is_default'], 'in', 'range' => [0, 1]],
        ];
    }

    public function beforeDelete() {
        if ($this->is_default){
            return false;
        }
        return parent::beforeDelete();
    }

    public static function getArrayLanguage() {
        if ($this->is_default)
            return false;
        return parent::beforeDelete();
    }

    public function getFlagUrl(){
        return '@web/uploads/language/'.$this->code.'.png';
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



}
