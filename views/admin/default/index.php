<?php

use panix\engine\Html;
use yii\helpers\Url;
?>

<div class="row">
    <div class="col-md-3 col-xs-6">


        <div class="card bg-primary text-white o-hidden">
            <div class="card-body" style="padding: 1rem">
                <div class="row">
                    <i class="icon-shopcart"></i>
                    <div class="col">
                        <h2>30 <span class="lead">новых заказов</span></h2>
                        <div><b>150</b> товаров на сумму <b>30 400</b> грн.</div>
                    </div>
                </div>
            </div>
            <a href="#" class="card-footer z-1">
                <span class="float-left">Подробней</span>
                <span class="float-right"><i class="icon-arrow-right"></i></span>
            </a>
        </div>


    </div>
    <div class="col-md-3 col-xs-6">

        <div class="card bg-danger text-white o-hidden">
            <div class="card-body" style="padding: 1rem">
                <div class="row">
                    <i class="icon-comments"></i>
                    <div class="col">
                        <h2>Комментариев</h2>
                        <div>123</div>
                    </div>
                </div>
            </div>
            <a href="#" class="card-footer z-1">
                <span class="float-left">Подробней</span>
                <span class="float-right"><i class="icon-arrow-right"></i></span>
            </a>
        </div>

    </div>
    <?php if (Yii::$app->hasModule('stats')) { ?>
        <div class="col-md-3 col-xs-6">
            <div class="card bg-warning o-hidden">
                <div class="card-body" style="padding: 1rem">
                    <div class="row">
                        <i class="icon-stats"></i>
                        <div class="col">
                            <h2>47</h2>
                            <div>Посетило</div>
                        </div>
                    </div>
                </div>
                <a href="<?= Url::to(['/stats']); ?>" class="card-footer z-1">
                    <span class="float-left">Подробней</span>
                    <span class="float-right"><i class="icon-arrow-right"></i></span>
                </a>
            </div>

        </div>
    <?php } ?>
    <div class="col-md-3 col-xs-6">


        <div class="card bg-success text-white o-hidden">
            <div class="card-body" style="padding: 1rem">
                <div class="row">
                    <i class="icon-shopcart"></i>
                    <div class="col">
                        <h2>Комментариев</h2>
                        <div>123</div>
                    </div>
                </div>
            </div>
            <a href="#" class="card-footer z-1">
                <span class="float-left">Подробней</span>
                <span class="float-right"><i class="icon-arrow-right"></i></span>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">


        <?php
        echo \panix\mod\admin\models\chat\ChatRoom::widget(['url' => '/default/send-chat']);
        ?>



    </div>
</div>
<div class="row">
    <?php
    foreach (Yii::$app->getModules() as $module) {
        if (isset($module->info)) {
            ?>
            <div class="col-md-2 col-xs-6 col-sm-4 text-center ">


                <?= Html::a(Html::icon($module->icon, ['style' => 'font-size:30px']) . '<br>' . $module->info['label'], $module->info['url'], ['class' => 'a']) ?>
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

        <?php //echo panix\mod\admin\blocks\hosting\Hosting::widget(); ?>
        <?php //echo panix\mod\admin\blocks\openweathermap\OpenWeatherMap::widget(); ?>

    </div>
</div>
