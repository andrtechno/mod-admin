<?php

use panix\ext\taginput\TagInput;
use panix\ext\tinymce\TinyMce;

/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $model \panix\mod\admin\models\SettingsForm
 */
?>
<?= $form->field($model, 'maintenance')->checkbox() ?>
<?= $form->field($model, 'maintenance_text')->widget(TinyMce::class, ['options' => ['rows' => 6]]); ?>


<?=

$form->field($model, 'maintenance_allow_users')
    ->widget(TagInput::class, ['placeholder' => 'Разрешенные пользователи'])
    ->hint('Введите слово и нажмите Enter');
?>
<?=

$form->field($model, 'maintenance_allow_ips')
    ->widget(TagInput::class, ['placeholder' => 'Разрешенные IP адреса'])
    ->hint('Введите слово и нажмите Enter');
?>