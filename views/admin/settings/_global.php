<?php

use panix\engine\helpers\TimeZoneHelper
?>

<?= $form->field($model, 'sitename') ?>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'pagenum') ?>
<?= $form->field($model, 'theme')->dropDownList($model->getThemes(), []) ?>
<?= $form->field($model, 'timezone')->dropDownList(TimeZoneHelper::getTimeZoneData(), []) ?>
