<?php
use panix\engine\widgets\Pjax;
use panix\engine\grid\GridView;
use panix\engine\Html;


Pjax::begin([
    //  'dataProvider' => $dataProvider,
]);
echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'attribute' => 'name',
            'header' => Yii::t('app/default', 'NAME'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        ['class' => 'panix\engine\grid\columns\ActionColumn']
    ]
]);
Pjax::end();