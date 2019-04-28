<?php
/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 */
?>
<?= $form->field($model, 'attachment_image_type')->dropDownList([
    'asset' => 'Asset (Сохранение изображений в папку assets)',
    'render' => 'Render (Создание изображений на лету)'
])->hint($model::t('ATTACHMENT_IMAGE_TYPE_HINT')) ?>
<?= $form->field($model, 'attachment_image_resize') ?>
<?= $form->field($model, 'attachment_wm_active') ?>
<?= $form->field($model, 'attachment_wm_path')->fileInput() ?>


<?= $form->field($model, 'attachment_wm_corner')->dropDownList($model->getWatermarkCorner()) ?>
<?= $form->field($model, 'attachment_wm_offsety')->textInput() ?>
<?= $form->field($model, 'attachment_wm_offsetx')->textInput() ?>

<?php

echo $model->renderWatermarkImage(); ?>