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
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'attribute' => 'file',
            'header' => Yii::t('app/default', 'file'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
            'value' => function ($model) use ($folder) {
                $file = basename($model['file']);
                return Html::a($file, ['view', 'folder' => $folder, 'file' => $file]);
            }
        ],
        [
            'attribute' => 'size',
            'header' => Yii::t('app/default', 'size'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center']
        ],
        [
            'class' => 'panix\engine\grid\columns\ActionColumn',
            'template' => '{delete}',
            'header' => Yii::t('app/default', 'OPTIONS'),
            'buttons' => [
                'delete' => function ($url, $model, $key) use ($folder) {
                    $url = ['delete', 'folder' => $folder, 'file' => basename($model['file'])];
                    return Html::a(Html::icon('delete'), $url, [
                        'title' => Yii::t('app/default', 'DELETE'),
                        'class' => 'btn btn-sm btn-danger']);
                },
            ]
        ]
    ]
]);
Pjax::end();