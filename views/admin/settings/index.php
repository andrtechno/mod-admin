<?php

use panix\engine\Html;
use yii\bootstrap\ActiveForm;
?>
        <?php
        $form = ActiveForm::begin([

                   'layout' => 'horizontal',
                    'fieldConfig' => [
                        'horizontalCssClasses' => [
                            'label' => 'col-sm-4',
                            'offset' => 'col-sm-offset-4',
                            'wrapper' => 'col-sm-8',
                            'error' => '',
                            'hint' => '',
                        ],
                    ],
        ]);
        ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $this->context->pageName ?></h3>
    </div>
    <div class="panel-body">
        <?= $form->field($model, 'sitename') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'pagenum') ?>
        
        <?= $form->field($model, 'grid_btn_icon_size')->dropDownList($model::getButtonIconSizeList(),[]) ?>
    </div>
    <div class="panel-footer text-center">
        <?= Html::submitButton(Yii::t('app', 'SAVE'), ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>