<?php

use panix\mod\cart\components\events\EventProduct;
use yii\helpers\Html;
use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;


Pjax::begin([
    'id' => 'pjax-container', 'enablePushState' => false,
]);

echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'attribute' => 'user_id',
            'value' => function ($model) {
                if ($model->user_id) {
                    return $model->user->getDisplayName();
                }

            }
        ],
        [
            'attribute' => 'event_data',
            'value' => function ($model) {
                if ($model->event_data) {
                    $eventData = unserialize($model->event_data);
                    return $eventData->{$eventData->callback}();
                }

            }
        ],
        [
            'attribute' => 'created_at',
            'class' => 'panix\engine\grid\columns\jui\DatepickerColumn',
        ],
        [
            'class' => 'panix\engine\grid\columns\ActionColumn',
            'template' => '{update} {switch} {delete}',
        ]
    ]
]);
Pjax::end(); ?>
<?php
//$test = \panix\mod\admin\models\Timeline::findOne(8);
//\panix\engine\CMS::dump($test->event_data);
//$eventData = unserialize($test->event_data);

//$newEvent = new \panix\mod\admin\components\TimelineEvent;
//$newEvent->test = 'hahah';
//$newEvent->callback = 'onTest';

//\panix\engine\CMS::dump($event);die;
//\panix\mod\admin\models\Timeline::add2($newEvent);


