<?php

use yii\helpers\Html;
use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;

?>

<?php
Pjax::begin([
    'timeout' => 50000,
    'id' => 'pjax-' . strtolower(basename($dataProvider->query->modelClass)),
    'linkSelector' => 'a:not(.linkTarget)'
]);


echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'format' => 'raw',
            'header' => 'Флаг',
            'contentOptions' => ['class' => 'text-center'],
            'value' => function($model) {
                return Html::img($model->getFlagUrl(), ['alt' => $model->name, 'title' => $model->name]);
            },
        ],
        'name',
        [
            'class' => 'panix\engine\grid\columns\BooleanColumn',
            'attribute' => 'is_default',
            'format' => 'html'
        ],
        ['class' => 'panix\engine\grid\columns\ActionColumn']
    ]
]);
Pjax::end();

