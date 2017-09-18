<?php

use panix\engine\Html;
?>
<div class="row">

    <div class="col-md-2 col-xs-6 col-sm-4 text-center">
        <div class="thumbnail">
            <?=Html::icon('users', ['style' => 'font-size:30px;display:block'])?>
            Пользователей
            152
        </div>
        <div class="thumbnail">
            <?=Html::icon('cart', ['style' => 'font-size:30px;display:block'])?>
            Пользователей
            152
        </div>
    </div>

</div>

<div class="row">
    <?php
    foreach (Yii::$app->getModules() as $module) {
        if (isset($module->info)) {
            ?>
            <div class="col-md-2 col-xs-6 col-sm-4 text-center ">


        <?= Html::a(Html::icon($module->icon, ['style' => 'font-size:30px']) . '<br>' . $module->info['label'], $module->info['url'], ['class' => 'thumbnail']) ?>
            </div>

                <?php
            }
        }
        ?>
</div>


<div class="row">
    <div class="col-sm-6">
<?php echo \panix\mod\shop\blocks\popular\PopularBlock::widget([]); ?>
    </div>
    <div class="col-sm-6">
        <?php echo \panix\mod\admin\blocks\sysinfo\SysinfoWidget::widget([]); ?>
    </div>
</div>
