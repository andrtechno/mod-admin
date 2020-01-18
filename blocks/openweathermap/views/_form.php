<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;

?>


<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'lat')->textInput() ?>
<?= $form->field($model, 'lon')->textInput() ?>
<?=
$form->field($model, 'apikey')->textInput()->hint(Yii::t('app/default', 'Для получение ключа, необходимо зарегистрироватся на сайте, {link}', array(
        'link' => Html::a('openweathermap.org', 'http://openweathermap.org', array('traget' => '_blank'))
    )
))
?>
<?= $form->field($model, 'units')->dropDownList(array('metric' => html_entity_decode('&deg;C'), 'imperial' => html_entity_decode('&deg;F'))) ?>
<?= $form->field($model, 'enable_sunrise')->checkbox() ?>
<?= $form->field($model, 'enable_sunset')->checkbox() ?>
<?= $form->field($model, 'enable_humidity')->checkbox() ?>
<?= $form->field($model, 'enable_pressure')->checkbox() ?>
<?= $form->field($model, 'enable_wind')->checkbox() ?>

<div class="form-group text-center">
    <?= Html::submitButton(Yii::t('app/default', 'SAVE'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
