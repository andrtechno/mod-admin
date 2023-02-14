<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use panix\engine\CMS;

Pjax::begin([
    'id' => 'pjax-container',
    'enablePushState' => false,
]);

print_r($cookies = Yii::$app->response->cookies);
?>
<?=

GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    //'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            // 'attribute' => 'role_id',
            'label' => Yii::t('user/default', 'ONLINE'),
            'format' => 'html',
            'contentOptions' => ['class' => 'text-center'],
            'value' => function ($model, $index, $dataColumn) {

                if ($model->expire > time()) {
                    $content = Yii::t('user/default', 'ONLINE');
                    $options = ['class' => 'badge badge-success', 'title' => CMS::time_passed(strtotime($model->created_at))];
                } else {
                    $content = Yii::t('user/default', 'OFFLINE');
                    $options = ['class' => 'badge badge-secondary'];
                }

                return Html::tag('span', $content, $options);
            }
        ],
        'id',
        'user_name',
        [
            'attribute' => 'expire',
            'value' => function ($model) {
                return CMS::date($model->expire);
            }
        ],
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return $model->created_at;
            }
        ],
        [
            'class' => 'panix\engine\grid\columns\ActionColumn',
            'template' => '{update} {switch} {delete}',
        ]
    ]
]);
?>
<?php Pjax::end(); ?>