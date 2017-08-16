<?php

use panix\engine\Html;
use yii\widgets\ActiveForm;
?>
<?php
$form = ActiveForm::begin([
            //  'id' => 'form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-sm-7\">{input}</div>\n<div class=\"col-sm-7 col-sm-offset-2\">{error}</div>",
                'labelOptions' => ['class' => 'col-sm-5 control-label'],
                ],
        ]);
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $this->context->pageName ?></h3>
    </div>
    <div class="panel-body panel-body-form">
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'pagenum') ?>
        <?= $form->field($model, 'sitename') ?>
        <?= $form->field($model, 'grid_btn_icon_size')->dropDownList($model::getButtonIconSizeList(),[]) ?>
    </div>
    <div class="panel-footer text-center">
        <?= Html::submitButton(Yii::t('app', 'SAVE'), ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>