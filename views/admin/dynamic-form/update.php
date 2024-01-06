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
        <?= $form->field($model, 'csrf')->checkbox() ?>


        <?php
        echo \panix\ext\multipleinput\MultipleInput::widget([
            'model' => $model,
            'attribute' => 'rules',
            'allowEmptyList' => false,
            'min' => 1,
            //'max'=>10,
            'prepend'=>true,
            'sortable' => true,
            // 'enableGuessTitle' => true,
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
                    'name' => 'type',
                    'title' => 'type',
                    'type' => \panix\ext\multipleinput\MultipleInputColumn::TYPE_DROPDOWN,
                    'enableError' => false,
                    'items' => [
                        'textInput' => 'textInput',
                        'textArea' => 'textArea',
                    ]
                ],
                [
                    'name' => 'validator',
                    'title' => 'validator',
                    'type' => \panix\ext\multipleinput\MultipleInputColumn::TYPE_CHECKBOX_LIST,
                    'enableError' => false,
                    'items' => [
                        'required' => 'required',
                        'email' => 'email',
                        'string' => 'string',
                        'integer' => 'integer',
                        'trim' => 'trim',
                        'double' => 'double',
                        'boolean' => 'boolean',
                        'number' => 'number',
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

<?php
echo \panix\mod\admin\widgets\dynamicform\DynamicFormWidget::widget(['id' => 1]);
?>
