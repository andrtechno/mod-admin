<?php

use yii\helpers\Html;
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
            'class' => \panix\engine\grid\sortable\Column::class,
            'url' => ['/admin/app/languages/sortable']
        ],
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
        ['class' => 'panix\engine\grid\columns\ActionColumn'],

    ]
]);
Pjax::end();

?>


        <?=
        GridView::widget([
            'id'=>'grid-db',
            'tableOptions' => ['class' => 'table table-striped'],
            'dataProvider' => $provider,
            'layoutOptions' => ['title' => Yii::t('admin/default', 'EDIT_LOCALE')],
            //'layoutOptions' => ['title' => $this->context->pageName],
            'columns' => [
                [
                    'attribute' => 'key',
                    'header' => Yii::t('app/default', 'Группа'),
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-left'],
                ],
                [
                    'attribute' => 'url',
                    'header' => Yii::t('app/default', 'OPTIONS'),
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                /* [
                     'class' => 'panix\engine\grid\columns\ActionColumn',
                     'template' => '{delete}',
                     'header' => Yii::t('app/default', 'OPTIONS'),
                     'buttons' => [
                         'delete' => function ($url, $model, $key) {

                             return Html::a('<i class="icon-delete"></i>', $url, [
                                 'title' => Yii::t('app/default', 'DELETE'),
                                 'class' => 'btn btn-sm btn-danger']);
                         }
                     ]
                 ]*/
            ]
        ]);
        ?>

