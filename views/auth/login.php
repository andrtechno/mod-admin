<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var amnah\yii2\user\models\forms\LoginForm $model
 */
$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>






<?php
/* $form->field($model, 'rememberMe', [
  'template' => "{label}<div class=\"col-lg-offset-6 col-lg-6\">{input}</div>\n<div class=\"col-lg-6 col-lg-offset-6\">{error}</div>",
  ])->checkbox() */
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
<?= $form->field($model, 'password')->passwordInput()->textInput(['placeholder' => 'Пароль']) ?>

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