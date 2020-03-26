<?php
use panix\engine\Html;


$icons = [
    'Социал' => [
        ['name' => 'icon-vk', 'unicode' => 'f045'],
        ['name' => 'icon-dropbox', 'unicode' => 'f046'],
        ['name' => 'icon-facebook', 'unicode' => 'f047'],

        ['name' => 'icon-instagram', 'unicode' => 'f049'],
        ['name' => 'icon-youtube', 'unicode' => 'f050'],
        ['name' => 'icon-youtube-play', 'unicode' => 'f051'],
        ['name' => 'icon-whatsapp', 'unicode' => 'f052'],
        ['name' => 'icon-viber', 'unicode' => 'f177'],
        ['name' => 'icon-whatsapp-2', 'unicode' => 'f178'],
        ['name' => 'icon-telegram-outline', 'unicode' => 'f179'],
        ['name' => 'icon-google-disk', 'unicode' => 'f117'],
        ['name' => 'icon-telegram', 'unicode' => 'f139'],
        ['name' => 'icon-twitter', 'unicode' => 'f154'],
        ['name' => 'icon-skype', 'unicode' => 'f155'],
        ['name' => 'icon-exit', 'unicode' => 'f180'],
        ['name' => 'icon-logout', 'unicode' => 'f180'],
    ],
    'Браузер & OS' => [
        ['name' => 'icon-windows', 'unicode' => 'f109'],
        ['name' => 'icon-windows-7', 'unicode' => 'f110'],
        ['name' => 'icon-netscape', 'unicode' => 'f111'],
        ['name' => 'icon-chrome', 'unicode' => 'f112'],
        ['name' => 'icon-firefox', 'unicode' => 'f113'],
        ['name' => 'icon-ie', 'unicode' => 'f114'],
        ['name' => 'icon-opera', 'unicode' => 'f115'],
        ['name' => 'icon-safari', 'unicode' => 'f116'],
        ['name' => 'icon-linux', 'unicode' => 'f118'],
        ['name' => 'icon-android', 'unicode' => 'f119'],
    ],
    'Файлы' => [
        ['name' => 'icon-file-app', 'unicode' => 'f074'],
        ['name' => 'icon-file-css', 'unicode' => 'f075'],
        ['name' => 'icon-file-doc', 'unicode' => 'f076'],
        ['name' => 'icon-file-zip', 'unicode' => 'f077'],
        ['name' => 'icon-file-xml', 'unicode' => 'f078'],
        ['name' => 'icon-file-sql', 'unicode' => 'f079'],
        ['name' => 'icon-file-gif', 'unicode' => 'f080'],
        ['name' => 'icon-file-html', 'unicode' => 'f081'],
        ['name' => 'icon-file-java', 'unicode' => 'f082'],
        ['name' => 'icon-file-key', 'unicode' => 'f083'],
        ['name' => 'icon-file-jpg', 'unicode' => 'f084'],
        ['name' => 'icon-file-php', 'unicode' => 'f085'],
        ['name' => 'icon-file-png', 'unicode' => 'f086'],
        ['name' => 'icon-file-psd', 'unicode' => 'f087'],
        ['name' => 'icon-file-rar', 'unicode' => 'f088'],
        ['name' => 'icon-file-txt', 'unicode' => 'f089'],
        ['name' => 'icon-file-pdf', 'unicode' => 'f090'],
        ['name' => 'icon-file-csv', 'unicode' => 'f102'],
    ],
    'Деньги' => [
        ['name' => 'icon-privat24', 'unicode' => 'f131'],
        ['name' => 'icon-webmoney', 'unicode' => 'f132'],
        ['name' => 'icon-paypal', 'unicode' => 'f133'],
        ['name' => 'icon-mastercard', 'unicode' => 'f134'],
        ['name' => 'icon-visa', 'unicode' => 'f135'],
        ['name' => 'icon-bank', 'unicode' => 'f136'],
        ['name' => 'icon-cash-money', 'unicode' => 'f164'],
        ['name' => 'icon-creditcard', 'unicode' => 'f059'],
        ['name' => 'icon-price-house', 'unicode' => 'f100'],
        ['name' => 'icon-currencies', 'unicode' => 'f033'],
    ],
    'Бизнес' => [
        ['name' => 'icon-copyright', 'unicode' => 'f108'],
        ['name' => 'icon-1c', 'unicode' => 'f067'],
        ['name' => 'icon-contract', 'unicode' => 'f160'],
        ['name' => 'icon-partner', 'unicode' => 'f161'],
        ['name' => 'icon-contract-hand', 'unicode' => 'f162'],
        ['name' => 'icon-operator', 'unicode' => 'f056'],
        ['name' => 'icon-monitor-stats', 'unicode' => 'f125'],
        ['name' => 'icon-stats', 'unicode' => 'f095'],
        ['name' => 'icon-supplier', 'unicode' => 'f156'],
        ['name' => 'icon-discount', 'unicode' => 'f003'],
    ],
    'Логотипы брендов' => [
        ['name' => 'icon-logo-icon', 'unicode' => 'f000'],
        ['name' => 'icon-logo', 'unicode' => 'f001'],
        ['name' => 'icon-logo-bold', 'unicode' => 'f002'],
        ['name' => 'icon-novaposhta', 'unicode' => 'f172'],
        ['name' => 'icon-lifecell', 'unicode' => 'f173'],
        ['name' => 'icon-vodafone', 'unicode' => 'f174'],
        ['name' => 'icon-kyivstar', 'unicode' => 'f175'],
        ['name' => 'icon-apple', 'unicode' => 'f031'],
        ['name' => 'icon-yandex', 'unicode' => 'f040'],
    ],
    'Стрелки' => [
        ['name' => 'icon-arrow-left', 'unicode' => 'f005'],
        ['name' => 'icon-arrow-right', 'unicode' => 'f006'],
        ['name' => 'icon-arrow-up', 'unicode' => 'f007'],
        ['name' => 'icon-arrow-down', 'unicode' => 'f008'],
        ['name' => 'icon-arrow-first', 'unicode' => 'f149'],
        ['name' => 'icon-arrow-last', 'unicode' => 'f150'],
        ['name' => 'icon-double-arrow-right', 'unicode' => 'f142'],
        ['name' => 'icon-double-arrow-left', 'unicode' => 'f143'],
        ['name' => 'icon-reload', 'unicode' => 'f042'],
        ['name' => 'icon-refresh', 'unicode' => 'f043'],
        ['name' => 'icon-move', 'unicode' => 'f057'],
        ['name' => 'icon-resize', 'unicode' => 'f128'],
        ['name' => 'icon-return-back', 'unicode' => 'f144'],
        ['name' => 'icon-sort', 'unicode' => 'f027'],
        ['name' => 'icon-reply', 'unicode' => 'f165'],
    ],
    'Погода' => [
        ['name' => 'icon-flash', 'unicode' => 'f188'],
        ['name' => 'icon-flash-outline', 'unicode' => 'f189'],
        ['name' => 'icon-sun', 'unicode' => 'f190'],
        ['name' => 'icon-sun-outline', 'unicode' => 'f191'],
        ['name' => 'icon-moon', 'unicode' => 'f192'],
        ['name' => 'icon-moon-outline', 'unicode' => 'f193'],
        ['name' => 'icon-cloud-rain', 'unicode' => 'f166'],
        ['name' => 'icon-cloud-rain-heavy', 'unicode' => 'f167'],
        ['name' => 'icon-wind', 'unicode' => 'f194'],
    ],
    'Разное' => [
        ['name' => 'icon-user-card', 'unicode' => 'f048'],
        ['name' => 'icon-user', 'unicode' => 'f004'],
        ['name' => 'icon-user-outline', 'unicode' => 'f182'],
        ['name' => 'icon-menu', 'unicode' => 'f009'],
        ['name' => 'icon-config', 'unicode' => 'f010'],
        ['name' => 'icon-settings', 'unicode' => 'f011'],
        ['name' => 'icon-tools', 'unicode' => 'f012'],
        ['name' => 'icon-heart', 'unicode' => 'f013'],
        ['name' => 'icon-heart-fill', 'unicode' => 'f014'],
        ['name' => 'icon-eye', 'unicode' => 'f015'],
        ['name' => 'icon-eye-close', 'unicode' => 'f016'],
        ['name' => 'icon-phone', 'unicode' => 'f017'],
        ['name' => 'icon-phone-outline', 'unicode' => 'f186'],
        ['name' => 'icon-location', 'unicode' => 'f018'],
        ['name' => 'icon-compare', 'unicode' => 'f019'],
        ['name' => 'icon-users', 'unicode' => 'f020'],
        ['name' => 'icon-delivery', 'unicode' => 'f021'],
        ['name' => 'icon-security', 'unicode' => 'f022'],
        ['name' => 'icon-folder-open', 'unicode' => 'f023'],
        ['name' => 'icon-language', 'unicode' => 'f024'],
        ['name' => 'icon-key', 'unicode' => 'f025'],
        ['name' => 'icon-home', 'unicode' => 'f026'],
        ['name' => 'icon-edit', 'unicode' => 'f028'],
        ['name' => 'icon-delete', 'unicode' => 'f029'],
        ['name' => 'icon-trashcan', 'unicode' => 'f030'],
        ['name' => 'icon-comments', 'unicode' => 'f032'],
        ['name' => 'icon-add', 'unicode' => 'f034'],
        ['name' => 'icon-locked', 'unicode' => 'f035'],
        ['name' => 'icon-cart', 'unicode' => 'f036'],
        ['name' => 'icon-shopcart', 'unicode' => 'f037'],
        ['name' => 'icon-database', 'unicode' => 'f038'],
        ['name' => 'icon-earth', 'unicode' => 'f039'],
        ['name' => 'icon-location-marker', 'unicode' => 'f041'],
        ['name' => 'icon-puzzle', 'unicode' => 'f044'],
        ['name' => 'icon-warning', 'unicode' => 'f053'],
        ['name' => 'icon-warning-outline', 'unicode' => 'f187'],
        ['name' => 'icon-info', 'unicode' => 'f054'],
        ['name' => 'icon-check', 'unicode' => 'f055'],
        ['name' => 'icon-envelope', 'unicode' => 'f058'],
        ['name' => 'icon-envelope-outline', 'unicode' => 'f181'],
        ['name' => 'icon-filter', 'unicode' => 'f060'],
        ['name' => 'icon-image', 'unicode' => 'f061'],
        ['name' => 'icon-images', 'unicode' => 'f062'],
        ['name' => 'icon-sendmail', 'unicode' => 'f063'],
        ['name' => 'icon-download', 'unicode' => 'f064'],
        ['name' => 'icon-upload', 'unicode' => 'f065'],
        ['name' => 'icon-blocks', 'unicode' => 'f066'],
        ['name' => 'icon-template', 'unicode' => 'f068'],
        ['name' => 'icon-search', 'unicode' => 'f069'],
        ['name' => 'icon-sitemap', 'unicode' => 'f070'],
        ['name' => 'icon-newspaper', 'unicode' => 'f071'],
        ['name' => 'icon-location-map', 'unicode' => 'f072'],
        ['name' => 'icon-location-route', 'unicode' => 'f073'],
        ['name' => 'icon-seo-monitor', 'unicode' => 'f091'],
        ['name' => 'icon-copy', 'unicode' => 'f092'],
        ['name' => 'icon-books', 'unicode' => 'f093'],
        ['name' => 'icon-chip', 'unicode' => 'f094'],
        ['name' => 'icon-print', 'unicode' => 'f096'],
        ['name' => 'icon-save', 'unicode' => 'f097'],
        ['name' => 'icon-t', 'unicode' => 'f098'],
        ['name' => 'icon-sms', 'unicode' => 'f099'],
        ['name' => 'icon-history', 'unicode' => 'f101'],
        ['name' => 'icon-messages', 'unicode' => 'f103'],
        ['name' => 'icon-question', 'unicode' => 'f104'],
        ['name' => 'icon-grid', 'unicode' => 'f105'],
        ['name' => 'icon-table', 'unicode' => 'f106'],
        ['name' => 'icon-table-edit', 'unicode' => 'f107'],
        ['name' => 'icon-share', 'unicode' => 'f120'],
        ['name' => 'icon-time', 'unicode' => 'f121'],
        ['name' => 'icon-ip', 'unicode' => 'f122'],
        ['name' => 'icon-http', 'unicode' => 'f123'],
        ['name' => 'icon-calendar', 'unicode' => 'f124'],
        ['name' => 'icon-external-link', 'unicode' => 'f126'],
        ['name' => 'icon-laptop', 'unicode' => 'f127'],
        ['name' => 'icon-ban', 'unicode' => 'f129'],
        ['name' => 'icon-bug', 'unicode' => 'f130'],
        ['name' => 'icon-camera-movie', 'unicode' => 'f137'],
        ['name' => 'icon-camera-photo', 'unicode' => 'f138'],
        ['name' => 'icon-rename', 'unicode' => 'f140'],
        ['name' => 'icon-star', 'unicode' => 'f141'],
        ['name' => 'icon-star-outline', 'unicode' => 'f185'],
        ['name' => 'icon-speed', 'unicode' => 'f145'],
        ['name' => 'icon-speedometer', 'unicode' => 'f146'],
        ['name' => 'icon-energy', 'unicode' => 'f147'],
        ['name' => 'icon-chronometer', 'unicode' => 'f148'],
        ['name' => 'icon-log', 'unicode' => 'f151'],
        ['name' => 'icon-notification', 'unicode' => 'f152'],
        ['name' => 'icon-rss', 'unicode' => 'f153'],
        ['name' => 'icon-blocked', 'unicode' => 'f157'],
        ['name' => 'icon-loader', 'unicode' => 'f158'],
        ['name' => 'icon-smile', 'unicode' => 'f159'],
        ['name' => 'icon-calculator', 'unicode' => 'f163'],

        ['name' => 'icon-sliders', 'unicode' => 'f168'],
        ['name' => 'icon-megaphone', 'unicode' => 'f169'],
        ['name' => 'icon-hand-up', 'unicode' => 'f170'],
        ['name' => 'icon-hand-down', 'unicode' => 'f171'],
        ['name' => 'icon-tag', 'unicode' => 'f176'],
        ['name' => 'icon-cart-add', 'unicode' => 'f184'],


        ['name' => 'icon-mobile', 'unicode' => 'f195'],
        ['name' => 'icon-tablet', 'unicode' => 'f196'],
        ['name' => 'icon-notification-outline', 'unicode' => 'f197'],
        ['name' => 'icon-quote-right', 'unicode' => 'f198'],
        ['name' => 'icon-quote-left', 'unicode' => 'f199'],

    ],

]
?>
<div class="row">
    <?php foreach ($icons as $gn => $group) { ?>
        <div class="col-sm-12 pt-3"><h3 class="text-center"><?= $gn; ?></h3></div>
        <?php foreach ($group as $icon) {
            $unicode = '&#x' . $icon['unicode'] . ';';
            ?>
            <div class="col-sm-2">
                <div class="card2 pb-3 text-center">
                <span style="font-family: Pixelion;font-size:26px">
                    <?php
                    if (isset($icon['unicode'])) {

                        echo Html::decode($unicode);
                    }
                    ?>
                    </span>
                    <div>
                        <code><?php echo htmlspecialchars('<i class="' . $icon['name'] . '"></i>'); ?></code>
                    </div>
                    <div>
                        <code><?= Html::encode($unicode); ?></code> <?=  $icon['unicode']; ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>



