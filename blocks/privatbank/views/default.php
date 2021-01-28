<?php

use panix\engine\Html;
use panix\engine\CMS;
//CMS::dump($result2);die;




$tabs[] = [
    'label' => Yii::t('app','На сегодня'),
    'content' => $this->render('_today_pb', ['result' => $result]),
    'headerOptions' => [],
    'options' => ['class' => 'flex-sm-fill text-center nav-item'],
    'visible' => true,
];
$tabs[] = [
    'label' => Yii::t('app','За вчера'),
    'content' => $this->render('_all', ['result' => $result2]),
    'headerOptions' => [],
    'options' => ['class' => 'flex-sm-fill text-center nav-item'],
    'visible' => true,
];


echo \panix\engine\bootstrap\Tabs::widget([
    //'encodeLabels'=>true,
    'options' => [
        'class' => 'nav-pills flex-column flex-sm-row nav-tabs-static'
    ],
    'items' => $tabs,
]);


?>



