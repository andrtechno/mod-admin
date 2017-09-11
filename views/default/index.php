<div class="row">
    

<?php


use yii\helpers\Html;
foreach (Yii::$app->getModules() as $module) {
    if(isset($module->info)){
    ?>
    <div class="col-md-2 text-center">
        <i class="fa fa-5x <?=$module->info['icon']?>"></i>
        <br>
        <?= Html::a($module->info['label'], $module->info['url']) ?>
    </div>

   <?php 
    }
}
?>
</div>