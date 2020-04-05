<?php
use panix\engine\widgets\Pjax;
use panix\engine\grid\GridView;
use panix\engine\Html;

?>
<?php



Pjax::begin([
    //  'dataProvider' => $dataProvider,
]);
echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        'ip',
        'cmd',
        [
            'attribute' => 'type',
            'header' => Yii::t('app/default', 'type'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center','style'=>'width:100px']
        ],
        [
            'attribute' => 'user_id',
            'header' => Yii::t('app/default', 'user_id'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center','style'=>'width:100px']
        ],
        [
            'attribute' => 'session',
            'header' => Yii::t('app/default', 'session'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center','style'=>'width:100px']
        ],
        [
            'attribute' => 'log',
            'header' => Yii::t('app/default', 'log'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left']
        ],




    ]
]);
Pjax::end();


//\panix\engine\CMS::dump($content);
