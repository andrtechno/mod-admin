<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;

?>

<?php
$form = ActiveForm::begin([
    'id' => 'form-signin',
    'options' => ['class' => 'form-signin'],
    'fieldConfig' => [
        'template' => "<div class=\"col\"><div class=\"input-group\"><div class=\"input-group-prepend\">
                    <span class=\"input-group-text\"><i class=\"icon-{icon}\"></i></span>
                </div>{label}{input}{hint}{error}</div></div>",
        'horizontalCssClasses' => [
            'label' => ' ',
            // 'offset' => ' ',
            // 'wrapper' => ' ',
            // 'error' => '',
            'hint' => ''
        ],
        // 'options'=>['class'=>''],
        // 'labelOptions' => ['class' => 'sr-only'],
    ],
]);
?>



<?= $form->field($model, 'username', [
    'parts' => ['{icon}' => 'user'],
])->textInput([
    'class' => 'form-control',
    'placeholder' => $model->getAttributeLabel('username')
])->label(false);
?>



<?= $form->field($model, 'password', [
    'parts' => ['{icon}' => 'key'],
])
    ->textInput(['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('password')])
    ->label(false);
?>


    <div class="form-group row">
        <div class="col-sm-6">
            <?php
            echo $form->field($model, 'rememberMe', [
                'template' => "{label}{input}",
            ])->checkbox()
            ?>
        </div>
        <div class="col-sm-6 controls text-right">
            <?= Html::submitButton(Yii::t('user/default', 'Login'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>