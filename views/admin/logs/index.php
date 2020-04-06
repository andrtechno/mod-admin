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
            'attribute' => 'folder_name',
            'header' => Yii::t('app/default', 'folder'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
            'value' => function ($model) {
                return \panix\engine\CMS::date(strtotime($model['folder_name']), false);
            }
        ],
        [
            'attribute' => 'sub_folders',
            'header' => Yii::t('app/default', 'sub_folders'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
            'value' => function ($model) {
                return implode('<br/>',$model['sub_folders']);
            }
        ],

        [
            'class' => 'panix\engine\grid\columns\ActionColumn',
            'template' => '{delete}',
            'header' => Yii::t('app/default', 'OPTIONS'),
            'buttons' => [
                'delete' => function ($url, $model, $key) {
                    $url = ['delete-folder', 'folder' => $model['folder_name']];
                    return Html::a(Html::icon('delete'), $url, [
                        'title' => Yii::t('app/default', 'DELETE'),
                        'class' => 'btn btn-sm btn-danger']);
                },
            ]
        ]
    ]
]);
Pjax::end();