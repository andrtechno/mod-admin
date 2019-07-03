<?php

namespace panix\mod\admin\controllers;

use panix\mod\user\models\forms\LoginForm;
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
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest)
            return $this->redirect(['/admin']);

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login(Yii::$app->settings->get('user', 'login_duration'))) {
            return $this->goBack(['/']);
        }

        // render
        return $this->render('login', [
            'model' => $model,
        ]);
    }

}
