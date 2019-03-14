<?php

use panix\engine\Html;
use yii\grid\GridView;

echo Html::beginForm('', 'post', array('id' => 'edit_grid_columns_form'));
echo Html::hiddenInput('modelClass', $modelClass);
echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped table-bordered'],
    'dataProvider' => $provider,
    'layout' => '{items}',
    'columns' => [
        [
            'attribute' => 'checkbox',
            'header' => '&nbsp;',
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center', 'style' => 'width:30px']
        ],
        [
            'attribute' => 'name',
            'header' => 'Название поля',
            'format' => 'raw'
        ],
        [
            'attribute' => 'sorter',
            'header' => 'Позиция',
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center', 'style' => 'width:30px']
        ]
    ],
]);

echo Html::endForm();
