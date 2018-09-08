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

            <div class="col">
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse"
                                        data-target="#collapseOne"
                                        aria-expanded="true" aria-controls="collapseOne">
                                    Collapsible Group Item #1
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                             data-parent="#accordionExample">
                            <div class="card-body">
                                <?= Html::textArea('htaccess', $htaccess, array('class' => 'form-control', 'rows' => 20, 'style' => 'resize:none;border:0;')); ?>
                                <?= Html::checkBox('htaccess_reset', 0, array()); ?>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                        data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Collapsible Group Item #2
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                             data-parent="#accordionExample">
                            <div class="card-body">
                                <?= Html::textArea('robots', $robots, array('class' => 'form-control', 'rows' => 20, 'style' => 'resize:none;border:0;')); ?>


                                <div class="custom-control custom-checkbox">

                                    <?= Html::checkBox('robots_reset', 0, ['class'=>'custom-control-input','id'=>'customCheck1']); ?>
                                    <label class="custom-control-label" for="customCheck1">Check this custom checkbox</label>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>


                <?php
                 echo Html::submitButton(Yii::t('app', 'SAVE'), array('class' => 'btn btn-success'));


                ?>
            </div>
        </div>
    </div>
    <?php
    echo Html::endForm();
}
?>


