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
    'layout' => $this->render('@app/web/themes/admin/views/layouts/_grid_layout', ['title' => $this->context->pageName]), //'{items}{pager}{summary}'
    'columns' => [
        [
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
            'value' => function($model) {
      //  return $model->getMainImageUrl();
        return Html::img($model->getFlagUrl());
        //return $model->getImage()->getPath('50x50');
    },
        ],

        'name',
        'is_default',

        [
            'class' => 'panix\engine\grid\columns\ActionColumn',
            'template' => '{update} {switch} {delete}',

                ]
            ]
        ]);
        ?>
        <?php Pjax::end(); ?>

