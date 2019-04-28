<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;


$mailer = Yii::$app->mailer;
$subject = Yii::t("user/default", "👍 😀 ⚠  🛒  🔑 🔔 🏆 🎁 🎉 🤝 👉 Email Confirmation");
$message = $mailer->compose(['html'=>'admin.tpl'], ['test'=>'dsa'])
    ->setTo('dev@pixelion.com.ua')
    ->setSubject($subject);
$message->send();
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
                    'label' => 'Image',
                    'content' => $this->render('_images', ['form' => $form, 'model' => $model]),
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
            <?= Html::submitButton(Yii::t('app', 'SAVE'), ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>

