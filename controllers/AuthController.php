<?php

namespace panix\mod\admin\controllers;

use Yii;
use panix\engine\controllers\AdminController;
use panix\mod\rbac\filters\AccessControl;

class AuthController extends AdminController
{

    public $layout = '@theme/views/layouts/auth';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'allowActions' => [
                    'index',
                    // The actions listed here will be allowed to everyone including guests.
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest)
            return $this->redirect(['/admin']);

        $model = Yii::$app->getModule("user")->model("LoginForm");
        if ($model->load(Yii::$app->request->post()) && $model->login(Yii::$app->getModule("user")->loginDuration)) {
            return $this->goBack(['/']);
        }

        // render
        return $this->render('login', [
            'model' => $model,
        ]);
    }

}
