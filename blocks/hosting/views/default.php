<?php

use panix\engine\Html;
use panix\engine\CMS;


?>
<style>
    .progress {
        position: relative;
        border: 1px solid #cdcdcd;
        /*-webkit-box-shadow: inset 0px 0px 10px 0px rgba(0,0,0,0.3);
        -moz-box-shadow: inset 0px 0px 10px 0px rgba(0,0,0,0.3);
        box-shadow: inset 0px 0px 10px 0px rgba(0,0,0,0.3);*/
    }

    .progress .progress-value {
        font-style: normal;
        margin: 0 auto;
        display: block;
        position: absolute;
        color: #000;
        text-align: center;
        line-height: 20px;
        width: 100%;
    }

    .progress-bar {
        text-align: left;
        transition: margin 3s;

        box-shadow: none;
        position: absolute;
        width: 100%;
        background-color: #f7f7f7;
    }

</style>
<script>
    /* $(document).ready(function () {
     var dataval = parseInt($('.progress').attr("data-amount"));
     if (dataval < 100) {
     $('.progress .amount').css("width", 100 - dataval + "%");
     }


     function modifyProgressVal(type) {
     dataval = parseInt($('.progress').attr("data-amount"));
     if (type == 1)
     dataval = Math.min(100, dataval + 10)
     else if (type == -1)
     dataval = Math.max(0, dataval - 10);
     $('.progress .amount').css("width", 100 - dataval + "%");
     $('.progress').attr("data-amount", dataval);
     }
     });*/
    $(document).ready(function () {
        function progressBar(id) {
            $(id).animate({
                width: "+=" + 100 - $(id).attr("aria-valuenow") + "%",
                marginLeft: "+=" + $(id).attr("aria-valuenow") + "%",
            }, 500);
        }

        progressBar('#pb1');
        progressBar('#pb2');

    });
</script>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Yii::t('wgt_Hosting/default', 'HOSTING') ?></h3>
        <div class="panel-option">
            <?= Html::a(Html::icon('settings'), ['/admin/app/widgets/update', 'alias' => get_class($this->context)], ['class' => 'btn btn-link']); ?>

        </div>

    </div>
    <div class="panel-body" style="padding:15px;">

        <?php if ($result->status == 'success') {

            $size = $this->context->ssdProcentLimit();
            $size2 = $this->context->ssdProcentLimit2();
            ?>

            <div class="progress">
                <div id="pb1" class="progress-bar" role="progressbar" aria-valuenow="<?= round($size, 2); ?>"
                     aria-valuemin="0"
                     aria-valuemax="100">
                </div>
                <span class="progress-value">Файлов <?= $result->data->used->inode ?>
                    из <?= $result->data->limit->inode ?> заполнено <?= round($size, 2); ?>%</span>
            </div>
            <br>

            <div class="progress">
                <div id="pb2" class="progress-bar progress-gradient" role="progressbar"
                     aria-valuenow="<?= round($size2, 2); ?>"
                     aria-valuemin="0" aria-valuemax="100">
                </div>
                <span class="progress-value">SSD заполнено <?= round($size2, 2); ?>%</span>
            </div>


            <?php
            //print_r($result);
            ?>
            <?php
        } else {
            $this->theme->alert('danger', $result->message, false);
        }
        ?>
    </div>
</div>