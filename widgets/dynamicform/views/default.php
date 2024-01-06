<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(); ?>


<?php

foreach ($fieldsList as $field) {
    $options = [];
    $input = $form->field($model, $field['label']);
    if ($field['placeholder']) {
        $options['placeholder'] = $field['placeholder'];
    } elseif ($field['placeholder']) {
        $options['placeholder'] = $field['placeholder'];
    }

    if ($field['type'] == 'textInput') {
        $input->textInput($options);
    } elseif ($field['type'] == 'textArea') {
        $input->textarea($options);
    }

    echo $input;
}
?>


<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>


