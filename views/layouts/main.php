<?php

use panix\engine\Html;
use yii\widgets\Breadcrumbs;

panix\mod\admin\assets\AdminAsset::register($this);
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
        <script>
            $(function () {
                $(".panel-heading .grid-toggle").click(function (e) {
                    e.preventDefault();
                    $(this).find('i').toggleClass("fa-chevron-down");
                });
                $("#menu-toggle").click(function (e) {
                    e.preventDefault();
                    $("#wrapper").toggleClass("active");


                });
                $('.fadeOut-time').delay(2000).fadeOut(2000);
            });
        </script>
        <div id="wrapper-tpl">
            <nav class="navbar navbar-inverse navbar-fixed-top">

                <div class="container-fluid">
                    <div class="row">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="/admin"><span class="hidden-xs hidden-sm">CORNER</span></a>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                            <?php
                            
                            

                            
                            
                            
                            
use panix\engine\widgets\nav\Nav;

echo Nav::widget([
'options' => ['class' => 'navbar-nav'],
    'items' => [
        ['label' => 'Action', 'url' => '#'],
        ['label' => 'Submenu 1', 'active'=>true, 'items' => [
            ['label' => 'Action', 'url' => '#'],
            ['label' => 'Another action', 'url' => '#'],
            ['label' => 'Something else here', 'url' => '#'],
            '<li class="divider"></li>',
            ['label' => 'Submenu 2', 'items' => [
                ['label' => 'Action', 'url' => '#'],
                ['label' => 'Another action', 'url' => '#'],
                ['label' => 'Something else here', 'url' => '#'],
                '<li class="divider"></li>',
                ['label' => 'Separated link', 'url' => '#'],
            ]],
        ]],
        ['label' => 'Something else here', 'url' => '#'],
        '<li class="divider"></li>',
        ['label' => 'Separated link', 'url' => '#'],
    ]
]);


                            
      
                            ?>





                            <ul class="nav navbar-nav">



                                <li class="dropdown"><?= Html::a('Модули <span class="caret"></span>', '#', ['class' => 'dropdown-toggle', 'data-toggle' => "dropdown"]) ?> 
                                    <ul class="dropdown-menu">
                                        <?php
                                        foreach (Yii::$app->getModulesInfo() as $info) {
                                            ?>
                                            <li><?= Html::aIconL($info['icon'], $info['label'], $info['url']) ?></li>
                                            <?php
                                            //}
                                        }
                                        ?>
                                    </ul>
                                </li>
                            </ul>
                            <?php //$this->widget('mod.admin.widgets.EngineMainMenu');          ?>
                        </div>
                        <div class="navbar-right">

                            <ul class="navbar-right-menu">

                                <li><a href="/"><i class="icon-home"></i></a></li>
                                <li><?= Html::a('<i class="icon-locked"></i>', ['/user/logout'], ['data-method' => "post"]) ?></li>
                                <li><?= \panix\engine\widgets\langSwitcher\LangSwitcher::Widget() ?></li>
                            </ul>

                            <!--/.nav-collapse -->
                        </div>
                    </div>
                </div>
            </nav>
            <?php
            $class = '';
            $class .= (!isset($this->context->module->nav)) ? ' full-page' : '';
            if (isset($_COOKIE['wrapper'])) {
                $class .= ($_COOKIE['wrapper'] == 'true') ? ' active' : '';
            }
            ?>
            <div id="wrapper" class="<?= $class ?>">

                <!-- Sidebar -->
                <div id="sidebar-wrapper">


                    <?php if (isset($this->context->module->nav)) { ?>
                        <ul class="sidebar-nav" id="menu">
                            <li class="sidebar-header">

                                <b><?= Yii::$app->user->displayName ?></b>


                            </li>
                            <li><?= Html::a('<i class="icon-menu"></i>', '#', ['id' => 'menu-toggle']) ?></li>
                            <?php foreach ($this->context->module->nav as $nav) { ?>

                                <li><?= Html::a($nav['label'] . '1<i class="' . $nav['icon'] . '"></i>', $nav['url'], (isset($nav['options'])) ? $nav['options'] : []) ?></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
                <!-- /#sidebar-wrapper -->

                <!-- Page Content -->
                <div id="page-content-wrapper">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-lg-12 module-header">
                                <div class="pull-left">

                                    <h1 class="hidden-xs">
                                        <?php
                                        if (isset($this->context->icon)) {
                                            echo '<i class="' . $this->context->icon . '"></i>';
                                        } else {
                                            echo '<i class="' . $this->context->module->info['icon'] . '"></i>';
                                        }
                                        ?>


                                        <?= Html::encode($this->context->pageName) ?>
                                    </h1>
                                </div>


                                <div class="pull-right">

                                    <?php
                                    if (!isset($this->context->buttons)) {
                                        echo Html::a(Yii::t('app', 'CREATE'), ['create'], ['title' => Yii::t('app', 'CREATE'), 'class' => 'btn btn-success']);
                                    } else {
                                        if ($this->context->buttons == true) {
                                            if (is_array($this->context->buttons)) {

                                                if (count($this->context->buttons) > 1) {
                                                    echo Html::beginTag('div', ['class' => 'btn-group']);
                                                }
                                                foreach ($this->context->buttons as $button) {
                                                    if (isset($button['icon'])) {
                                                        $icon = '<i class="' . $button['icon'] . '"></i> ';
                                                    } else {
                                                        $icon = '';
                                                    }
                                                    echo Html::a($icon . $button['label'], $button['url'], $button['options']);
                                                }
                                                if (count($this->context->buttons) > 1) {
                                                    echo Html::endTag('div');
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="clearfix"></div>

                            </div>

                            <div class="clearfix"></div>
                            <?php if (isset($this->context->breadcrumbs)) { ?>
                                <div id="page-nav">
                                    <?php
                                    echo Breadcrumbs::widget([
                                        'homeLink' => [
                                            'label' => Yii::t('yii', 'Home'),
                                            'url' => ['/admin']
                                        ],
                                        'links' => $this->context->breadcrumbs,
                                        'options' => ['class' => 'breadcrumbs pull-left']
                                    ]);
                                    ?>
                                <?php } ?>


                                <?php echo $this->render('partials/_addonsMenu'); ?>
                                <div class="clearfix"></div>
                            </div>

                            <div class="col-lg-12">
                                <?php if (Yii::$app->session->hasFlash('success')) { ?>
                                    <div class="alert alert-success fadeOut-time" role="alert">
                                        <i class="fa fa-check-circle fa-2x"></i>
                                        <?php
                                        foreach (Yii::$app->session->getFlash('success') as $flash) {
                                            echo $flash;
                                        }
                                        ?>

                                    </div>
                                <?php } ?>
                                <?php if (Yii::$app->session->hasFlash('error')) { ?>
                                    <div class="alert alert-danger fadeOut-time" role="alert">
                                        <i class="fa fa-times-circle fa-2x"></i>
                                        <?php
                                        foreach (Yii::$app->session->getFlash('error') as $flash) {
                                            echo $flash;
                                        }
                                        ?>
                                    </div>
                                <?php } ?>



                                <?= $content ?>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
            <footer class="footer">
                <p class="col-md-12 text-center">
                    <?= Yii::$app->powered() ?> - 
                    <?= Yii::$app->version ?>
                </p>
            </footer>

        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>