<?php

use panix\engine\helpers\TimeZoneHelper;

/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 */
?>

<?= $form->field($model, 'sitename'); ?>
<?= $form->field($model, 'email'); ?>
<?= $form->field($model, 'pagenum'); ?>
<?= $form->field($model, 'theme')->dropDownList($model->getThemes(), []); ?>
<?= $form->field($model, 'timezone')->dropDownList(TimeZoneHelper::getTimeZoneData(), []); ?>
<?= $form->field($model, 'captcha_class')->dropDownList($model::captchaList(), []); ?>

<?= $form->field($model, 'recaptcha_secret'); ?>
<?= $form->field($model, 'recaptcha_key'); ?>
