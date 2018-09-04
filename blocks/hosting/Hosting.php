<?php

namespace panix\mod\admin\blocks\hosting;

use Yii;
use yii\helpers\Json;
use yii\web\HttpException;

class Hosting extends \panix\engine\data\Widget {

    protected $result;

    public function init() {
        parent::init();
         $this->view->registerCssFile($this->assetsUrl . '/css/weather.css');
         //$this->view->registerJsFile($this->assetsUrl . '/js/gradient-progress-bar.js');
    }

    public function run() {

        $this->result = $this->connect('info','hosting_quota');
//if($this->result->status=='error'){
//    throw new HttpException('err');
//}

//print_r($this->result->data->used);die;

//print_r($this->result->data->limit->inode);die;


        return $this->render($this->skin, ['result'=>$this->result]);
    }
    
        public function dirsize($dir) {
        if (is_file($dir))
            return array('size' => filesize($dir), 'howmany' => 0);
        if ($dh = opendir($dir)) {
            $size = 0;
            $n = 0;
            while (($file = readdir($dh)) !== false) {
                if ($file == '.' || $file == '..')
                    continue;
                $n++;
                $data = $this->dirsize($dir . '/' . $file);
                $size += $data['size'];
                $n += $data['howmany'];
            }
            closedir($dh);
            return array('size' => $size, 'howmany' => $n);
        }
        return array('size' => 0, 'howmany' => 0);
    }
    
    public function ssdProcentLimit() {
       // $dir = $this->dirsize($aliasPath);

        $limit = $this->result->data->limit->inode;
        $size = $this->result->data->used->inode;
        $procent = $limit / 100;
        return $size / $procent;
    }
    
    
        public function ssdProcentLimit2() {

        $limit = $this->result->data->limit->size;
        $size = $this->result->data->used->size;
        $procent = $limit / 100;
        return $size / $procent;
    }
    private function connect($method, $class) {
                $lang = Yii::$app->language;
        $curl = Yii::$app->curl;
        if ($curl) {
            $curl->options = array(
                'timeout' => 320,
                'setOptions' => array(
                    CURLOPT_POST => TRUE,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_HTTPHEADER => ["Content-Type: application/json; charset={$lang}"],
                    CURLOPT_HEADER => false,
                    CURLOPT_POSTFIELDS => Json::encode([
                        'auth_login' => $this->config['auth_login'],
                        'auth_token' => $this->config['auth_token'],
                        'account' => $this->config['account'],
                        'class' => $class,
                        'method' => $method,
                            'host'=>'corner-cms.com'
                            //'stack' => ['data']
                    ])
                ),
            );

            $connect = $curl->run('https://adm.tools/api.php');
            if (!$connect->hasErrors()) {
                $result = Json::decode($connect->getData(), false);
            } else {
                $result = $connect->getErrors();
            }
        } else {
            throw new Exception('error curl component');
        }
        return $result;
    }

}
