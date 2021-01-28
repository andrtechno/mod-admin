<?php
use panix\engine\bootstrap\ActiveForm;
use panix\engine\Html;

/**
 * @var \panix\mod\admin\models\Desktop $model
 */
?>

<div class="card">
    <div class="card-header">
        <h5><?= $this->context->pageName ?></h5>
    </div>
    <?php $form = ActiveForm::begin(); ?>
    <div class="card-body">
        <?php //echo $form->field($model, 'desktop_id'); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'columns')->dropdownList(array(1 => 1, 2 => 2, 3 => 3)) ?>
        <?= $form->field($model, 'addons')->checkbox() ?>
        <?= $form->field($model, 'private')->checkbox()->hint('Приватный стол от всех.') ?>

        <?= $form->field($model, 'user_id')->dropdownList(\yii\helpers\ArrayHelper::map(\panix\mod\user\models\User::find()->all(), 'id', 'username'))
            ->hint('Только владелец и СуперАдмин сможет управлять своим рабочем столом') ?>





    </div>
    <div class="card-footer text-center">
        <?= Html::submitButton(Yii::t('app/default', 'SAVE'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

