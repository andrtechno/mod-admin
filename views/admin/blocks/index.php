<?php

use yii\helpers\Html;
use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;

Pjax::begin([
    'dataProvider' => $dataProvider
]);

echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'enableColumns' => false,
    'layoutOptions' => ['title' => $this->context->pageName],
    'showFooter' => true,
    //   'footerRowOptions' => ['class' => 'text-center'],
    'rowOptions' => ['class' => 'sortable-column'],
    'columns' => [
        ['class' => 'panix\engine\grid\columns\CheckboxColumn'],
        [
            'attribute' => 'id',
            'contentOptions' => ['class' => 'text-cen2ter'],
            'format' => 'raw',
            'value' => function ($model) {
                $this->registerJs("common.clipboard('.block-copy-{$model->id}');");
                return "<code class='copy block-copy-{$model->id}' data-clipboard-text='[block id=\"{$model->id}\"]'>[block id=\"{$model->id}\"]</code> <br/> <code class='copy block-copy-{$model->id}' data-clipboard-text='[blockInline id=\"{$model->id}\"]'>[blockInline id=\"{$model->id}\"]</code>";
            }
        ],
        [
            'attribute' => 'name',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'content',
            'format' => 'html'
        ],
        [
            'class' => 'panix\engine\grid\columns\ActionColumn',
        ],


    ]
]);

Pjax::end();

