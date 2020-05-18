<?php

namespace panix\mod\admin\models;

use Yii;
use panix\mod\admin\models\query\LanguagesQuery;
use panix\engine\db\ActiveRecord;

/**
 * Class Languages
 * @package panix\mod\admin\models
 *
 * @property string $code
 * @property string $name
 * @property string $locale
 * @property integer $is_default
 */
class Languages extends ActiveRecord
{
    const MODULE_ID = 'admin';
    private static $_languages;

    public static function find()
    {
        return new LanguagesQuery(get_called_class());
    }

    public static function tableName()
    {
        return '{{%language}}';
    }

    public function rules()
    {
        return [
            [['name', 'code', 'locale', 'slug'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['code'], 'string', 'max' => 2],
            [['locale'], 'string', 'max' => 5],
            [['is_default'], 'in', 'range' => [0, 1]],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->is_default) {
            $model = Languages::updateAll(['is_default' => 0], 'id!=:id', [':id' => $this->id]);
        }
        //  $this->is_default=1;

        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeDelete()
    {
        if ($this->is_default) {
            return false;
        }
        return parent::beforeDelete();
    }

    public function getArrayLanguage()
    {
        if ($this->is_default)
            return false;
        return parent::beforeDelete();
    }

    public function getFlagUrl()
    {
        return '/uploads/language/' . $this->slug . '.png';
    }

    static $current = null;

//Получение текущего объекта языка
    static function getCurrent()
    {
        if (self::$current === null) {
            self::$current = self::getDefaultLang();
        }
        return self::$current;
    }

//Установка текущего объекта языка и локаль пользователя
    static function setCurrent($url = null)
    {
        $language = self::getLangByUrl($url);
        self::$current = ($language === null) ? self::getDefaultLang() : $language;
        Yii::$app->language = self::$current->code;
    }

//Получения объекта языка по умолчанию
    static function getDefaultLang()
    {
        return Languages::find()->where('`is_default` = :default', [':default' => 1])->one();
    }

//Получения объекта языка по буквенному идентификатору
    static function getLangByUrl($url = null)
    {
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

    /**
     * Locale {@link http://lh.2xlibre.net/locales} helper
     * @return array
     */
    public static function langListArray()
    {
        return array(
            array('en', array('id' => 'en', 'name' => 'English', 'image' => 'en.png', 'locale' => 'en_US')),
            array('uk', array('id' => 'ua', 'name' => 'Ukrainian', 'image' => 'ua.png', 'locale' => 'uk_UA')),
            array('ru', array('id' => 'ru', 'name' => 'Russian', 'image' => 'ru.png', 'locale' => 'ru_RU')),
            array('ar', array('id' => 'ar', 'name' => 'Arabic', 'image' => 'ps.png', 'locale' => 'ar_AE')),
            array('hy', array('id' => 'hy', 'name' => 'Armenian', 'image' => 'am.png', 'locale' => 'hy_AM')),
            array('sq', array('id' => 'sq', 'name' => 'Albanian', 'image' => 'al.png', 'locale' => 'sq_AL')),
            array('az', array('id' => 'az', 'name' => 'Azerbaijani', 'image' => 'az.png', 'locale' => 'az_AZ')),
            array('be', array('id' => 'be', 'name' => 'Belarusian', 'image' => 'by.png', 'locale' => 'be_BY')),
            array('bg', array('id' => 'bg', 'name' => 'Bulgarian', 'image' => 'bg.png', 'locale' => 'bg_BG')),
            array('bs', array('id' => 'bs', 'name' => 'Bosnian', 'image' => 'ba.png', 'locale' => 'bs_BA')),
            array('ca', array('id' => 'ca', 'name' => 'Catalan', 'image' => 'catalonia.png', 'locale' => 'ca_ES')),
            array('cs', array('id' => 'cs', 'name' => 'Czech', 'image' => 'cz.png', 'locale' => 'cs_CZ')),
            array('hr', array('id' => 'hr', 'name' => 'Croatian', 'image' => 'hr.png', 'locale' => 'hr_HR')),
            array('zh', array('id' => 'zh', 'name' => 'Chinese', 'image' => 'cn.png', 'locale' => 'zh_CN')),
            array('da', array('id' => 'da', 'name' => 'Danish', 'image' => 'dk.png', 'locale' => 'da_DK')),
            array('nl', array('id' => 'nl', 'name' => 'Dutch', 'image' => 'nl.png', 'locale' => 'nl_AW')),
            array('de', array('id' => 'de', 'name' => 'German', 'image' => 'de.png', 'locale' => 'de_DE')),
            array('el', array('id' => 'el', 'name' => 'Greek', 'image' => 'gr.png', 'locale' => 'el_GR')),
            array('ka', array('id' => 'ka', 'name' => 'Georgian', 'image' => 'ge.png', 'locale' => 'ka_GE')),
            array('et', array('id' => 'et', 'name' => 'Estonian', 'image' => 'ee.png', 'locale' => 'et_EE')),
            array('fi', array('id' => 'fi', 'name' => 'Finnish', 'image' => 'fi.png', 'locale' => 'fi_FI')),
            array('fr', array('id' => 'fr', 'name' => 'French', 'image' => 'fr.png', 'locale' => 'fr_FR')),
            array('he', array('id' => 'he', 'name' => 'Hebrew', 'image' => 'hn.png', 'locale' => 'he_IL')),
            array('hu', array('id' => 'hu', 'name' => 'Hungarian', 'image' => 'hu.png', 'locale' => 'hu_HU')),
            array('id', array('id' => 'id', 'name' => 'Indonesian', 'image' => 'id.png', 'locale' => 'id_ID')),
            array('is', array('id' => 'is', 'name' => 'Icelandic', 'image' => 'is.png', 'locale' => 'is_IS')),
            array('it', array('id' => 'it', 'name' => 'Italian', 'image' => 'ie.png', 'locale' => 'it_IT')),
            array('lt', array('id' => 'lt', 'name' => 'Lithuanian', 'image' => 'lt.png', 'locale' => 'lt_LT')),
            array('lv', array('id' => 'lv', 'name' => 'Latvian', 'image' => 'lv.png', 'locale' => 'lv_LV')),
            array('mk', array('id' => 'mk', 'name' => 'Macedonian', 'image' => 'mk.png', 'locale' => 'mk_MK')),
            array('ms', array('id' => 'ms', 'name' => 'Malay', 'image' => 'my.png', 'locale' => 'ms_MY')),
            array('mt', array('id' => 'mt', 'name' => 'Maltese', 'image' => 'mt.png', 'locale' => 'mt_MT')),
            array('no', array('id' => 'no', 'name' => 'Norwegian', 'image' => 'no.png', 'locale' => 'nn_NO')),
            array('pl', array('id' => 'pl', 'name' => 'Polish', 'image' => 'pl.png', 'locale' => 'pl_PL')),
            array('pt', array('id' => 'pt', 'name' => 'Portuguese', 'image' => 'pt.png', 'locale' => 'pt_PT')),
            array('ro', array('id' => 'ro', 'name' => 'Romanian', 'image' => 'ro.png', 'locale' => 'ro_RO')),
            array('sk', array('id' => 'sk', 'name' => 'Slovak', 'image' => 'sk.png', 'locale' => 'sk_SK')),
            array('sl', array('id' => 'sl', 'name' => 'Slovenian', 'image' => 'si.png', 'locale' => 'sl_SI')),
            array('sr', array('id' => 'sr', 'name' => 'Serbian', 'image' => 'si.png', 'locale' => 'sr_RS')),
            array('sv', array('id' => 'sv', 'name' => 'Swedish', 'image' => 'se.png', 'locale' => 'sv_SE')),
            array('es', array('id' => 'es', 'name' => 'Spanish', 'image' => 'es.png', 'locale' => 'an_ES')),
            array('th', array('id' => 'th', 'name' => 'Thai', 'image' => 'th.png', 'locale' => 'th_TH')),
            array('tr', array('id' => 'tr', 'name' => 'Turkish', 'image' => 'tr.png', 'locale' => 'tr_TR')),
            array('vi', array('id' => 'vi', 'name' => 'Vietnamese', 'image' => 'vn.png', 'locale' => 'vi_VN')),
        );
    }

    public function getDataLangList()
    {
        $currLangs = Yii::$app->languageManager->getCodes();
        $result = array();
        foreach (self::langListArray() as $lang) {
            // if (!array_keys($currLangs, $lang[0])) {
            if ($currLangs[0] !== $lang[0]) {
                $result[$lang[0]] = $lang[1]['name'];
            }
        }
        return $result;
    }

}
