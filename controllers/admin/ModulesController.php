<?php

namespace panix\mod\admin\controllers\admin;

use Yii;
use panix\engine\controllers\AdminController;
use panix\mod\admin\models\search\ModulesSearch;
use panix\mod\admin\models\Modules;

class ModulesController extends AdminController {

    public $icon = 'puzzle';

    public function actionIndex() {
        $this->pageName = Yii::t('admin/default', 'MODULES');
        $this->breadcrumbs[] = [
            'label' => Yii::t('admin/default', 'SYSTEM'),
            'url' => ['admin/default']
        ];

        $this->breadcrumbs[] = $this->pageName;

        $searchModel = new ModulesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());



        $mod = new Modules; //пересмотреть
        if (count($mod->getAvailable())) {
            $this->buttons = array(array(
                    'label' => Yii::t('admin/default', 'INSTALL', array('n' => count($mod->getAvailable()), 0)),
                    'url' => ['install'],
                    'options' => array('class' => 'btn btn-success')
            ));
        }



        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

    public function actionInstall($name = null) {


        $this->pageName = Yii::t('admin/default', 'LIST_MODULES');
        $this->breadcrumbs = [
            [
                'label' => Yii::t('admin/default', 'MODULES'),
                'url' => ['index']
            ],
            Yii::t('admin/default', 'INSTALLED')
        ];
        $mod = $result = new Modules;
        if ($name) {
            $result = Modules::install($name);
            if ($result) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('install', ['modules' => $mod->getAvailable()]);
    }

    public function actionUpdate() {
        $model = Modules::findOne($_GET['id']);
        $this->pageName = Yii::t('admin/default', 'MODULES');

        $this->breadcrumbs[] = [
            'label' => $this->pageName,
            'url' => ['/admin/app/modules']
        ];

        $this->breadcrumbs[] = Yii::t('app', 'UPDATE');



        $post = Yii::$app->request->post();


        if ($model->load($post) && $model->validate()) {

            $model->save();
            Yii::$app->cache->delete('EngineMainMenu-' . Yii::$app->language);
            return $this->redirect(array('index'));
        }

        return $this->render('update', array('model' => $model));
    }

    public function actionDelete() {
        if (Yii::$app->request->isPost) {
            $model = Modules::findOne($_GET['id']);
            if ($model) {
                $model->delete();
                Yii::$app->cache->flush();
            }

            if (!Yii::$app->request->isAjax)
                return $this->redirect('index');
        }
    }

    public function actionInsertSql() {
        $model = Modules::find(['name' => $_GET['mod']])->one();
        if ($model) {
            Yii::$app->db->import($model->name, 'insert.sql');
            Yii::$app->user->setFlash('success', 'База данных успешно импортирована.');
            return $this->redirect(array('/admin/app/modules'));
        } else {
            Yii::$app->user->setFlash('error', 'Ошибка импорта база данных.');
            return $this->redirect(array('/admin/app/modules'));
        }
    }

}
