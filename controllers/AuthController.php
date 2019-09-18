<?php

namespace panix\mod\admin\controllers;

use Yii;
use panix\mod\user\models\forms\LoginForm;
use panix\engine\controllers\AdminController;
use panix\mod\rbac\filters\AccessControl;

/**
 * Class AuthController
 * @package panix\mod\admin\controllers
 */
class AuthController extends AdminController
{

    public $layout = '@theme/views/layouts/auth';

    /**
     * @inheritdoc
     */
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

    /**
     * Display admin panel login
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest)
            return $this->redirect(['/admin']);

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login((int) Yii::$app->settings->get('user', 'login_duration')  * 86400)) {
            return $this->goBack(['/admin']);
        }

        // render
        return $this->render('login', [
            'model' => $model,
        ]);
    }

}
