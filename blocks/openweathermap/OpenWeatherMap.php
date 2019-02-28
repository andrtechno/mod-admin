<?php

namespace panix\mod\admin\blocks\openweathermap;

use Yii;
use yii\helpers\Json;
use panix\engine\data\Widget;

class OpenWeatherMap extends Widget {

    public function init() {
        parent::init();
        $this->view->registerCssFile($this->assetsUrl . '/css/weather.css');
    }



    public function run() {
        $result = Yii::$app->cache->get(__CLASS__);
        if ($result === false) {
            $curl = Yii::$app->curl;
            if ($curl) {
                $curl->options = array(
                    'timeout' => 320,
                    'setOptions' => array(
                        CURLOPT_HEADER => false
                    ),
                );

                $connect = $curl->run('http://api.openweathermap.org/data/2.5/weather?lat=' . $this->config->lat . '&lon=' . $this->config->lon . '&units=' . $this->config->units . '&cnt=10&lang=' . Yii::$app->language . '&appid=' . $this->config->apikey);
                if (!$connect->hasErrors()) {
                    $result = Json::decode($connect->getData(), false);
                } else {
                    $result = $connect->getErrors();
                }

                Yii::$app->cache->set(__CLASS__, $result, 3600);
            } else {
                throw new Exception('error curl component');
            }
        }
        return $this->render($this->skin, ['result' => $result]);
    }

    public function degToCompass($num) {
        $val = floor(($num / 22.5) + .5);
        $arr = ["N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW"];
        return Yii::t('wgt_OpenWeatherMap/default', $arr[($val % 16)]);
    }

    public function degToCompassImage($num) {
        $val = floor(($num / 22.5) + .5);
        $arr = ["wind1", "wind2", "wind8", "wind2", "wind7", "ESE", "SE", "SSE", "wind5", "wind4", "SW", "WSW", "wind3", "WNW", "wind8", "NNW"];
        return '<div class="wind ' . $arr[($val % 16)] . '"></div>';
    }

    public function getDeg() {
        return ($this->config->units == 'metric') ? '&deg;C' : '&deg;F';
    }

}
