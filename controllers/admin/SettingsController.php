<?php

namespace panix\mod\admin\controllers\admin;

use Yii;
use panix\engine\controllers\AdminController;
use panix\mod\admin\models\SettingsForm;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

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
        $oldNoImage = $model->no_image;


        //Yii::$app->request->post()
        if ($model->load(Yii::$app->request->post())) {

            $model->favicon = UploadedFile::getInstance($model, 'favicon');
            $model->no_image = UploadedFile::getInstance($model, 'no_image');
            if ($model->validate()) {

                if ($model->no_image) {
                    $fileName = 'no-image.' . $model->no_image->extension;
                    $model->no_image->saveAs(Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . $fileName);
                    $model->no_image = $fileName;
                } else {
                    $model->no_image = $oldNoImage;
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
                    if(file_exists(Yii::getAlias('@app/web/assets/') . 'favicon-16.' . $model->favicon->extension)){
                        FileHelper::unlink(Yii::getAlias('@app/web/assets/') . 'favicon-16.' . $model->favicon->extension);
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

    public function actionSendEmail()
    {
        try {
            $mailer = Yii::$app->mailer;
            $mailer->compose()
                ->setTo(Yii::$app->settings->get('app', 'email'))
                ->setHtmlBody('<b>Test mail text</b>')
                ->setSubject('Test mail subject')
                ->send();
            $result['success'] = true;
            $result['message'] = 'Email sent successfully';
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
        }

        return $this->asJson($result);
    }
}
