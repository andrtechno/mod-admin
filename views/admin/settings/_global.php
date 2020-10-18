<?php

use panix\engine\helpers\TimeZoneHelper;
use panix\engine\Html;

/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $model \panix\mod\admin\models\SettingsForm
 */
$session = Yii::$app->session;
?>

<?= $form->field($model, 'sitename'); ?>
<?= $form->field($model, 'email'); ?>
<?= $form->field($model, 'pagenum'); ?>
<?php //echo $form->field($model, 'favicon')->fileInput(['accept' => 'image/*']) ?>

<div class="form-group row">
    <div class="col-sm-4 col-lg-2"><?= Html::activeLabel($model, 'favicon', ['class' => 'col-form-label']); ?></div>
    <div class="col-sm-8 col-lg-10">
        <?= Html::activeFileInput($model, 'favicon', ['class' => 'form-control-file']); ?>
        <div class="help-block">Доступные форматы: <strong>*.png, *.ico</strong></div>
        <?= $model->renderFaviconImage(); ?>
        <?= Html::error($model, 'favicon'); ?>
    </div>
</div>
<?= $form->field($model, 'session_timeout')
    ->textInput(['maxlength'=>strlen($session->timeout_default)])
    ->hint("Если оставить поле пустым, будет использоваться значение указанные сервером по умолчанию Максимальное доступное время сервера {$session->timeout_default}"); ?>
<?= $form->field($model, 'cookie_lifetime')
    ->textInput(['maxlength'=>strlen($session->lifetime_default)])
    ->hint("Если оставить поле пустым, будет использоваться значение указанные сервером по умолчанию Максимальное доступное время сервера {$session->lifetime_default}"); ?>

<?= $form->field($model, 'theme')->dropDownList($model->themesList(), []); ?>
<?= $form->field($model, 'timezone')->dropDownList(TimeZoneHelper::getTimeZoneData(), []); ?>
<?= $form->field($model, 'captcha_class')->dropDownList($model::captchaList(), ['prompt' => Yii::t('app/default', 'OFF')]); ?>

<?= $form->field($model, 'recaptcha_secret'); ?>
<?= $form->field($model, 'recaptcha_key'); ?>
