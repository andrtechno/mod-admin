<?php

use yii\helpers\Html;
use panix\engine\bootstrap\ActiveForm;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Html::encode($this->context->pageName) ?></h3>
    </div>
    <div class="panel-body">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'auth_login')->textInput() ?>

    <?=
    $form->field($model, 'auth_token')->textInput()->hint('asd');
    ?>
         <?=
    $form->field($model, 'account')->textInput()->hint('asd');
    ?>


    <div class="form-group text-center">
        <?= Html::submitButton(Yii::t('app', 'SAVE'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
