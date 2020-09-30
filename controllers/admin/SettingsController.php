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
        $this->pageName = Yii::t('app/default', 'SETTINGS');
        $this->view->params['breadcrumbs'] = [
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

            $model->favicon = UploadedFile::getInstance($model, 'favicon');
            $model->attachment_wm_path = UploadedFile::getInstance($model, 'attachment_wm_path');
            if ($model->validate()) {


                if ($model->attachment_wm_path) {
                    $model->attachment_wm_path->saveAs(Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . 'watermark.' . $model->attachment_wm_path->extension);
                    $model->attachment_wm_path = 'watermark.' . $model->attachment_wm_path->extension;
                } else {
                    $model->attachment_wm_path = $oldWatermark;
                }



                if ($model->favicon) {
                    $faviconFile = Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . 'favicon.' . $model->favicon->extension;
                    $model->favicon->saveAs($faviconFile);
                    if (in_array($model->favicon->extension, ['png'])){
                        $img = Yii::$app->img->load($faviconFile);
                        if ($img->getHeight() > 180 || $img->getWidth() > 180) {
                            $img->resize(180, 180);
                        }
                        $img->save($faviconFile);
                    }

                    $model->favicon = 'favicon.' . $model->favicon->extension;
                } else {
                    $model->favicon = $oldFavicon;
                }

                $model->save();
                Yii::$app->session->setFlash("success", Yii::t('app/default', 'SUCCESS_UPDATE'));
            }else{
               // print_r($model->errors);die;
            }
            return $this->refresh();
        }
        return $this->render('index', [
            'model' => $model
        ]);
    }

}
