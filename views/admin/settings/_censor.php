<?php

use panix\ext\taginput\TagInput;
?>

<?= $form->field($model, 'censor')->checkbox() ?>

<?= $form->field($model, 'censor_words')
        ->widget(TagInput::class,['placeholder'=>'Запрещенное слово'])
        ->hint('Введите слово и нажмите Enter');
?>
<?= $form->field($model, 'censor_replace') ?>

