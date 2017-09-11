<?php

use yii\helpers\Html;
use panix\engine\grid\GridView;
use yii\widgets\Pjax;
?>



<?php

Pjax::begin([
    'id' => 'pjax-container', 'enablePushState' => false,
]);
?>
<?=

GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layout' => $this->render('@admin/views/layouts/_grid_layout', ['title' => $this->context->pageName]), //'{items}{pager}{summary}'
    'columns' => [
        [
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
            'value' => function($model) {
        return Html::img($model->getFlagUrl(), ['alt' => $model->name, 'title' => $model->name]);
    },
        ],
        'name',
        [
            'class' => 'panix\engine\grid\columns\AdminBooleanColumn',
            'attribute' => 'is_default',
        ],[
            'class' => 'panix\engine\grid\columns\ActionColumn',
            'template' => '{update} {switch} {delete}',
        ]
    ]
]);

?>
<?php Pjax::end(); ?>

