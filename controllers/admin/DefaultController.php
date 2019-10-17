<?php

namespace panix\mod\admin\controllers\admin;


use panix\mod\admin\models\Desktop;
use panix\mod\admin\models\DesktopWidgets;
use panix\mod\cart\models\Order;
use Yii;
use yii\base\Exception;
use yii\web\HttpException;
use yii\web\Response;
use panix\engine\controllers\AdminController;
use panix\mod\admin\models\Notifications;
use panix\engine\Html;
use panix\mod\admin\models\GridColumns;
use panix\engine\FileSystem;

class DefaultController extends AdminController
{

    public $icon = 'icon-app';

    public function actions()
    {
        return [
            'sortable' => [
                'class' => 'panix\engine\grid\sortable\Action',
                'modelClass' => DesktopWidgets::class,
                'successMessage' => Yii::t('app', 'SORT_PRODUCT_SUCCESS_MESSAGE')
            ],
        ];
    }

    public function actionIndex()
    {
        $this->pageName = Yii::t('app/admin', 'CMS');
        $this->breadcrumbs[] = $this->pageName;
        $this->clearCache();
        $this->clearAssets();

        return $this->render('index');
    }

    public function actionSendChat()
    {
        if (!empty($_POST)) {
            echo \panix\mod\admin\blocks\chat\ChatWidget::sendChat($_POST);
        }
    }

    public function actionAjaxCounters()
    {

        $notificationsAll = Notifications::find()->read([Notifications::STATUS_NO_READ, Notifications::STATUS_NOTIFY])->all();
        $notificationsLimit = Notifications::find()->read([Notifications::STATUS_NO_READ, Notifications::STATUS_NOTIFY])->limit(5)->all();
       // $notificationsCount = Notifications::find()->read([Notifications::STATUS_NO_READ, Notifications::STATUS_NOTIFY])->count();
        $orderCount = Order::find()->where(['status_id' => 1])->count();
        $result = [];
        $result['count']['cart'] = 5;
        $result['count']['comments'] = $orderCount;
        $result['count']['notifications'] = count($notificationsAll);

        $result['notify'] = [];
        foreach ($notificationsAll as $notify) {
            /** @var $notify Notifications */
            $result['notify'][$notify->id] = [
                'text' => $notify->text,
                'status' => $notify->status,
                'type' => $notify->type,
                'url' => $notify->url,
                'sound' => $notify->sound
            ];
        }
        $result['content'] = $this->render('notifications', ['notifications' => $notificationsLimit]);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    public function actionAjaxNotificationStatus($id, $status)
    {
        $notifications = Notifications::findOne($id);
        $notifications->status = $status;
        $notifications->save(false);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' => true];
    }

    public function actionGetGrid()
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $modelClass = $request->post('modelClass');
            $gridId = $request->post('grid');
            $runClass = new $modelClass;
            $post_columns = $request->post('GridColumns');

            if ($post_columns) {
                GridColumns::deleteAll(['modelClass' => $modelClass]);
                foreach ($post_columns['check'] as $key => $post) {
                    $model = new GridColumns;
                    $model->modelClass = $modelClass;
                    $model->ordern = $post_columns['ordern'][$key];
                    $model->column_key = $key;
                    $model->save(false);
                }
            }

            $data = array();

            $model = GridColumns::find()->where(['modelClass' => $modelClass])->all();
            $m = array();
            foreach ($model as $r) {
                $m[$r->column_key]['ordern'] = $r->ordern;
                $m[$r->column_key]['key'] = $r->column_key;
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
            throw new HttpException(401, Yii::t('app/error', '401'));
        }
    }

    public function clearCache()
    {
        $cacheId = Yii::$app->request->post('cache_id');
        if ($cacheId) {
            if ($cacheId == 'All') {
                Yii::$app->cache->flush();
            } else {
                Yii::$app->cache->delete(Yii::$app->request->post('cache_id'));
            }
            Yii::$app->session->setFlash('success', Yii::t('app/admin', 'SUCCESS_CLR_CACHE', ['id' => Yii::$app->request->post('cache_id')]));
        }
    }

    public function clearAssets()
    {
        if (Yii::$app->request->post('clear_assets')) {
            FileSystem::fs('assets', Yii::getAlias('@webroot'))->cleardir();
            Yii::$app->session->setFlash('success', Yii::t('app/admin', 'SUCCESS_CLR_ASSETS'));
        }
    }


    public function getAddonsMenu()
    {
        return [
            [
                'label' => Yii::t('shop/admin', 'Рабочий стол'),
                'url' => ['/admin/shop/attribute-group'],
                'visible' => true
            ],
            [
                'label' => Yii::t('shop/admin', 'еуые'),
                //'url' => ['/admin/shop/attribute-group'],
                'visible' => true,
                'items' => [
                    [
                        'label' => Yii::t('shop/admin', 'ATTRIBUTE_GROUP'),
                        'url' => ['/admin/app/default/desktop-create'],
                        'visible' => true
                    ],
                    [
                        'label' => Yii::t('shop/admin', 'Add widget'),
                        'url' => ['/admin/app/default/create-widget'],
                        'visible' => true
                    ],
                ]

            ],
        ];
    }
}
