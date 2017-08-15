<?php

namespace panix\admin\controllers\admin;

use Yii;
use panix\engine\controllers\AdminController;
use panix\admin\models\Languages;

class LanguagesController extends AdminController {



    public function actionIndex(){
        $this->pageName = Yii::t('app', 'LANGUAGES');
        $this->breadcrumbs = [
            [
                'label' => $this->module->info['name'],
                'url' => $this->module->info['url'],
            ],
            $this->pageName
        ];
        
        $model = new Languages();

        return $this->render('index', [
            'model'=>$model
        ]);
    }

}
