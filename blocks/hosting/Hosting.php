<?php

namespace panix\mod\admin\blocks\hosting;

use panix\engine\data\Widget;
use yii\httpclient\Client;

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
     * @param $method
     * @param $class
     * @return bool|mixed
     */
    private function connect($method, $class)
    {
        $client = new Client(['baseUrl' => 'https://adm.tools/api.php']);
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setData([
                'auth_login' => $this->config->auth_login,
                'auth_token' => $this->config->auth_token,
                'account' => $this->config->account,
                'class' => $class,
                'method' => $method,
            ])
            ->setFormat(Client::FORMAT_JSON)
            ->addHeaders(['content-type' => 'application/json'])
            ->send();

        if ($response->isOk) {
            return $response->data;
        }
        return false;
    }

}
