<?php

namespace panix\mod\admin\blocks\openweathermap;

use Yii;
use panix\engine\data\Widget;
use yii\httpclient\Client;

class OpenWeatherMap extends Widget
{

    public function init()
    {
        parent::init();
        $this->view->registerCssFile($this->assetsUrl . '/css/weather.css');
    }


    public function run()
    {
        $result = Yii::$app->cache->get(__CLASS__);

        if ($result === false) {
            $client = new Client(['baseUrl' => 'http://api.openweathermap.org/data/2.5/weather']);
            $response = $client->createRequest()
                ->setMethod('GET')
                ->setData([
                    'lat' => $this->config->lat,
                    'lon' => $this->config->lon,
                    'units' => $this->config->units,
                    'lang' => Yii::$app->language,
                    'cnt' => 10,
                    'appid' => $this->config->apikey,
                ])
                ->send();

            if ($response->isOk) {
                $result = $response->data;
            } else {
                $result = false;
            }

            Yii::$app->cache->set(__CLASS__, $result, 3600);
        }
        return $this->render($this->skin, ['result' => $result]);
    }

    public function degToCompass($num)
    {
        $val = floor(($num / 22.5) + .5);
        $arr = ["N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW"];
        return Yii::t('wgt_OpenWeatherMap/default', $arr[($val % 16)]);
    }

    public function degToCompassImage($num)
    {
        $val = floor(($num / 22.5) + .5);
        $arr = ["wind1", "wind2", "wind8", "wind2", "wind7", "ESE", "SE", "SSE", "wind5", "wind4", "SW", "WSW", "wind3", "WNW", "wind8", "NNW"];
        return '<div class="wind ' . $arr[($val % 16)] . '"></div>';
    }

    public function getDeg()
    {
        return ($this->config->units == 'metric') ? '&deg;C' : '&deg;F';
    }

}
