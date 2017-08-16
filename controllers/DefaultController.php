<?php

namespace panix\mod\admin\controllers;

use Yii;
use panix\engine\controllers\AdminController;


class DefaultController extends AdminController {


    public function actionIndex(){

        return $this->render('index', [
            'model' => $model,
        ]);
    }

}
