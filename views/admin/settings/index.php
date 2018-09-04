<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;

?>


<div class="card bg-light">
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
                    'options' => ['id' => 'global'],
                ],
                [
                    'label' => 'Обслуживание',
                    'content' => $this->render('_maintenance', ['form' => $form, 'model' => $model]),
                    'headerOptions' => [],
                    'options' => ['id' => 'maintenance'],
                ],
                [
                    'label' => 'Цензура',
                    'content' => $this->render('_censor', ['form' => $form, 'model' => $model]),
                    'headerOptions' => [],
                    'options' => ['id' => 'censor'],
                ],
                [
                    'label' => 'Дата и время',
                    'content' => $this->render('_datetime', ['form' => $form, 'model' => $model]),
                    'headerOptions' => [],
                    'options' => ['id' => 'datetime'],
                ],
            ],
        ]);
        ?>
        <div class="card-footer text-center">
            <?= Html::submitButton(Yii::t('app', 'SAVE'), ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>

