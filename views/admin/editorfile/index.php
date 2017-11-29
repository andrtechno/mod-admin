<?php
use panix\engine\CMS;
use panix\engine\Html;

$robotsmess = CMS::isChmod($this->context->path_robots, 0666);
if ($robotsmess)
    $this->theme->alert('warning', Yii::t('app', 'CHMOD_ERROR', array('{dir}' => $this->context->path_robots, '{chmod}' => 666)), false);
$htaccessmess = CMS::isChmod($this->context->path_htaccess, 0666);
if ($htaccessmess)
    $this->theme->alert('warning', Yii::t('app', 'CHMOD_ERROR', array('{dir}' => $this->context->path_htaccess, '{chmod}' => 666)), false);

if (!$robotsmess && !$htaccessmess) {

    echo Html::beginForm();
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-default" style="margin: 0;">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#htaccess">.htaccess</a>
                    </h4>
                </div>
                <div id="htaccess" class="panel-collapse collapse in">
                    <?= Html::textArea('htaccess', $htaccess, array('class' => 'form-control', 'rows' => 20, 'style' => 'resize:none;border:0;')); ?>
                 <?= Html::checkBox('htaccess_reset', 0, array()); ?>
                </div>
            </div>
            <div class="panel panel-default" style="margin: 0;">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#robots">robots.txt</a>
                    </h4>
                </div>
                <div id="robots" class="panel-collapse collapse">
                    <?= Html::textArea('robots', $robots, array('class' => 'form-control', 'rows' => 20, 'style' => 'resize:none;border:0;')); ?>
                    <?= Html::checkBox('robots_reset', 0, array()); ?>
                </div>
            </div>
            <?php
            echo Html::submitButton(Yii::t('app', 'SAVE'), array('class' => 'btn btn-success'));
            echo Html::endForm();
        }
        ?>

    </div>
</div>


