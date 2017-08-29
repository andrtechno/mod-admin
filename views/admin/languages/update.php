<?php

use yii\helpers\Html;
use panix\engine\bootstrap\ActiveForm;
?>



<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Html::encode($this->context->pageName) ?></h3>
    </div>
    <div class="panel-body">


        <?php
        $form = ActiveForm::begin([
                    'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']
        ]);
        ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => 100]) ?>
        <?= $form->field($model, 'code')->textInput(['maxlength' => 2]) ?>
        <?= $form->field($model, 'locale')->textInput(['maxlength' => 5]) ?>








        <div class="form-group text-center">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'CREATE') : Yii::t('app', 'UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>




        <?php ActiveForm::end(); ?>



    </div>
</div>

