<?php
use panix\engine\Html;
use panix\engine\bootstrap\Nav;
use panix\engine\widgets\langSwitcher\LangSwitcher;

?>
<nav class="navbar navbar-expand-lg fixed-top">

    <a class="navbar-brand" href="/admin"><span class="d-none d-md-block"><?= strtoupper(Yii::$app->name); ?></span></a>

    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbar2">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <div id="navbar2" class="collapse navbar-collapse mr-auto">
        <?php
        echo Nav::widget([
            'options' => ['class' => 'nav navbar-nav mr-auto'],
        ]);
        ?>
    </div>
    <ul class="navbar-right">
        <li><?= Html::a(Html::icon('home'), '/', array('target' => '_blank', 'class' => 'nav-link')) ?></li>
        <li><?= Html::a(Html::icon('locked'), ['/user/logout'], ['data-method' => "post"]) ?></li>
        <li><?= LangSwitcher::widget() ?></li>
    </ul>
</nav>