<?php

use panix\engine\Html;
use panix\engine\widgets\Breadcrumbs;

panix\mod\admin\assets\AdminAsset::register($this);

$sideBar = (method_exists($this->context->module, 'getAdminSidebar')) ? true : false;
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
            $(document).ready(function () {
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
            <?php echo $this->render('partials/_navbar'); ?>



            <?php
            $class = '';
            $class .= (!$sideBar) ? ' full-page' : '';
            if (isset($_COOKIE['wrapper'])) {
                $class .= ($_COOKIE['wrapper'] == 'true') ? ' active' : '';
            }
            ?>
            <div id="wrapper" class="<?= $class ?>">

                <?php if ($sideBar) { ?>
                    <div id="sidebar-wrapper">
                        <li class="sidebar-header">

                            <b><?= Yii::$app->user->displayName ?></b>


                        </li>

                        <?php
                        echo \panix\mod\admin\widgets\sidebar\SideBar::widget([
                            'items' => array_merge([
                                [
                                    'label' => '',
                                    'url' => '#',
                                    'icon' => 'menu',
                                    'options' => ['class' => 'sidebar-nav', 'id' => 'menu-toggle']
                                ]
                                    ], $this->context->module->getAdminSidebar())
                        ]);
                        ?>


                    </div>
                <?php } ?>

                <!-- Page Content -->
                <div id="page-content-wrapper">
                    <div class="container-fluid">

                        <div class="row">


                            <div class="col-lg-12 clearfix module-header">
                                <div class="float-left">
                                    <h1 class="d-none d-md-block d-sm-block d-lg-block">
                                        <?php
                                        if (isset($this->context->icon)) {
                                            echo Html::icon($this->context->icon);
                                        } else {
                                            echo Html::icon($this->context->module->info['icon']);
                                        }
                                        ?>
                                        <?= Html::encode($this->context->pageName) ?>
                                    </h1>
                                </div>

                                <div class="float-right">
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
                                                    if (!isset($button['options']['class'])) {
                                                        $button['options']['class'] = ['btn btn-default'];
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
                            </div>
                            <?php echo $this->render('partials/_breadcrumbs'); ?>



                            <div class="clearfix"></div>
                            <?php if (isset($this->context->breadcrumbs)) { ?>
                                <div id="page-nav">
                                    <?php
                                    echo Breadcrumbs::widget([
                                        'homeLink' => [
                                            'label' => Yii::t('yii', 'Home'),
                                            'url' => ['/admin']
                                        ],
                                        'scheme'=>false,
                                        'links' => $this->context->breadcrumbs,
                                        'options' => ['class' => 'breadcrumbs pull-left']
                                    ]);
                                    ?>
                                <?php } ?>


                                <?php echo $this->render('partials/_addonsMenu'); ?>
                                <div class="clearfix"></div>
                            </div>

                            <div class="col-lg-12">
                               
                                
                                <?php if (Yii::$app->session->allFlashes) { ?>
                                    <?php foreach (Yii::$app->session->allFlashes as $key => $message) { ?>
                                        <div class="alert alert-<?= $key ?> fadeOut-time">
                                            <i class="fa fa-check-circle fa-2x"></i> <?= $message ?></div>
                                    <?php } ?>
                                <?php } ?>


                                <?php
                                /*
                                  if (extension_loaded('intl')) {
                                  echo "intl true";
                                  } else {
                                  echo "intl false";
                                  } */





                                /*
                                  use panix\hosting\Api;

                                  $api = new Api('hosting_database','info');


                                  print_r($api); */










                                /* use yii\helpers\FileHelper;
                                  $files = FileHelper::findFiles(Yii::getAlias('@shop'),[
                                  'only'=>['*.md'],
                                  'recursive'=>false,
                                  'caseSensitive'=>false
                                  ]);
                                  foreach($files as $file){
                                  echo basename($file,'.md');
                                  }
                                  print_r($files); */



//use yii\helpers\Markdown;
//$myText = file_get_contents(Yii::getAlias('@shop').DIRECTORY_SEPARATOR.'README.md');
//$myHtml = Markdown::process($myText); // use original markdown flavor
//$myHtml = Markdown::process($myText, 'gfm'); // use github flavored markdown
//$myHtml = Markdown::process($myText, 'extra'); // use markdown extra
//echo $myHtml;














                                ?>

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
                    <br/>
                    <?= Yii::$app->pageGen() ?>
                </p>
            </footer>
            <?php echo \panix\engine\widgets\scrollTop\ScrollTop::widget(); ?>
        </div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>