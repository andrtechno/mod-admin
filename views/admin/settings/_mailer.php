<?php
/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $model \panix\mod\admin\models\SettingsForm
 */
?>
<?= $form->field($model, 'mailer_transport_smtp_enabled')->checkbox(); ?>
<?= $form->field($model, 'mailer_transport_smtp_username'); ?>
<?= $form->field($model, 'mailer_transport_smtp_password'); ?>
<?= $form->field($model, 'mailer_transport_smtp_host')->hint('Например: localhost'); ?>
<?= $form->field($model, 'mailer_transport_smtp_port')->hint('Например: 465'); ?>
<?= $form->field($model, 'mailer_transport_smtp_encryption')->dropDownList([
    'ssl' => 'SSL',
    'tls' => 'TLS'
]) ?>

