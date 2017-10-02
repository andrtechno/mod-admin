<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model profitcode\blocks\models\Block */

$this->title = Yii::t('blocks', 'Adding block');
$this->params['breadcrumbs'][] = ['label' => Yii::t('blocks', 'Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="block-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
