<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model profitcode\blocks\models\Block */

$this->title = Yii::t('blocks', 'Update block') . ': ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('blocks', 'Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('blocks', 'Update');
?>
<div class="block-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
