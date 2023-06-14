<?php

namespace panix\mod\admin\controllers\admin;


use panix\engine\CMS;
use panix\engine\grid\GridColumns;
use panix\mod\admin\models\DesktopWidgets;
use panix\mod\admin\models\search\SessionSearch;
use panix\mod\cart\models\Order;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\web\Response;
use panix\engine\controllers\AdminController;
use panix\mod\admin\models\Notification;
use panix\engine\Html;
use panix\engine\FileSystem;
use yii\web\UnauthorizedHttpException;

class DefaultController extends AdminController
{

    public $icon = 'icon-app';

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
    public function actionSession()
    {
        $this->pageName = Yii::t('app/admin', 'Session');
        $this->view->params['breadcrumbs'][] = $this->pageName;

        $searchModel = new SessionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('session',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndex()
    {
        $this->pageName = Yii::t('app/admin', 'CMS');
        $this->view->params['breadcrumbs'][] = $this->pageName;
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
    public function actionQueueCounter()
    {

        $queueAllItems = (new \yii\db\Query())
            ->select(['pushed_at', 'ttr', 'delay', 'priority', 'reserved_at', 'attempt', 'done_at', 'channel'])
            ->from(Yii::$app->queue->tableName)
            ->where(['done_at' => null])
            ->groupBy(['channel'])
            ->createCommand()
            ->queryAll();


        $result = [];
        foreach ($queueAllItems as $item) {

            $queueAllCount = (new \yii\db\Query())->select(['pushed_at', 'ttr', 'delay', 'priority', 'reserved_at', 'attempt', 'done_at', 'channel'])
                ->from(Yii::$app->queue->tableName)
                ->where(['done_at' => null])
                ->andWhere(['channel' => $item['channel']])
                //->andWhere(['>=','pushed_at',Yii::$app->settings->get('app', 'QUEUE_date_'.$item['channel'])])
                ->createCommand()
                ->query()
                ->count();


            $queryDoneCount = (new \yii\db\Query())->select(['pushed_at', 'ttr', 'delay', 'priority', 'reserved_at', 'attempt', 'done_at', 'channel'])
                ->from(Yii::$app->queue->tableName)
                ->where(['not', ['done_at' => null]])
                ->andWhere(['channel' => $item['channel']])
               // ->andWhere(['>=','pushed_at',Yii::$app->settings->get('app', 'QUEUE_date_'.$item['channel'])])
                ->createCommand()
                ->query();
            $queueDoneCount = $queryDoneCount->count();


            $percent = 0;
            if($queryDoneCount && $queueAllCount){
                $percent = round($queueDoneCount / ($queueDoneCount + $queueAllCount) * 100, 1);
            }
            /*$settings_key = 'QUEUE_CHANNEL_' . $item['channel'];
           $hash_value = Yii::$app->settings->get('app', $settings_key);
           if ($hash_value) {
               $queueAllCount2 = $hash_value;
               $diff = $queueDoneCount - $queueAllCount2;
               $percent = round(($diff) / ($queueAllCount + $diff) * 100, 1);

           }
           if ($percent >= 100 && $hash_value) {
              // Yii::$app->settings->delete('app', $settings_key);
           }*/
            $result[$item['channel']] = [
                'percent' => $percent,
                'channel' => $item['channel'],
                'title' => '<strong>'.ucfirst($item['channel']) . '</strong>: ',
                'message' => ($queueAllCount) ? "Осталось: <strong>{$queueAllCount}</strong>" : 'Подготовка...',
                //'message' => ($percent) ? "Выполнено: <strong>{$percent}%</strong>" : 'Подготовка...',
                'total' => $queueAllCount,
                'done' => $queueDoneCount,
            ];
        }
        return $this->asJson($result);
    }
    public function actionQueueCounter3()
    {

        $queueAllItems = (new \yii\db\Query())
            ->select(['pushed_at', 'ttr', 'delay', 'priority', 'reserved_at', 'attempt', 'done_at', 'channel'])
            ->from(Yii::$app->queue->tableName)
            ->where(['done_at' => null])
            ->groupBy(['channel'])
            ->createCommand()
            ->queryAll();


        $result = [];
        foreach ($queueAllItems as $item) {

            $queueAllCount = (new \yii\db\Query())->select(['pushed_at', 'ttr', 'delay', 'priority', 'reserved_at', 'attempt', 'done_at', 'channel'])
                ->from(Yii::$app->queue->tableName)
                ->where(['done_at' => null])
                ->andWhere(['channel' => $item['channel']])
                ->andWhere(['>=','pushed_at',Yii::$app->settings->get('app', 'QUEUE_date_'.$item['channel'])])
                ->createCommand()
                ->query()
                ->count();


            $queryDoneCount = (new \yii\db\Query())->select(['pushed_at', 'ttr', 'delay', 'priority', 'reserved_at', 'attempt', 'done_at', 'channel'])
                ->from(Yii::$app->queue->tableName)
                ->where(['not', ['done_at' => null]])
                ->andWhere(['channel' => $item['channel']])
                ->andWhere(['>=','pushed_at',Yii::$app->settings->get('app', 'QUEUE_date_'.$item['channel'])])
                ->createCommand()
                ->query();
            $queueDoneCount = $queryDoneCount->count();


           $percent = 0;
           if($queryDoneCount && $queueAllCount){
               $percent = round($queueDoneCount / ($queueDoneCount + $queueAllCount) * 100, 1);
           }
            /*$settings_key = 'QUEUE_CHANNEL_' . $item['channel'];
           $hash_value = Yii::$app->settings->get('app', $settings_key);
           if ($hash_value) {
               $queueAllCount2 = $hash_value;
               $diff = $queueDoneCount - $queueAllCount2;
               $percent = round(($diff) / ($queueAllCount + $diff) * 100, 1);

           }
           if ($percent >= 100 && $hash_value) {
              // Yii::$app->settings->delete('app', $settings_key);
           }*/
            $result[$item['channel']] = [
                'percent' => $percent,
                'channel' => $item['channel'],
                'title' => '<strong>'.ucfirst($item['channel']) . '</strong>: ',
                'message' => ($percent) ? "Выполнено: <strong>{$percent}%</strong>" : 'Подготовка...',
                'total' => $queueAllCount,
                'done' => $queueDoneCount,
            ];
        }
        return $this->asJson($result);
    }


    public function actionQueueCounter2()
    {

        $queueAllItems = (new \yii\db\Query())
            ->select(['pushed_at', 'ttr', 'delay', 'priority', 'reserved_at', 'attempt', 'done_at', 'channel'])
            ->from(Yii::$app->queue->tableName)
            ->where(['done_at' => null])
            ->groupBy(['channel'])
            ->createCommand()
            ->queryAll();


        $result = [];
        foreach ($queueAllItems as $item) {

            $queueAllCount = (new \yii\db\Query())->select(['pushed_at', 'ttr', 'delay', 'priority', 'reserved_at', 'attempt', 'done_at', 'channel'])
                ->from(Yii::$app->queue->tableName)
                ->where(['done_at' => null])->andWhere(['channel' => $item['channel']])
                ->createCommand()
                ->query()
                ->count();


            $queryDoneCount = (new \yii\db\Query())->select(['pushed_at', 'ttr', 'delay', 'priority', 'reserved_at', 'attempt', 'done_at', 'channel'])
                ->from(Yii::$app->queue->tableName)
                ->where(['not', ['done_at' => null]])->andWhere(['channel' => $item['channel']])
                ->createCommand()
                ->query();
            $queueDoneCount = $queryDoneCount->count();


            $percent = round($queueDoneCount / ($queueDoneCount + $queueAllCount) * 100, 1);
            $settings_key = 'QUEUE_CHANNEL_' . $item['channel'];
            $hash_value = Yii::$app->settings->get('app', $settings_key);
            if ($hash_value) {
                $queueAllCount2 = $hash_value;
                $diff = $queueDoneCount - $queueAllCount2;
                $percent = round(($diff) / ($queueAllCount + $diff) * 100, 1);

            }
            if ($percent >= 100 && $hash_value) {
                Yii::$app->settings->delete('app', $settings_key);
            }
            $result[] = [
                'percent' => $percent,
                'channel' => $item['channel'],
                'title' => '<strong>'.ucfirst($item['channel']) . '</strong>: ',
                'message' => ($percent) ? "Выполнено: <strong>{$percent}%</strong>" : 'Подготовка...',
                'total' => $queueAllCount,
                'done' => $queueDoneCount,
            ];
        }
        return $this->asJson($result);
    }

    public function actionAjaxCounters()
    {

        $notificationsAll = Notification::find()->read([Notification::STATUS_NO_READ, Notification::STATUS_NOTIFY])->all();

        $notificationsLimit = Notification::find()->limit(5)->all();

        // $notificationsCount = Notifications::find()->read([Notifications::STATUS_NO_READ, Notifications::STATUS_NOTIFY])->count();
        $result = [];
        foreach (Yii::$app->counters as $key => $count) {
            $result['count'][$key] = $count;
        }
        $result['count']['notifications'] = count($notificationsAll);

        $result['notify'] = [];
        foreach ($notificationsAll as $notify) {
            /** @var $notify Notification */
            $result['notify'][$notify->id] = [
                'text' => $notify->text,
                'status' => $notify->status,
                'type' => $notify->type,
                'url' => $notify->url,
                'sound' => $notify->sound
            ];
        }


        $result['content'] = $this->renderPartial('@admin/views/admin/notification/_notifications', ['notifications' => $notificationsLimit]);
        return $this->asJson($result);
    }

    public function actionAjaxNotificationStatus($id, $status)
    {
        $notifications = Notification::findOne($id);
        $notifications->status = $status;
        $notifications->save(false);

        return $this->asJson(['success' => true]);
    }


    public function actionEditColumns()
    {
        if (Yii::$app->request->isAjax) {
            $modelClass = str_replace('/', '\\', Yii::$app->request->post('model'));

            $grid_id = Yii::$app->request->post('grid_id');
            $getGrid = Yii::$app->request->post('GridColumns');
            $pageSize = Yii::$app->request->post('pageSize');


            $model = GridColumns::findOne(['grid_id' => $grid_id]);

            if (!$model)
                $model = new GridColumns();

            if ($getGrid) {
                $model->grid_id = $grid_id;
                $model->modelClass = $modelClass;
                $model->column_data = Json::encode($getGrid);
                $model->pageSize = $pageSize;
                $model->save(false);
            }

            $data = [];

            /** @var \panix\engine\db\ActiveRecord $mClass */
            $mClass = new $modelClass();
            $columnsArray = $mClass->getGridColumns();

            unset($columnsArray['DEFAULT_COLUMNS'], $columnsArray['DEFAULT_CONTROL']);
            if (isset($columnsArray)) {
                foreach ($columnsArray as $key => $column) {
                    $isChecked = false;

                    if (isset($column['header'])) {
                        $name = $column['header'];
                    } else {
                        $name = $mClass->getAttributeLabel((isset($column['attribute'])) ? $column['attribute'] : $key);
                    }
                    if (isset($model->column_data[$key]['checked'])) {
                        $isChecked = true;
                    }
                    $order = (isset($model->column_data[$key]) && isset($model->column_data[$key]['ordern'])) ? $model->column_data[$key]['ordern'] : '';
                    $data[] = [
                        'checkbox' => Html::checkbox('GridColumns[' . $key . '][checked]', $isChecked, ['checked' => $isChecked]),
                        'name' => $name,
                        'sort' => Html::textInput('GridColumns[' . $key . '][ordern]', $order, ['class' => 'form-control text-center'])
                    ];
                }
            }

            $provider = new ArrayDataProvider([
                'allModels' => $data,
                'pagination' => false
            ]);
            return $this->renderPartial('@panix/engine/views/_EditGridColumns', [
                'modelClass' => $modelClass,
                'provider' => $provider,
                'grid_id' => $grid_id,
                'pageSize' => $model->pageSize,
            ]);
        } else {
            throw new UnauthorizedHttpException(401);
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
            $s = (new FileSystem('assets', Yii::getAlias('@webroot')))->cleardir();
            Yii::$app->session->setFlash('success', Yii::t('app/admin', 'SUCCESS_CLR_ASSETS'));
        }
    }


    /*public function getAddonsMenu()
    {
        return [
            [
                'label' => Yii::t('admin/default', 'DESKTOP'),
                'visible' => true,
                'dropDownOptions' => ['class' => 'dropdown-menu-right'],
                'items' => [
                    [
                        'label' => Yii::t('admin/default', 'DESKTOP_CREATE'),
                        'url' => ['/admin/app/desktop/create'],
                        'visible' => true
                    ],
                    [
                        'label' => Yii::t('admin/default', 'DESKTOP_CREATE_WIDGET'),
                        'url' => ['/admin/app/desktop/widget-create', 'id' => 1],
                        'visible' => true,

                    ],
                ]
            ],
        ];
    }*/
}
