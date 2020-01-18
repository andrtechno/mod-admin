<?php

namespace panix\mod\admin\controllers\admin;

use Yii;
use panix\engine\Html;
use panix\engine\blocks_settings\WidgetSystemManager;
use panix\engine\controllers\AdminController;
use yii\helpers\FileHelper;

class MailTemplateController extends AdminController
{

    public $icon = 'icon-chip';

    public function actionIndex()
    {

        $this->pageName = Yii::t('admin/default', 'WIDGETS');
        $this->breadcrumbs = [$this->pageName];


        return $this->render('index', []);
    }

    public function actionUpdate($alias)
    {
        if (empty($alias)) {
            return $this->redirect(['index']);
        }
        $this->pageName = Yii::t('admin/default', 'WIDGETS_UPDATE');
        $this->breadcrumbs = [
            [
                'label' => Yii::t('admin/default', 'WIDGETS'),
                'url' => ['index']
            ],
            $this->pageName
        ];

        $manager = new WidgetSystemManager;
        //$alias = str_replace('.','\\',$alias);

        $system = $manager->getSystemClass($alias);

        if (!$system) {
            Yii::$app->session->setFlash('error', 'Виджет не использует конфигурации');
            die('error');
            //   return $this->redirect(['index']);
        }


        // if (Yii::$app->request->isPost) {
        if ($system) {
            //die(basename(get_class($system)));
            //$system->attributes = $_POST[basename(get_class($system))];
            $post = Yii::$app->request->post();
            if ($post) {

                if ($system->load($post) && $system->validate()) {

                    $system->saveSettings($alias, $post);
                    Yii::$app->session->setFlash('success', Yii::t('app/default', 'SUCCESS_UPDATE'));
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app/default', 'ERROR_UPDATE'));
                }
            }
        }
        return $this->render('update', [
            'form' => $system->getConfigurationFormHtml($alias),
            //  'title'=>Yii::t(str_replace('Form','',get_class($system)).'.default','TITLE')
        ]);
    }

}
