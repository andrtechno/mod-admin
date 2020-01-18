<?php

use panix\engine\grid\GridView;

echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'attribute' => 'title',
            'header' => Yii::t('app/default', 'Название'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'alias',
            'header' => Yii::t('app/default', 'Путь'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
            'value' => function ($data) {
                return \panix\engine\Html::tag('code', $data['alias']);
            }
        ],
        [
            'attribute' => 'category',
            'header' => Yii::t('app/default', 'category'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'edit',
            'header' => Yii::t('app/default', 'OPTIONS'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
    ]
]);

