<?php
use panix\engine\CMS;

$ip = Yii::$app->request->getUserHost();
$geoip = Yii::$app->geoip->ip($ip);
$code = $geoip->getCountryCode();
$name = $geoip->getCountry();
?>

<table class="table table-striped">
    <tr>
        <td style="width: 50%"><i class="icon-user-outline"></i> <?= Yii::$app->user->username . ' ' . CMS::ip($ip); ?></td>
        <td style="width: 50%"><i class="icon-<?= $browserIcon ?>"></i> <?= $browser->getBrowser() ?> <span class="float-right badge badge-secondary"><?= $browser->getVersion() ?></span></td>
    </tr>
    <tr>
        <td><i class="icon-ip4"></i> <?= $ip . ' ' . $name . '(' . $code . ')'; ?></td>
        <td><i class="icon-<?= $platformIcon ?>"></i> <?= $browser->getPlatform() ?></td>
    </tr>
    <tr>
        <td><?=Yii::t('user/User','TIMEZONE')?> <span class="float-right badge badge-secondary"><?= CMS::timezone() ?></span></td>
        <td><?=Yii::t('user/User','LAST_LOGIN')?> <span class="float-right badge badge-secondary"><?= Yii::$app->user->getLoginTime() ?></span></td>
    </tr>

</table>
