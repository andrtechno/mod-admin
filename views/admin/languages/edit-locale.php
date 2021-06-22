<?php
use yii\widgets\Pjax;
use yii\grid\GridView;

//echo \panix\engine\CMS::dump($r);
?>
<?php
Pjax::begin([
    'id'=>'pjax-grid-db',
]);
?>
<?=
GridView::widget([
    'id'=>'grid-db',
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $provider,
    // 'filterModel' => $searchModel,
    //'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'attribute' => 'key',
            'header' => Yii::t('app/default', 'key'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
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
<?php Pjax::end(); ?>
