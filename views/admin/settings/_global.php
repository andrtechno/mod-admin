<?php

use panix\engine\helpers\TimeZoneHelper;
use panix\engine\Html;

/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $model \panix\mod\admin\models\SettingsForm
 */

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

<div class="row">
    <div class="col-sm-4 col-lg-2"></div>
    <div class="col-sm-8 col-lg-10">

    </div>
</div>

<?= $form->field($model, 'theme')->dropDownList($model->themesList(), []); ?>
<?= $form->field($model, 'timezone')->dropDownList(TimeZoneHelper::getTimeZoneData(), []); ?>
<?= $form->field($model, 'captcha_class')->dropDownList($model::captchaList(), ['prompt' => Yii::t('app/default', 'OFF')]); ?>

<?= $form->field($model, 'recaptcha_secret'); ?>
<?= $form->field($model, 'recaptcha_key'); ?>
