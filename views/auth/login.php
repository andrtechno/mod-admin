<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php
$form = ActiveForm::begin([
            'id' => 'form-signin',
            'options' => ['class' => 'form-signin'],
            'fieldConfig' => [
                'template' => "{label}\n{input}",
                'labelOptions' => ['class' => 'sr-only'],
            ],
        ]);
?>

<?= $form->field($model, 'username')->textInput(['class' => 'form-control', 'placeholder' => 'Логин']) ?>
<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль']) ?>

<div class="row">
    <div class="col-sm-6">
        <div class="checkbox">
            <?php
            echo $form->field($model, 'rememberMe', [
                'template' => "{label}{input}",
            ])->checkbox()
            ?>
        </div>
    </div>
    <div class="col-sm-6 text-right">
        <?= Html::submitButton(Yii::t('user/default', 'Login'), ['class' => 'btn btn-success']) ?>
    </div>
</div>


<?php ActiveForm::end(); ?>