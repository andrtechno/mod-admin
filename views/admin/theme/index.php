<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;
?>


<div class="card">
    <div class="card-header">
        <h5><?= $this->context->pageName ?></h5>
    </div>
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>
        <?php
        echo panix\engine\bootstrap\Tabs::widget([
            'items' => [
                [
                    'label' => 'Общие',
                    'content' => $this->render('_global', ['form' => $form, 'model' => $model]),
                    'active' => true,
                ],


            ],
        ]);
        ?>
        <div class="card-footer text-center">
            <?= Html::submitButton(Yii::t('app/default', 'SAVE'), ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

