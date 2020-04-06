<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;

$form = ActiveForm::begin();
?>
<div class="card">
    <div class="card-header">
        <h5><?= Html::encode($this->context->pageName) ?></h5>
    </div>
    <div class="card-body">
        <?= $form->field($model, 'name')->textInput(['maxlength' => 100]) ?>
        <?= $form->field($model, 'code')->textInput(['maxlength' => 2]) ?>
        <?= $form->field($model, 'slug')->textInput(['maxlength' => 4]) ?>
        <?= $form->field($model, 'locale')->textInput(['maxlength' => 5]) ?>
        <?= $form->field($model, 'is_default')->checkbox() ?>
    </div>
    <div class="card-footer text-center">
        <?= $model->submitButton() ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
