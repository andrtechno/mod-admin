<?php

namespace panix\mod\admin\controllers\admin;


use Yii;
use panix\engine\controllers\AdminController;
use panix\mod\admin\models\DynamicForm;
use panix\mod\admin\models\search\DynamicFormSearch;

class DynamicFormController extends AdminController
{

    public $icon = '';

    public function actionIndex()
    {
        $this->pageName = Yii::t('admin/default', 'DYNAMIC_FORM');
        if (Yii::$app->user->can("/{$this->module->id}/{$this->id}/*") || Yii::$app->user->can("/{$this->module->id}/{$this->id}/create")) {
            $this->buttons = [
                [
                    'icon' => 'add',
                    'label' => Yii::t('admin/default', 'create'),
                    'url' => ['create'],
                    'options' => ['class' => 'btn btn-success']
                ]
            ];
        }
        $this->view->params['breadcrumbs'] = [
            $this->pageName
        ];

        $searchModel = new DynamicFormSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionUpdate($id = false)
    {
        $model = DynamicForm::findModel($id);
        $isNew = $model->isNewRecord;
        $this->pageName = Yii::t('admin/default', 'DYNAMIC_FORM');

        $this->view->params['breadcrumbs'][] = [
            'label' => $this->pageName,
            'url' => ['index']
        ];

        $this->view->params['breadcrumbs'][] = Yii::t('app/default', 'UPDATE');


        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if ($model->validate()) {
                $model->save();
                return $this->redirectPage($isNew, $post);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        return $this->actionUpdate(false);
    }
}
