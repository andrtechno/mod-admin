<?php

use yii\widgets\Pjax;
use yii\grid\GridView;


?>
<div class="card">
    <div class="card-header">
        <h5><?= $this->context->pageName; ?></h5>
    </div>
    <div class="card-body">
        <?=
        GridView::widget([
            'id' => 'grid-db',
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
    </div>
</div>
