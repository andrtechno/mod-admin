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
        $oldFavicon = $model->favicon;
        $oldWatermark = $model->attachment_wm_path;


        //Yii::$app->request->post()
        if ($model->load(Yii::$app->request->post())) {


            if ($model->validate()) {

                $attachment_wm_path = UploadedFile::getInstance($model, 'attachment_wm_path');
                if ($attachment_wm_path) {
                    $attachment_wm_path->saveAs(Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . 'watermark.' . $attachment_wm_path->extension);
                    $model->attachment_wm_path = 'watermark.' . $attachment_wm_path->extension;
                } else {
                    $model->attachment_wm_path = $oldWatermark;
                }

                $favicon = UploadedFile::getInstance($model, 'favicon');

                if ($favicon) {
                    $favicon->saveAs(Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . 'favicon.' . $favicon->extension);
                    $model->favicon = 'favicon.' . $favicon->extension;
                } else {
                    $model->favicon = $oldFavicon;
                }


                $model->save();
                return $this->redirect(['/admin/app/settings']);
            }
        }
        return $this->render('index', [
            'model' => $model
        ]);
    }

}
