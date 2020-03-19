<?php

namespace panix\mod\admin\components;

use panix\engine\Curl;
use Yii;
use yii\db\Exception;
use yii\helpers\Json;
use yii\httpclient\Client;

class YandexTranslate
{

    const API_KEY = 'trnsl.1.1.20141219T203729Z.c1345ed900582266.7501482db4e6901d183127f3933b578656878fcb';

    public $api_url = 'https://translate.yandex.net/api/v1.5/tr.json/translate';

    public function translitUrl($lang = array(), $text)
    {
        //if (!$params)
        $params = array();
        $params['key'] = self::API_KEY;
        $params['format'] = 'json';
        $params['text'] = $text;
        $params['lang'] = $lang[0] . '-' . $lang[1];
        $query = $this->api_url . '?' . $this->params($params);

        $res = $this->curl_get_contents($query);
        $json = Json::decode($res, true);
        $array = array(
            '/' => '',
            ' ' => '-',
            '(' => '',
            ')' => '',
            '−' => '-',
            ':' => '',
            ';' => '',
            '"' => '',
            '\'' => '',
            '&' => '',
            '!' => '',
            '?' => '',
            '—' => '',
            '.' => '',
            ',' => '',
            '»' => '',
            '«' => '',
        );
        $text = implode(array_slice(explode('<br>', wordwrap(trim(strip_tags(html_entity_decode($json['text'][0]))), 255, '<br>', false)), 0, 1));
        foreach ($array as $from => $to) {
            $text = str_replace($from, $to, $text);
        }
        return strtolower($text);
    }

    public function translate($lang = array(), $text, $each = false)
    {
        $params = array();
        $params['key'] = self::API_KEY;
        $params['format'] = 'html';
        $params['lang'] = $lang[0] . '-' . $lang[1];

        if ($each) {
            $nb_elem_per_page = 50;
            $number_of_pages = ceil(count($text) / $nb_elem_per_page);

            $result = array();
            for ($i = 0; $i < $number_of_pages + 1; $i++) {
                $offset = $i * $nb_elem_per_page;
                $result['response'][$offset] = array();
                $params['text'] = array();
                foreach (array_slice($text, $offset, $nb_elem_per_page) as $k => $val) {
                    $params['text'][$k] = $val;
                }
                $query = $this->api_url . '?' . $this->params($params);
                $resp = $this->curl_get_contents($query);
                $result['response'][$offset] = Json::decode($resp, true);

            }
            $response = array();
            //TODO need recoding this...

            if ($result['response'][0]['hasError']) {
                print_r($text);
                die;
            }
            foreach ($result['response'] as $t) {
                if (!$t['hasError']) {

                    foreach ($t['text'] as $tt) {
                        $response['text'][] = $tt;
                    }
                } else {
                    print_r($t);
                    die;
                }
            }
            return $response;
        } else {
            $params['text'] = $text;
            $query = $this->api_url . '?' . $this->params($params);
            $res = $this->curl_get_contents($query);
            return $res;
        }
    }


    public function translatefile($lang = array(), $text, $each = false)
    {
        $params = array();
        $params['key'] = self::API_KEY;
        $params['format'] = 'html';
        $params['lang'] = $lang[0] . '-' . $lang[1];


        $params['text'] = $text;
        $query = $this->api_url . '?' . $this->params($params);
        $res = $this->curl_get_contents($query);

        return $res;

    }

    public function checkConnect()
    {
        $params = array();
        $params['key'] = self::API_KEY;
        $params['format'] = 'html';
        $query = $this->api_url . '?' . $this->params($params);
        $res = $this->curl_get_contents($query);
        return $res;
    }

    private function curl_get_contents($url)
    {
        $client = new Client(['baseUrl' => $url]);
        $response = $client->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            //->addHeaders(['content-type' => 'application/json'])
            ->send();

        if ($response->isOk) {
            return $response->data;
        }else{
            return [];
        }
    }

    private function params($params)
    {
        $pice = array();
        foreach ($params as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $t) {
                    $pice[] = $k . '=' . urlencode($t);
                }
            } else {
                $pice[] = $k . '=' . urlencode($v);
            }
        }
        return implode('&', $pice);
    }
    /*
        public static function onlineLangs() {
            return array(
                'ar' => "Arabic",
                'hy' => "Armenian",
                'sq' => "Albanian",
                'az' => "Azerbaijani",
                'be' => "Belarusian",
                'bg' => "Bulgarian",
                'bs' => "Bosnian",
                'ca' => "Catalan",
                'cs' => "Czech",
                'hr' => "Croatian",
                'zh' => "Chinese",
                'da' => "Danish",
                'nl' => "Dutch",
                'de' => "German",
                'el' => "Greek",
                'ka' => "Georgian",
                'en' => "English",
                'et' => "Estonian",
                'fi' => "Finnish",
                'fr' => "French",
                'he' => "Hebrew",
                'hu' => "Hungarian",
                'id' => "Indonesian",
                'is' => "Icelandic",
                'it' => "Italian",
                'lt' => "Lithuanian",
                'lv' => "Latvian",
                'mk' => "Macedonian",
                'ms' => "Malay",
                'mt' => "Maltese",
                'no' => "Norwegian",
                'pl' => "Polish",
                'pt' => "Portuguese",
                'ro' => "Romanian",
                'ru' => "Russian",
                'sk' => "Slovak",
                'sl' => "Slovenian",
                'sr' => "Serbian",
                'sv' => "Swedish",
                'es' => "Spanish",
                'th' => "Thai",
                'tr' => "Turkish",
                'uk' => "Ukrainian",
                'vi' => "Vietnamese",
            );
        }*/

}
