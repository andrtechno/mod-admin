<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;

?>

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

