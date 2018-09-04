<?php
use panix\engine\Html;
use panix\engine\CMS;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?=Yii::t('wgt_OpenWeatherMap/default','TITLE')?></h3>
        <div class="panel-option">
            <?= Html::a(Html::icon('settings'),['/admin/app/widgets/update','alias'=>get_class($this->context)],['class'=>'btn btn-link']); ?>

        </div>
      
    </div>
    <div class="panel-body">
<?php
if (!isset($result->hasError)) {
    ?>
    <div class="col-sm-6">
        <h1><?= $result->name ?>, <?= $result->sys->country ?></h1>
    </div>
    <div class="col-sm-6">
        <h1><img src="<?= $this->context->assetsUrl ?>/images/<?= $result->weather[0]->icon ?>.png" alt="" /> <?= floor($result->main->temp) ?><?= $this->context->deg ?> <small><?= $result->weather[0]->description; ?></small></h1>

    </div>
    <table class="table table-striped">
        <?php if ($this->context->config['enable_wind']) { ?>
            <tr>
                <td><?= Yii::t('wgt_OpenWeatherMap/default', 'WIND') ?></td>
                <td>
                    <?= $this->context->degToCompassImage($result->wind->deg); ?>
                    <?= $result->wind->speed; ?> м/с, <?= $this->context->degToCompass($result->wind->deg); ?>
                </td>
            </tr>
        <?php } ?>
        <?php if ($this->context->config['enable_pressure']) { ?>
            <tr>
                <td><?= Yii::t('wgt_OpenWeatherMap/default', 'PRESSURE') ?></td>
                <td><?= $result->main->pressure ?> гПа</td>
            </tr>
        <?php } ?>
        <?php if ($this->context->config['enable_humidity']) { ?>
            <tr>
                <td><?= Yii::t('wgt_OpenWeatherMap/default', 'HUMIDITY') ?></td>
                <td><?= $result->main->humidity ?>%</td>
            </tr>
        <?php } ?>
        <?php if ($this->context->config['enable_sunrise']) { ?>
            <tr>
                <td><?= Yii::t('wgt_OpenWeatherMap/default', 'SUNRISE') ?></td>
                <td><?php
                    $dateByZone = new DateTime(date('H:s', $result->sys->sunrise));
                    $dateByZone->setTimezone(new DateTimeZone(CMS::timezone()));
                    echo $dateByZone->format('H:i') . ' (' . CMS::timezone() . ')';
                    ?></td>
            </tr>
        <?php } ?>
        <?php if ($this->context->config['enable_sunset']) { ?>
            <tr>
                <td><?= Yii::t('wgt_OpenWeatherMap/default', 'SUNSET') ?></td>
                <td><?php
                    $dateByZone = new DateTime(date('H:s', $result->sys->sunset));
                    $dateByZone->setTimezone(new DateTimeZone(CMS::timezone()));
                    echo $dateByZone->format('H:i') . ' (' . CMS::timezone() . ')';
                    ?></td>
            </tr>
        <?php } ?>
    </table>
<?php } else { ?>

    <?php $this->theme->alert('warning', $result->message, false); ?>
<?php } ?>
</div>
    </div>