<?php

namespace panix\mod\admin\controllers;

use Yii;
use panix\engine\controllers\AdminController;
use yii\filters\AccessControl;

class AuthController extends AdminController {

    public $layout = '@app/web/themes/admin/views/layouts/auth';
   public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionIndex() {
        $model = Yii::$app->getModule("user")->model("LoginForm");
        if ($model->load(Yii::$app->request->post()) && $model->login(Yii::$app->getModule("user")->loginDuration)) {
            return $this->goBack(array('/admin'));
        }

        // render
        return $this->render('login', [
            'model' => $model,
        ]);


    }

}
