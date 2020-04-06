<?php
use panix\engine\widgets\Pjax;
use panix\engine\grid\GridView;

/**
 * @var \yii\web\View $this
 */

Pjax::begin([
    //  'dataProvider' => $dataProvider,
]);
echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'attribute' => 'time',
            'header' => Yii::t('app/default', 'TIME'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center','style'=>'width:100px']
        ],
        [
            'attribute' => 'ip',
            'header' => Yii::t('app/default', 'IP'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center','style'=>'width:100px']
        ],
        [
            'attribute' => 'cmd',
            'header' => Yii::t('admin/default', 'LOG_CMD'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center','style'=>'width:100px']
        ],
        [
            'attribute' => 'type',
            'header' => Yii::t('admin/default', 'LOG_TYPE'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center','style'=>'width:100px']
        ],
        [
            'attribute' => 'user_id',
            'header' => Yii::t('app/default', 'user_id'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center','style'=>'width:100px']
        ],
        [
            'attribute' => 'session',
            'header' => Yii::t('admin/default', 'LOG_SESSION'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center','style'=>'width:100px']
        ],
        [
            'attribute' => 'log',
            'header' => Yii::t('app/default', 'log'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left']
        ],




    ]
]);
Pjax::end();

