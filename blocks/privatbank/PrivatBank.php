<?php

namespace panix\mod\admin\blocks\privatbank;

use Yii;
use panix\engine\data\Widget;
use yii\httpclient\Client;

class PrivatBank extends Widget
{

    public function run()
    {
        $date = date('d.m.Y', time() - 86400 * 1); // - 86400
        $result = Yii::$app->cache->get(__CLASS__ . Yii::$app->language);

        $error = true;

        // if ($this->config) {
        //if ($result === false) {

        $client = new Client(['baseUrl' => 'https://api.privatbank.ua/p24api/pubinfo?json&exchange']);

        $response = $client->createRequest()
            ->setMethod('GET')
            ->setData([
                'coursid' => 5,
            ])
            ->send();

        if ($response->isOk) {
            $result = $response->data;
        } else {
            $result = false;
        }

        $archiveRate = Yii::$app->cache->get(__CLASS__ . $date);
        if ($archiveRate === false) {
            $client = new Client(['baseUrl' => 'https://api.privatbank.ua/p24api/exchange_rates?json']);

            $response = $client->createRequest()
                ->setMethod('GET')
                ->setData([
                    'date' => $date,
                ])
                ->send();

            if ($response->isOk) {
                $archiveRate = $response->data;
            } else {
                $archiveRate = false;
            }
            Yii::$app->cache->set(__CLASS__ . $date, $archiveRate);
        }
        //   Yii::$app->cache->set(__CLASS__.Yii::$app->language, $result, 3600 * 2);
        // }
        // } else {
        //     $error = 'Ошибка настроек.';
        // }
        return $this->render($this->skin, ['result' => $result, 'result2' => $archiveRate, 'error' => $error]);
    }


}
