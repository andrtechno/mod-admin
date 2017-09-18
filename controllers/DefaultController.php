<?php

namespace panix\mod\admin\controllers;

use Yii;
use panix\engine\controllers\AdminController;
use panix\mod\admin\models\Notifactions;
use panix\engine\Html;
use panix\mod\admin\models\GridColumns;

class DefaultController extends AdminController {

    public function actionIndex() {
        $this->breadcrumbs[] = Yii::t('admin/default', 'SYSTEM');
        return $this->render('index', [
        ]);
    }

    public function actionAjaxCounters() {

        $notifactions = Notifactions::find()->read(0)->all();
        $result = [];
        $result['count']['cart'] = 5;
        $result['count']['comments'] = 10;
        $result['notify'] = [];
        foreach ($notifactions as $notify) {
            $result['notify'][$notify->id] = [
                'text' => $notify->text,
                'type' => $notify->type
            ];
        }

        return \yii\helpers\Json::encode($result);
    }

    public function actionAjaxReadNotifaction($id) {

        //$notifactions = Notifactions::find()->where(['id'=>$id])->one();
        $notifactions = Notifactions::findOne($id);
        $notifactions->is_read = 1;
        $notifactions->save(false);

        return \yii\helpers\Json::encode(['ok']);
    }

    public function actionGetGrid() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $modelClass = $request->post('modelClass');
            $gridId = $request->post('grid');
            $runClass = new $modelClass;



            if (isset($_POST['GridColumns'])) {
                GridColumns::deleteAll(['modelClass' => $modelClass]);
                foreach ($_POST['GridColumns']['check'] as $key => $post) {
                    $model = new GridColumns;
                    $model->modelClass = $modelClass;
                    $model->ordern = $_POST['GridColumns']['ordern'][$key];
                    $model->key = $key;
                    $model->save(false);
                }
            }



            $data = array();

            $model = GridColumns::find()->where(['modelClass' => $modelClass])->all();
            $m = array();
            foreach ($model as $r) {
                $m[$r->key]['ordern'] = $r->ordern;
                $m[$r->key]['key'] = $r->key;
            }



            $columsArray = $runClass->getGridColumns();
            unset($columsArray['DEFAULT_COLUMNS'], $columsArray['DEFAULT_CONTROL']);
            foreach ($columsArray as $key => $column) {

                if (isset($column['header'])) {
                    $name = $column['header'];
                } else {
                    if (is_array($column)) {
                        $name = $runClass->getAttributeLabel($column['attribute']);
                    } else {
                        $name = $runClass->getAttributeLabel($column);
                    }
                }
                if (isset($m[$key])) {
                    $isChecked = ($m[$key]['key'] == $key) ? true : false;
                } else {
                    $m[$key] = 0;
                    $isChecked = false;
                }
                $data[] = array(
                    'checkbox' => Html::checkbox('GridColumns[check][' . $key . ']', $isChecked, ['value' => $name]),
                    'name' => $name,
                    'sorter' => Html::textInput('GridColumns[ordern][' . $key . ']', $m[$key]['ordern'], ['style' => 'width:50px', 'class' => 'form-control text-center'])
                );
            }



            $provider = new \yii\data\ArrayDataProvider([
                'allModels' => $data,
                'sort' => [
                    'attributes' => ['name'],
                ],
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);



            return $this->renderAjax('grid', [
                        'provider' => $provider,
                        'modelClass' => $modelClass,
                            /* 'provider' => $provider,
                              'grid_id' => $grid_id,
                              'module' => $mod */
            ]);
        } else {
            throw new \yii\web\HttpException(401, Yii::t('app/error', '401'));
        }
    }

}
