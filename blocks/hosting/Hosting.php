<?php

namespace panix\mod\admin\blocks\hosting;

use Yii;
use yii\base\Exception;
use yii\helpers\Json;
use panix\engine\data\Widget;

class Hosting extends Widget
{

    protected $result;

    public function init()
    {
        parent::init();
        $this->view->registerCssFile($this->assetsUrl . '/css/hosting.css');
    }

    public function run()
    {
        if($this->config){
            $this->result = $this->connect('info', 'hosting_quota');
        }else{
            $this->result = false;
        }
        $this->result = $this->connect('info', 'hosting_quota');
        return $this->render($this->skin, ['result' => $this->result]);
    }

    public function ssdPercentInode()
    {
        $limit = $this->result['data']['limit']['inode'];
        $size = $this->result['data']['used']['inode'];
        $procent = $limit / 100;
        return $size / $procent;
    }


    public function ssdPercentSize()
    {
        $limit = $this->result['data']['limit']['size'];
        $size = $this->result['data']['used']['size'];
        $procent = $limit / 100;
        return $size / $procent;
    }

    /**
     * Connection to Hosting api
     *
     * @param $method
     * @param $class
     * @return mixed
     * @throws Exception
     */
    private function connect($method, $class)
    {
        $curl = Yii::$app->curl;

        if ($curl) {
            $response = $curl->setRawPostData(Json::encode([
                    'auth_login' => $this->config->auth_login,
                    'auth_token' => $this->config->auth_token,
                    'account' => $this->config->account,
                    'class' => $class,
                    'method' => $method,
                ]))
                ->setHeaders(['Content-Type' => "application/json; charset=".Yii::$app->charset])
                ->post('https://adm.tools/api.php');

            $result = Json::decode($response);
            if ($curl->errorCode === null) {
                    return $result;

            } else {
                // List of curl error codes here https://curl.haxx.se/libcurl/c/libcurl-errors.html
                switch ($curl->errorCode) {

                    case 6:
                        //host unknown example
                        break;
                }
            }
        } else {
            throw new Exception('error curl component');
        }
        return $result;
    }

}
