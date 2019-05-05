<?php
use panix\engine\bootstrap\ActiveForm;
use panix\engine\Html;
?>


<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'desktop_id')->hint('Например: 465'); ?>
<?= $form->field($model, 'widget')->dropDownList([
    'panix\mod\admin\blocks\hosting\Hosting' => 'Hosting',
    'panix\mod\admin\blocks\chat\ChatWidget' => 'Чат',
    'panix\mod\admin\blocks\sysinfo\SysInfoWidget' => 'Информация о системе',
    'panix\mod\shop\blocks\popular\PopularBlock' => 'Популярные товары',
]) ?>

<?= $form->field($model, 'col')->dropDownList($model->getColumnsRange()) ?>

<div class="card-footer text-center">
    <?= Html::submitButton(Yii::t('app', 'SAVE'), ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>

