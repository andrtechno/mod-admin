<?php

use panix\ext\taginput\TagInput;

/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $model \panix\mod\admin\models\SettingsForm
 */
?>

<?= $form->field($model, 'censor')->checkbox() ?>

<?= $form->field($model, 'censor_words')
    ->widget(TagInput::class, ['placeholder' => 'Запрещенное слово'])
    ->hint('Введите слово и нажмите Enter');
?>
<?= $form->field($model, 'censor_replace') ?>

