<?php

namespace panix\mod\admin\controllers\admin;

use Yii;
use panix\engine\controllers\AdminController;
use panix\mod\admin\models\SettingsForm;

class SettingsController extends AdminController {

    public $icon = 'settings';

    public function actionIndex(){
        $this->pageName = Yii::t('app', 'SETTINGS');
        $this->breadcrumbs = [
            [
                'label' => $this->module->info['label'],
                'url' => $this->module->info['url'],
            ],
            $this->pageName
        ];
        
        $model = new SettingsForm();
        //Yii::$app->request->post()
        if ($model->load(Yii::$app->request->post())) {
            $model->save();

        }
        return $this->render('index', [
            'model'=>$model
        ]);
    }

}
