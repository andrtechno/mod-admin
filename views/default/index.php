<?php

use panix\engine\Html;
use yii\helpers\Url;
?>

<div class="row">
    <div class="col-md-3 col-xs-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="icon-users icon-x5"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">26</div>
                        <div>Новых пользователей</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">Подробней</span>
                    <span class="pull-right"><i class="icon-arrow-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-md-3 col-xs-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="icon-comments icon-x5"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">407</div>
                        <div>Комментариев</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">Подробней</span>
                    <span class="pull-right"><i class="icon-arrow-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <?php if (Yii::$app->hasModule('stats')) { ?>
        <div class="col-md-3 col-xs-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="icon-stats icon-x5"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">47</div>
                            <div>Посетило</div>
                        </div>
                    </div>
                </div>
                <a href="<?= Url::to(['/admin/stats']); ?>">
                    <span class="panel-footer" style="display:block;">
                        <span class="pull-left">Подробней</span>
                        <span class="pull-right"><i class="icon-arrow-right"></i></span>
                        <span class="clearfix"></span>
                    </span>
                </a>
            </div>
        </div>
    <?php } ?>
    <div class="col-md-3 col-xs-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="icon-shopcart icon-x5"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">5</div>
                        <div>Заказов на <b>30 400</b> <sup>грн.</sup></div>

                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">Подробней</span>
                    <span class="pull-right"><i class="icon-arrow-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">


        <?php
        echo \panix\mod\admin\models\chat\ChatRoom::widget(['url' => '/admin/default/send-chat']);
        ?>



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

        <?php echo panix\mod\admin\blocks\hosting\Hosting::widget(); ?>
        <?php echo panix\mod\admin\blocks\openweathermap\OpenWeatherMap::widget(); ?>

    </div>
</div>
