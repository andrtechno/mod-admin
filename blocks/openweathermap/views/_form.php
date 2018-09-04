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
    <?= $form->field($model, 'lat')->textInput() ?>
    <?= $form->field($model, 'lon')->textInput() ?>
    <?=
    $form->field($model, 'apikey')->textInput()->hint(Yii::t('app', 'Для получение ключа, необходимо зарегистрироватся на сайте, {link}', array(
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
        <?= Html::submitButton(Yii::t('app', 'SAVE'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
