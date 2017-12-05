<?php
namespace panix\mod\admin\blocks\hosting\form;
use Yii;
use panix\engine\Html;
class HostingWidgetForm extends \panix\engine\blocks_settings\WidgetFormModel {

    public $lat;
    public $lon;
    public $enable_sunrise;
    public $enable_sunset;
    public $enable_humidity;
    public $enable_pressure;
    public $enable_wind;
    public $units;
    public $title;
    public $apikey;

    public function rules() {
        return [
           // ['lat, lon, title, units, apikey', 'type'),
            ['apikey', 'required'],
            [['enable_sunrise', 'enable_sunset', 'enable_humidity', 'enable_pressure', 'enable_wind'], 'boolean']
        ];
    }

    public function getForm() {

        return array(
            'type' => 'form',
            'attributes' => array(
                'class' => 'form-horizontal',
                'id' => __CLASS__
            ),
            'elements' => array(
                'title' => array(
                    'label' => 'Заголовок блока',
                    'type' => 'text',
                ),
                'apikey' => array(
                    'label' => 'API ключ',
                    'type' => 'text',
                    'hint' => Yii::t('app', 'Для получение ключа, необходимо зарегистрироватся на сайте, {link} ', array(
                        '{link}' => Html::a('openweathermap.org', 'http://openweathermap.org', array('traget' => '_blank'))
                            )
                    )
                ),
                'lat' => array(
                    'label' => Yii::t('app', 'COORD_LAT'),
                    'type' => 'text',
                ),
                'lon' => array(
                    'label' => Yii::t('app', 'COORD_LON'),
                    'type' => 'text',
                ),
                'units' => array(
                    'label' => Yii::t('app', 'UNITS'),
                    'type' => 'SelectInput',
                    'data' => array('metric' => html_entity_decode('&deg;C'), 'imperial' => html_entity_decode('&deg;F'))
                ),
                'enable_wind' => array(
                    'label' => Yii::t('app', 'WIND'),
                    'type' => 'checkbox',
                ),
                'enable_sunrise' => array(
                    'label' => Yii::t('app', 'SUNRISE'),
                    'type' => 'checkbox',
                ),
                'enable_sunset' => array(
                    'label' => Yii::t('app', 'SUNSET'),
                    'type' => 'checkbox',
                ),
                'enable_humidity' => array(
                    'label' => Yii::t('app', 'HUMIDITY'),
                    'type' => 'checkbox',
                ),
                'enable_pressure' => array(
                    'label' => Yii::t('app', 'PRESSURE'),
                    'type' => 'checkbox',
                ),
            ),
            'buttons' => array(
                'submit' => array(
                    'type' => 'submit',
                    'class' => 'btn btn-success',
                    'label' => Yii::t('app', 'SAVE')
                )
            )
        );
    }

}
