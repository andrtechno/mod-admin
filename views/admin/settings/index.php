<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;

?>


<div class="card">
    <div class="card-header">
        <h5><?= $this->context->pageName ?></h5>
    </div>
    <div class="card-body">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>
        <?php
        echo panix\engine\bootstrap\Tabs::widget([
            'items' => [
                [
                    'label' => 'Общие',
                    'content' => $this->render('_global', ['form' => $form, 'model' => $model]),
                    'active' => true,
                ],
                [
                    'label' => 'Обслуживание',
                    'content' => $this->render('_maintenance', ['form' => $form, 'model' => $model]),
                    'headerOptions' => [],
                ],
                [
                    'label' => 'Цензура',
                    'content' => $this->render('_censor', ['form' => $form, 'model' => $model]),
                    'headerOptions' => [],
                ],
                [
                    'label' => 'Почта',
                    'content' => $this->render('_mailer', ['form' => $form, 'model' => $model]),
                    'headerOptions' => [],
                ],
                [
                    'label' => 'Дата и время',
                    'content' => $this->render('_datetime', ['form' => $form, 'model' => $model]),
                    'headerOptions' => [],
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

