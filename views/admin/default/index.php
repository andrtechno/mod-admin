<?php

use panix\engine\Html;
use yii\helpers\Url;

use panix\engine\emoji\Emoji2;
use panix\engine\emoji\Emoji;

?>

<div class="row">
    <?php if (Yii::$app->hasModule('cart')) { ?>
        <div class="col-md-6 col-lg-3 col-sm-6">
            <?php
            $year = date('Y');
            $month = date('m');
            $monthDaysCount = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $query = (new \yii\db\Query())->from(\panix\mod\cart\models\Order::tableName())
                ->where(['between', 'created_at', strtotime("{$year}-{$month}-01 00:00:00"), strtotime("{$year}-{$month}-{$monthDaysCount} 23:59:59")])
                ->andWhere(['status_id' => 1])
                ->select([
                    'SUM(total_price_purchase - total_price) as income',
                ]);


            $order = $query->one();

            if ($order) {
                ?>
                <div class="card bg-primary text-white o-hidden">
                    <div class="card-body" style="padding: 1rem">
                        <div class="row">
                            <i class="icon-shopcart"></i>
                            <div class="col">
                                <?php if (isset(Yii::$app->getModule('cart')->count['num'])) { ?>
                                    <h2>
                                        <?= Yii::$app->getModule('cart')->count['num']; ?>
                                        <span class="lead">новых заказов</span>
                                    </h2>
                                <?php } ?>
                                <div>
                                    <strong><?= Yii::$app->currency->number_format($order['income']); ?></strong> <?= Yii::$app->currency->active['iso']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="<?= Url::toRoute(['/admin/cart']); ?>" class="card-footer z-1">
                        <span class="float-left">Подробней</span>
                        <span class="float-right"><i class="icon-arrow-right"></i></span>
                    </a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="col-md-6 col-lg-3 col-sm-6">

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


    <?php



    ?>
    <?php if (Yii::$app->hasModule('stats')) {
        $data = Yii::$app->stats->countVisits();

        ?>
        <div class="col-md-6 col-lg-3 col-sm-6">
            <div class="card bg-warning o-hidden">
                <div class="card-body" style="padding: 1rem">
                    <div class="row">
                        <i class="icon-stats"></i>
                        <div class="col">
                            <div class="row">
                                <div class="col-6">
                                    <h2><small>хосты:</small> <?= $data['hosts']; ?></h2>
                                </div>
                                <div class="col-6">
                                    <h2><small>хиты:</small> <?= $data['hits']; ?></h2>
                                </div>
                            </div>


                            <div>Посетило</div>
                        </div>
                    </div>
                </div>
                <a href="<?= Url::to(['/admin/stats']); ?>" class="card-footer z-1">
                    <span class="float-left">Подробней</span>
                    <span class="float-right"><i class="icon-arrow-right"></i></span>
                </a>
            </div>

        </div>
    <?php } ?>
    <div class="col-md-6 col-lg-3 col-sm-6">


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
    <?php
    /*foreach (Yii::$app->getModules() as $module) {
        if (isset($module->info)) {
            ?>
            <div class="col-md-2 col-xs-6 col-sm-4 text-center ">
                <?= Html::a(Html::icon($module->icon, ['style' => 'font-size:30px']) . '<br>' . $module->info['label'], $module->info['url'], ['class' => 'a']) ?>
            </div>

            <?php
        }
    }*/
    ?>
</div>

<?php


$this->registerJs("
    $(function () {
        $('.delete-widget').click(function () {
            var uri = $(this).attr('href');
            var ids = $(this).attr('data-id');

            common.ajax(uri, {}, function (data) {
                $('#ids_' + ids).remove();
                common.notify('" . Yii::t('app/default', 'SUCCESS_RECORD_DELETE') . "', 'success');
                common.removeLoader();
            });
            return false;
        });

        $('#createWidget').click(function () {
            var uri = $(this).attr('href');


            $.ajax({
                url: uri,
                data: {},
                type: 'GET',
                success: function (data) {
                    $('body').append('<div id=\"dialog\" class=\"no-padding\"></div>');

                    $('#dialog').dialog({
                        modal: true,
                        autoOpen: true,
                        width: 500,
                        title: '" . Yii::t('app/default', 'DESKTOP_CREATE_WIDGET') . "',
                        resizable: false,
                        open: function () {
                            //var obj = $.parseJSON(data);
                            $(this).html(data); //obj.content
                            common.removeLoader();
                        },
                        close: function (event, ui) {
                            $(this).remove();
                        },
                        buttons: [{
                            text: common.message.save,
                            'class': 'btn btn-sm btn-success',
                            click: function () {
                                var str = $('#dialog form').serialize();
                                str += '&json=true';

                                $.ajax({
                                    url: uri,
                                    data: str,
                                    type: 'POST',
                                    success: function () {
                                        console.log(data);
                                        $('#dialog').dialog('close');
                                        location.reload();
                                    }
                                });
                            }
                        }, {
                            text: common.message.cancel,
                            'class': 'btn btn-sm btn-secondary',
                            click: function () {
                                $(this).dialog('close');
                            }
                        }]
                    });
                    $(\"#dialog\").dialog(\"open\");
                }
            });


            return false;
        });

        $('.column').sortable({
            containment: 'parent',
            cursor: 'move',
            connectWith: '.column',
            handle: '.handle',
            //revert: true, //animation
            placeholder: 'placeholder',
            update: function (event, ui) {
                var data = $(this).sortable('serialize');
                data += '&column_new=' + $(this).attr('data-id');
                data += '&desktop_id=' + $(this).attr('data-desktop-id');
                $.post('/admin/app/default/sortable', data, function () {
                    common.notify('Success', 'success');
                });

            }
        }).disableSelection();
    });
");

$desktop = \panix\mod\admin\models\Desktop::findOne(1);

?>

<div class="row desktop">
    <?php
    // Yii::import('app.blocks_settings.*');
    // $manager = new WidgetSystemManager;
    $x = 0;

    if (isset($desktop->columns)) {
        while ($x++ < $desktop->columns) {
            if ($desktop->columns == 3) {
                $class = 'col-lg-4 col-md-6 col-sm-4';
            } elseif ($desktop->columns == 2) {
                $class = 'col-lg-6 col-md-6 col-sm-4';
            } else {
                $class = '';
            }
            ?>
            <div class="column <?= $class; ?>" data-id="<?= $x; ?>" data-desktop-id="<?= $desktop->id ?>">
                <?php

                $widgets = \panix\mod\admin\models\DesktopWidgets::find()
                    ->where([
                        'col' => $x,
                        'desktop_id' => $desktop->id
                    ])
                    ->orderBy(['ordern' => SORT_DESC])
                    ->all();
                if ($widgets) {
                    foreach ($widgets as $wgt) {
                        ?>
                        <div class="card desktop-widget" id="ids_<?= $wgt->id ?>" data-test="test-<?= $x ?>">

                            <div class="card-header">
                                <h5><?= (new $wgt->widget)->getTitle(); ?></h5>
                                <div class="card-option">
                                    <?php
                                    echo Html::a('<i class="icon-settings"></i>', ['/admin/app/widgets/update', 'alias' => $wgt->widget], array('class' => ' btn btn-link'));
                                    echo Html::a('<i class="icon-move"></i>', 'javascript:void(0)', ['class' => 'handle btn btn-link']);
                                    echo Html::a('<i class="icon-delete"></i>', ['delete-widget', 'id' => $wgt->id], ['data-id' => $wgt->id, 'class' => 'delete-widget btn btn-link']);
                                    ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php echo $wgt->widget::widget(); ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>
</div>
