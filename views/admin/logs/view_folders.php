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
            'attribute' => 'folder',
            'header' => Yii::t('app/default', 'folder'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
            'value' => function ($model) {
                return $model['folder'];
            }
        ],
        [
            'attribute' => 'sub_folders',
            'header' => Yii::t('app/default', 'sub_folders'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
            'value' => function ($model) {
                if ($model['sub_folders'])
                    return implode('<br/>', $model['sub_folders']);
            }
        ],

        [
            'class' => 'panix\engine\grid\columns\ActionColumn',
            'template' => '{delete}',
            'header' => Yii::t('app/default', 'OPTIONS'),
            'buttons' => [
                'delete' => function ($url, $model, $key) {
                    $url = ['delete-folder', 'folder' => $model['folder']];
                    return Html::a(Html::icon('delete'), $url, [
                        'title' => Yii::t('app/default', 'DELETE'),
                        'class' => 'btn btn-sm btn-danger']);
                },
            ]
        ]
    ]
]);
Pjax::end();