<?php
use panix\engine\CMS;
use panix\engine\Html;

?>

<div class="row">
    <div class="col-sm-6">
        <img class="img-fluid img-thumbnail"
             src="//maps.googleapis.com/maps/api/staticmap?center=<?= $geoIp->location->lat ?>,<?= $geoIp->location->lng ?>&zoom=13&key=AIzaSyBfXgobbZPa6KOHExMBdsC4EvIuKsOQ0DE&size=350x350&scale=1&maptype=roadmap&format=png&language=<?= Yii::$app->language ?>&markers=color:red|<?= $geoIp->location->lat ?>,<?= $geoIp->location->lng ?>"
             alt="">
    </div>
    <div class="col-sm-6">


        <?php if (isset($geoIp->region)) { ?>
            <div><b>Регион:</b> <?= $geoIp->region; ?></div>
        <?php } ?>
        <?php if (isset($geoIp->postal)) { ?>
            <div><b>Индекс:</b> <?= $geoIp->postal; ?></div>
        <?php } ?>
        <?php if (isset($geoIp->org)) { ?>
            <div><b>Организация:</b> <?= $geoIp->org; ?></div>
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
                     echo Yii::t('app',strtoupper($session['user_type'])).'<br/>';
                 }
             }
         }*/
        ?>


        <div class="card">
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item"><?= CMS::ip($ip, 0); ?> <?= $geoIp->country; ?>
                        <?php if ($geoIp->city) { ?>
                            / <?php echo Yii::t('app/geoip_city', $geoIp->city); ?>
                        <?php } ?>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>



