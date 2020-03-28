<?php

use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;


Pjax::begin([
    'dataProvider' => $dataProvider,
]);
echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'attribute' => 'text',
            'format' => 'html'
        ],
        [
            'attribute' => 'status',
            'format' => 'html'
        ],
        [
            'attribute' => 'created_at',
            'format' => 'html',
            'value'=>function($model){
                return \panix\engine\CMS::date($model->created_at);
            }
        ],
        ['class' => 'panix\engine\grid\columns\ActionColumn']
    ]
]);
Pjax::end();

