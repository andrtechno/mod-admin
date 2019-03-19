<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use panix\mod\admin\models\Block;

/* @var $this yii\web\View */
/* @var $model profitcode\blocks\models\Block */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="block-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'format')->dropDownList(Block::getFormatsList()); ?>
    <?= $form->field($model, 'widget')->dropDownList(['test'=>'trest']); ?>
    <?= $form->field($model, 'active')->checkbox() ?>
<div id="payment_configuration"></div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('blocks', 'Create') : Yii::t('blocks', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(document).ready(function(){
        $('#BlocksModel_widget').change(function(){
            $('#payment_configuration').load('/app/blocks/configuration-form/system?='+$(this).val());
        });
        $('#BlocksModel_widget').change();
    });
</script>