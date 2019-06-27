<?php


namespace panix\mod\admin\blocks\chat;

use Yii;
use yii\web\Response;
use panix\mod\admin\blocks\chat\models\Chat;
use panix\engine\data\Widget;

class ChatWidget extends Widget
{


    public $models;
    public $url;
    public $userModel;
    public $userField;
    public $model;
    public $loadingImage;

    public function init()
    {
        $this->model = new Chat();
        if ($this->userModel === NULL) {
            $this->userModel = Yii::$app->getUser()->identityClass;
        }

        $this->model->userModel = $this->userModel;

        if ($this->userField === NULL) {
            $this->userField = 'avatarImage';
        }

        $this->model->userField = $this->userField;

        $assets = ChatAsset::register($this->view);

        //Yii::$app->assetManager->publish("@admin/assets/images/chat/loadingAnimation.gif");
        //$this->loadingImage = Yii::$app->assetManager->getPublishedUrl("@admin/assets/images/chat/loadingAnimation.gif");
        $this->loadingImage = Yii::$app->controller->assetUrl . '/images/s-loading.gif';

        if (!$this->url)
            $this->url = '/admin/app/default/send-chat';

        parent::init();
    }

    public function run()
    {
        $model = new Chat();
        $model->userModel = $this->userModel;
        $model->userField = $this->userField;
        $data = $model->data();
        return $this->render($this->skin, [
            'data' => $data,
            'url' => $this->url,
            'userModel' => $this->userModel,
            'userField' => $this->userField,
            'loading' => $this->loadingImage
        ]);
    }

    public static function sendChat($post)
    {
        if (isset($post['message']))
            $message = $post['message'];
        if (isset($post['userfield']))
            $userField = $post['userfield'];
        if (isset($post['model']))
            $userModel = $post['model'];
        else
            $userModel = Yii::$app->getUser()->identityClass;

        $model = new Chat();
        $model->userModel = $userModel;
        if ($userField)
            $model->userField = $userField;

        if ($message) {
            $model->message = $message;
            $model->user_id = Yii::$app->user->id;

            if ($model->save()) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                \Yii::$app->response->data = $model->data();
                // return $model->data();
            } else {
                print_r($model->getErrors());
                exit(0);
            }
        } else {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            \Yii::$app->response->data = $model->data();

        }
    }

}
