<?php

namespace panix\mod\admin\controllers\admin;


use Yii;
use panix\engine\controllers\AdminController;
use panix\mod\admin\models\search\NotificationSearch;
use panix\mod\admin\models\Notification;

class NotificationController extends AdminController
{

    public $icon = 'puzzle';

    public function actionIndex()
    {
        $this->pageName = Yii::t('admin/default', 'NOTIFICATION');
        $this->breadcrumbs[] = [
            'label' => Yii::t('admin/default', 'SYSTEM'),
            'url' => ['admin/default']
        ];

        $this->breadcrumbs[] = $this->pageName;

        $searchModel = new NotificationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionRead(){

        Yii::$app->db->createCommand()->update(Notification::tableName(), ['status' => Notification::STATUS_READ], ['!=','status',Notification::STATUS_READ])->execute();
        return $this->asJson(['success'=>true]);
    }
}
