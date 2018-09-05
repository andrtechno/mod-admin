<?php

use yii\helpers\Html;
use panix\engine\bootstrap\ActiveForm;
?>

<div class="card bg-light">
    <div class="card-header">
        <h5><?= Html::encode($this->context->pageName) ?></h5>
    </div>
    <div class="card-body">
        <?php
        $form = ActiveForm::begin([
                    'options' => ['class' => 'form-horizontal']
        ]);
        ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => 100]) ?>
        <?= $form->field($model, 'access')->dropDownList($model::getAccessList()) ?>
        <div class="form-group text-center">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'CREATE') : Yii::t('app', 'UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

