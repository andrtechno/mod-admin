        <?php
        use yii\helpers\FileHelper;
        ?>

<?= $form->field($model, 'sitename') ?>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'pagenum') ?>
<?= $form->field($model, 'theme')->dropDownList($model->getThemes(), []) ?>
<?= $form->field($model, 'timezone')->dropDownList(\panix\engine\helpers\TimeZoneHelper::getTimeZoneData(), []) ?>
<?php

echo  Yii::$app->formatter->asDatetime('2017-08-28 22:10:10');
?>

<?php

$t = FileHelper::findFiles(Yii::getAlias('@app/web/themes'), [
            'filter' => function($path) {
                return basename($path);
            }, 'recursive' => true]);
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