<?php
use panix\engine\Html;
use panix\engine\bootstrap\Nav;
use panix\engine\widgets\langSwitcher\LangSwitcher;

?>
<nav class="navbar navbar-expand-lg fixed-top">

    <a class="navbar-brand" href="/admin"><span class="d-none d-md-block">PIXELION</span></a>

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
        <li><a href="/"><i class="icon-home"></i></a></li>
        <li><?= Html::a('<i class="icon-locked"></i>', ['/user/logout'], ['data-method' => "post"]) ?></li>
        <li><?= LangSwitcher::Widget() ?></li>
        <li><?= Html::a(Html::icon('icon-home'), '/', array('target' => '_blank', 'class' => 'nav-link')) ?></li>
        <li><?= Html::a(Html::icon('icon-locked'), array('/users/logout'), array('class' => 'nav-link')) ?></li>
    </ul>
</nav>