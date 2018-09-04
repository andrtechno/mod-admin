<?php

namespace panix\mod\admin\controllers\admin;

use Yii;
use panix\engine\controllers\AdminController;
use panix\mod\admin\models\Languages;
use panix\mod\admin\models\search\LanguagesSearch;

class LanguagesController extends AdminController {

    public function actions() {
        return [
            'switch' => [
                'class' => 'panix\engine\actions\SwitchAction',
                'modelClass' => LanguagesSearch::class,
            ],
        ];
    }
    public function actionIndex() {
        $this->pageName = Yii::t('admin/default', 'LANGUAGES');
        $this->buttons = [
            [
                'icon'=>'icon-add',
                'label' => Yii::t('admin/default', 'CREATE_LANG'),
                'url' => ['create'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        $this->breadcrumbs = [
            $this->pageName
        ];

        $searchModel = new LanguagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }
    public function actionUpdate($id = false) {


        if ($id === true) {
            $model = new Languages;
        } else {
            $model = $this->findModel($id);
        }


        $this->pageName = Yii::t('admin/default', 'MODULE_NAME');
        $this->buttons = [
            [
                'icon'=>'icon-add',
                'label' => Yii::t('admin/default', 'CREATE_LANG'),
                'url' => ['create'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        $this->breadcrumbs[] = [
            'label' => $this->pageName,
            'url' => ['index']
        ];

        $this->breadcrumbs[] = Yii::t('app', 'UPDATE');



        //$model->setScenario("admin");
        $post = Yii::$app->request->post();


        if ($model->load($post) && $model->validate()) {


            $model->save();

            Yii::$app->session->addFlash('success', \Yii::t('app', 'SUCCESS_CREATE'));
            if ($model->isNewRecord) {
                return Yii::$app->getResponse()->redirect(['/admin/app/languages']);
            } else {
                return Yii::$app->getResponse()->redirect(['/admin/app/languages/update', 'id' => $model->id]);
            }
        }

        echo $this->render('update', [
            'model' => $model,
        ]);
    }

    protected function findModel($id) {
        $model = new Languages;
        if (($model = $model::findOne($id)) !== null) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
    }

}
