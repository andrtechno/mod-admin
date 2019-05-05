<?php

$path=Yii::getAlias('@cart/widgets');
$test = \yii\helpers\FileHelper::findDirectories($path,[
    'recursive'=>false
]);
$test2 = \yii\helpers\FileHelper::findFiles($path.'/buyOneClick',[
    'recursive'=>true,
   // 'except'=>['\!view!.php'],
    'only'=>['form/*.php'],
    'filter'=>function($path){
    return $path;
    }
]);

print_r($test);
echo '<br><br><br>';
print_r($test2);
foreach ($test2 as $f){

}

use panix\engine\grid\GridView;

echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'attribute' => 'title',
            'header' => Yii::t('app', 'Название'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'alias',
            'header' => Yii::t('app', 'Путь'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'category',
            'header' => Yii::t('app', 'category'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'edit',
            'header' => Yii::t('app', 'OPTIONS'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
    ]
]);

