
<?= $form->field($model, 'maintenance')->checkbox() ?>
<?= $form->field($model, 'maintenance_text')->widget(\panix\ext\tinymce\TinyMce::className(), ['options' => ['rows' => 6]]); ?>


<?=

        $form->field($model, 'maintenance_allow_users')
        ->widget(\panix\ext\taginput\TagInput::className(), ['placeholder' => 'Разрешенные пользователи'])
        ->hint('Введите слово и нажмите Enter');
?>
<?=

        $form->field($model, 'maintenance_allow_ips')
        ->widget(\panix\ext\taginput\TagInput::className(), ['placeholder' => 'Разрешенные IP адреса'])
        ->hint('Введите слово и нажмите Enter');
?>