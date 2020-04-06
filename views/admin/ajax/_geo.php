<?php
use panix\engine\CMS;
use panix\engine\Html;

/**
 * @var \panix\engine\components\geoip\GeoIP $geoIp
 * @var string $ip
 */

?>
<div>
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-sm-6">
                <?php if (isset($geoIp->location->lat) && isset($geoIp->location->lng)) { ?>
                    <img class="img-fluid img-thumbnail"
                         src="//maps.googleapis.com/maps/api/staticmap?center=<?= $geoIp->location->lat ?>,<?= $geoIp->location->lng ?>&zoom=13&key=AIzaSyBfXgobbZPa6KOHExMBdsC4EvIuKsOQ0DE&size=500x500&scale=1&maptype=roadmap&format=png&language=<?= Yii::$app->language ?>&markers=color:red|<?= $geoIp->location->lat ?>,<?= $geoIp->location->lng ?>"
                         alt="">

                    <div class="row">
                        <div class="col-sm-6">lat: <?= $geoIp->location->lat; ?></div>
                        <div class="col-sm-6 text-xl-right">lng: <?= $geoIp->location->lng; ?></div>
                    </div>

                    <?php

                    ?>
                <?php } ?>

            </div>
            <div class="col-sm-6">
                <h5><?= $ip; ?></h5>
                <?php
                CMS::dump($geoIp);
                ?>
                <?php if ($geoIp->country) { ?>
                    <strong>Страна/город:</strong> <?= $geoIp->country; ?>
                <?php
                if ($geoIp->city) {
                    echo '/'.Yii::t('app/geoip_city', $geoIp->city);
                }
                ?>
                <?php } ?>

                <?php if ($geoIp->region) { ?>
                    <div>
                        <strong>Регион:</strong> <?= $geoIp->region; ?>
                        <?php if ($geoIp->regionCode) { ?>
                            (<?= $geoIp->regionCode; ?>)
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if (isset($geoIp->postal)) { ?>
                    <div><strong>Индекс:</strong> <?= $geoIp->postal; ?></div>
                <?php } ?>
                <?php if ($geoIp->org) { ?>
                    <div><strong>Организация:</strong> <?= $geoIp->org; ?></div>
                <?php } ?>
                <?php if ($geoIp->timezone) { ?>
                    <div><strong>Часовой пояс:</strong> <?= $geoIp->timezone; ?></div>
                <?php } ?>




                <hr/>
                <?php
                /*$users = User::find()->findAllByAttributes(array('login_ip' => $ip));
                if (!empty($users)) {
                    echo 'Пользователи заходившие с этого IP-адреса:<br>';
                    foreach ($users as $user) {
                        echo Html::a($user->login, array('/admin/users/default/update', 'id' => $user->id)) . '<br>';
                    }
                }*/
                ?>

                <?php
                /* $sessions = Yii::app()->db->createCommand(array(
                     'select' => array('*'),
                     'from' => Session::model()->tableName(),
                     //'distinct' => true,
                     //'group' => 'ip_address',
                     'where' => 'ip_address=:ip',
                     'params' => array(':ip' => $ip),
                 ))->queryAll();


                 if ($sessions) {
                     echo '<hr/><b>Сессии:</b><br>';
                     foreach ($sessions as $session) {
                         if (!in_array($session['user_type'], array('Guest', 'SearchBot'))) {
                             echo Rights::getRoles()[$session['user_type']].'<br/>';
                         } else {
                             echo Yii::t('app/default',strtoupper($session['user_type'])).'<br/>';
                         }
                     }
                 }*/
                ?>
            </div>
        </div>
    </div>
</div>