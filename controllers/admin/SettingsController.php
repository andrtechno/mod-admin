<?php

namespace panix\mod\admin\controllers\admin;

use Yii;
use panix\engine\controllers\AdminController;
use panix\mod\admin\models\SettingsForm;
use yii\web\UploadedFile;

class SettingsController extends AdminController
{

    public $icon = 'settings';

    public function actionIndex()
    {
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
            if ($model->validate()) {
                $model->save();
                $file = UploadedFile::getInstance($model, 'attachment_wm_path');
                $file->saveAs(Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . 'watermark.' . $file->extension);


                $file = UploadedFile::getInstance($model, 'favicon');
                $file->saveAs(Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . 'favicon.' . $file->extension);

                return $this->redirect(['/admin/app/settings']);

            }

        }
        return $this->render('index', [
            'model' => $model
        ]);
    }

}
