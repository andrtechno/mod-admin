<?php

use panix\engine\widgets\Breadcrumbs;

if (isset($breadcrumbs)) {
    echo Breadcrumbs::widget([
        'homeLink' => [
            'label' => Yii::t('yii', 'Home'),
            'url' => ['/admin']
        ],
        'scheme' => false,
        'links' => $breadcrumbs,
        'options' => ['class' => 'breadcrumbs float-left']
    ]);
}