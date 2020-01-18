<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'auth_login')->textInput() ?>

<?=
$form->field($model, 'auth_token')->textInput();
?>
<?=
$form->field($model, 'account')->textInput();
?>


<div class="form-group text-center">
    <?= Html::submitButton(Yii::t('app/default', 'SAVE'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

