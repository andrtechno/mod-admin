<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;

$form = ActiveForm::begin();
?>
<div class="card">
    <div class="card-header">
        <h5><?= Html::encode($this->context->pageName) ?></h5>
    </div>
    <div class="card-body">
        <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>


        <?php
        echo \panix\ext\multipleinput\MultipleInput::widget([
            'model' => $model,
            'attribute' => 'rules',
            'allowEmptyList' => false,
            'enableGuessTitle' => true,
            //'rendererClass'=>\panix\ext\multipleinput\renderers\ListRenderer::class,
            'rendererClass' => \panix\ext\multipleinput\renderers\TableListRenderer::class,
            //'addButtonPosition' => \panix\ext\multipleinput\MultipleInput::POS_HEADER, // show add button in the header
            'columns' => [
                [
                    'name' => 'label',
                    'title' => 'label',
                    'enableError' => false,
                    'headerOptions' => [
                        'style' => 'width: 250px;',
                    ],
                ],
                [
                    'name' => 'placeholder',
                    'title' => 'placeholder',
                    'enableError' => false,
                    'headerOptions' => [
                        'style' => 'width: 250px;',
                    ],
                ],
                [
                    'name' => 'required',
                    'title' => 'required',
                    'type' => \panix\ext\multipleinput\MultipleInputColumn::TYPE_CHECKBOX,
                    'enableError' => false,
                ],

                [
                    'name' => 'validator',
                    'title' => 'validator',
                    'type' => \panix\ext\multipleinput\MultipleInputColumn::TYPE_CHECKBOX_LIST,
                    'enableError' => false,
                    'items' => [

                        'email' => 'email',
                        'string' => 'string',
                        'integer' => 'integer',
                        'url' => 'url',
                    ]
                ],
            ]
        ]);

        ?>

    </div>
    <div class="card-footer text-center">
        <?= $model->submitButton() ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
