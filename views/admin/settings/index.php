<?php

use panix\engine\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\FileHelper;

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

        <?= $form->field($model, 'theme')->dropDownList($model::getThemes(), []) ?>
    </div>
    <div class="panel-footer text-center">
        <?= Html::submitButton(Yii::t('app', 'SAVE'), ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php

$t = FileHelper::findFiles(Yii::getAlias('@app/web/themes'),[
    'filter' => function($path){
    return basename($path);
    },'recursive'=>true]);
//print_r($t);
    
    
$path = Yii::getAlias('@app/web/themes');
$dirIter = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS);
$files = new RecursiveIteratorIterator($dirIter, RecursiveIteratorIterator::SELF_FIRST);
foreach ($files as $file) {
    if ($file->isFile() === true && $file->getFilename() === '.htaccess') {
        var_dump($file->getPathname());
    }
}
    

    
?>