<?php

namespace panix\mod\admin\controllers\admin;

use Yii;
use panix\engine\controllers\AdminController;

class ThemeController extends AdminController
{

    public $icon = 'settings';

    public function actionIndex() {
        $filePath = Yii::getAlias('@web_theme/settings');
        if (file_exists($filePath) && file_exists($filePath . DIRECTORY_SEPARATOR . 'ThemeForm.php')) {
            $this->pageName = Yii::t('admin/default', 'SETTINGS_THEME');
            $this->breadcrumbs = [
                [
                    'label' => $this->module->info['label'],
                    'url' => $this->module->info['url'],
                ],
                $this->pageName
            ];
            $model = Yii::createObject(['class'=>'app\web\themes\autima\settings\ThemeForm']);
            if ($model->load(Yii::$app->request->post())) {



                $logo = \yii\web\UploadedFile::getInstances($model, 'logo');

                if ($logo) {

                    $uniqueName = \panix\engine\CMS::gen(10);
                    $logo->saveAs(Yii::getAlias('@uploads') . '/' . $uniqueName . '_' . $logo->baseName . '.' . $logo->extension);


                }

                if ($model->validate()) {

                    $model->save();
                    return $this->redirect(['/admin/app/theme']);

                }

            }

            return $this->render('index', ['model' => $model]);
        } else {
            $this->error404('Настройки темы не найдены');
        }
    }
}
