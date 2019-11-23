<?php

use panix\ext\colorpicker\Colorpicker;

/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $model \panix\mod\admin\models\SettingsForm
 */

?>

<?= $form->field($model, 'favicon')->fileInput() ?>
<?= $form->field($model, 'logo')->fileInput() ?>
<?= $form->field($model, 'theme_color')->widget(Colorpicker::class)->textInput(['maxlength' => 7]); ?>
