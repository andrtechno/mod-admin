<?php

use yii\helpers\Html;

panix\mod\admin\assets\AdminLoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <title><?= Yii::t('app/admin', 'ADMIN_PANEL'); ?></title>
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
    </head>
    <body class="no-radius">
        <?php $this->beginBody() ?>

        <div class="container admin-auth">

            <div id="loginbox" style="margin-top:80px;" class="animated bounceInDown col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2">                    

                <div class="text-center auth-logo animated zoomInDown2 ">
                    <a href="//corner-cms.com" target="_blank">CORNER</a>
                    <div class="auth-logo-hint"><?= Yii::t('app/admin', 'CMS') ?></div>
                </div>
                <div class="panel panel-default" >
                    <div class="panel-heading">
                        <div class="panel-title text-center"><?= Yii::t('app/admin', 'LOGIN_ADMIN_PANEL') ?></div>
                    </div>     
                    <div style="padding-top:15px" class="panel-body">

                        <?= $content ?>

                    </div>                       
                </div> 
                <div class="text-center copyright">{copyright}</div>
            </div>
        </div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>

<script>
    $(function () {
        var h = $('.panel').height();
        var dh = $(window).height();
        $('#loginbox').css({'margin-top': (dh / 2) - h});
        $(window).resize(function () {
            var h = $('.panel').height();
            var dh = $(window).height();
            $('#loginbox').css({'margin-top': (dh / 2) - h});
        });
        $('.auth-logo').hover(function () {
            // $(this).removeClass('zoomInDown').addClass('swing'); 
        }, function () {
            //  $(this).removeClass('swing'); 
        });
    });

</script>