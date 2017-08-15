<?php

namespace panix\admin\models;

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
        if ($this->default)
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

}

