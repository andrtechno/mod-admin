<?php
use panix\engine\Html;
use panix\engine\CMS;

?>

<?php if ($result) { ?>
    <div class="row p-3">
        <div class="col-sm-6">
            <h3><?= $result['name'] ?><br/>
                <small class="text-muted"><?= $result['sys']['country'] ?></small>
            </h3>
        </div>
        <div class="col-sm-6 text-right">
            <h3>
                <img src="<?= $this->context->assetsUrl ?>/images/<?= $result['weather'][0]['icon'] ?>.png" alt=""/>
                <?= floor($result['main']['temp']) ?><?= $this->context->deg ?>
                <small class="text-muted d-block"><?= $result['weather'][0]['description']; ?></small>
            </h3>
        </div>
    </div>
    <table class="table table-striped">
        <?php if ($this->context->config->enable_wind) { ?>
            <tr>
                <td><?= Yii::t('wgt_OpenWeatherMap/default', 'WIND') ?></td>
                <td>
                    <?= $this->context->degToCompassImage($result['wind']['deg']); ?>
                    <?= $result['wind']['speed']; ?> м/с, <?= $this->context->degToCompass($result['wind']['deg']); ?>
                </td>
            </tr>
        <?php } ?>
        <?php if ($this->context->config->enable_pressure) { ?>
            <tr>
                <td><?= Yii::t('wgt_OpenWeatherMap/default', 'PRESSURE') ?></td>
                <td><?= $result['main']['pressure'] ?> гПа</td>
            </tr>
        <?php } ?>
        <?php if ($this->context->config->enable_humidity) { ?>
            <tr>
                <td><?= Yii::t('wgt_OpenWeatherMap/default', 'HUMIDITY') ?></td>
                <td><?= $result['main']['humidity'] ?>%</td>
            </tr>
        <?php } ?>
        <?php if ($this->context->config->enable_sunrise) { ?>
            <tr>
                <td><?= Yii::t('wgt_OpenWeatherMap/default', 'SUNRISE') ?></td>
                <td><?php
                    $dateByZone = new DateTime(date('H:s', $result['sys']['sunrise']));
                    $dateByZone->setTimezone(new DateTimeZone(CMS::timezone()));
                    echo $dateByZone->format('H:i') . ' (' . CMS::timezone() . ')';
                    ?></td>
            </tr>
        <?php } ?>
        <?php if ($this->context->config->enable_sunset) { ?>
            <tr>
                <td><?= Yii::t('wgt_OpenWeatherMap/default', 'SUNSET') ?></td>
                <td><?php
                    $dateByZone = new DateTime(date('H:s', $result['sys']['sunset']));
                    $dateByZone->setTimezone(new DateTimeZone(CMS::timezone()));
                    echo $dateByZone->format('H:i') . ' (' . CMS::timezone() . ')';
                    ?></td>
            </tr>
        <?php } ?>
    </table>
<?php } else { ?>
    Error
<?php } ?>
