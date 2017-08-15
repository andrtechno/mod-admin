<?php

namespace panix\admin\controllers\admin;

use Yii;
use panix\engine\controllers\AdminController;
use panix\admin\models\SettingsForm;

class SettingsController extends AdminController {



    public function actionIndex(){
        $this->pageName = Yii::t('app', 'SETTINGS');
        $this->breadcrumbs = [
            [
                'label' => $this->module->info['name'],
                'url' => $this->module->info['url'],
            ],
            $this->pageName
        ];
        
        $model = new SettingsForm();
        //Yii::$app->request->post()
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            // set flash (which will show on the current page)
          //  Yii::$app->session->setFlash("success", 'success save');
        }
        return $this->render('index', [
            'model'=>$model
        ]);
    }

}
