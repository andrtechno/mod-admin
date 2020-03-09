<?php

namespace panix\mod\admin\controllers\admin;


use Yii;
use yii\web\Response;
use panix\engine\controllers\AdminController;
use panix\mod\admin\models\Desktop;
use panix\mod\admin\models\DesktopWidgets;

class DesktopController extends AdminController
{

    public $icon = 'icon-home';

    public function actions()
    {
        return [
            'sortable' => [
                'class' => 'panix\engine\grid\sortable\Action',
                'modelClass' => DesktopWidgets::class,
                'successMessage' => Yii::t('app/default', 'SORT_PRODUCT_SUCCESS_MESSAGE')
            ],
        ];
    }


    /**
     * @param $id
     * @return Response
     */
    public function actionDeleteWidget($id)
    {
        if (Yii::$app->request->isPost) {
            $model = DesktopWidgets::findModel($id);
            //$model->desktop->accessControlDesktop();
            if (isset($model)) {
                $model->delete();
            }
            if (!Yii::$app->request->isAjax)
                return $this->redirect('admin');
        }
    }

    public function actionWidgetCreate($id)
    {
        $desktop = Desktop::findModel($id, 'no find desktop');

        $model = new DesktopWidgets;

        if ($model->load(Yii::$app->request->post())) {
            $model->desktop_id = $desktop->id;
            if ($model->validate()) {
                $model->save();
                //Yii::app()->cache->flush();
            } else {
                print_r($model->getErrors());
                die;
            }
        }

        return $this->render('widget-create', ['model' => $model]);
    }

    /**
     * Delete desktop
     * @param $id
     * @return Response
     */
    public function actionDelete($id)
    {
        $model = Desktop::findModel($id);
        $model->accessControlDesktop();
        if (isset($model) && $model->id != 1) {
            $model->delete();
            unset(Yii::$app->session['desktop_id']);
        }
        if (!Yii::$app->request->isAjax)
            return $this->redirect(['/admin']);
    }


    public function getAddonsMenu()
    {
        return [
            [
                'label' => Yii::t('admin/default', 'DESKTOP'),
                //'url' => ['/admin/shop/attribute-group'],
                'visible' => true,
                'items' => [
                    [
                        'label' => Yii::t('admin/default', 'DESKTOP_CREATE'),
                        'url' => ['/admin/app/desktop/desktop-create'],
                        'visible' => true
                    ],
                    [
                        'label' => Yii::t('admin/default', 'DESKTOP_CREATE_WIDGET'),
                        'url' => ['/admin/app/desktop/widget-create','id'=>1],
                        'visible' => true
                    ],
                ]
            ],
        ];
    }
}
