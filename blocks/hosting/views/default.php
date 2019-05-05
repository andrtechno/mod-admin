<?php

use panix\engine\Html;
use panix\engine\CMS;

$this->registerCss('
.progress .progress-value {
    font-style: normal;
    margin: 0 auto;
    display: block;
    position: absolute;
    text-align: center;
    width: 100%;
    height: 100%;
    font-size: 90%;
    letter-spacing: .5px;
}

.progress-bar {
    text-align: left;
    transition: margin 3s;
    position: relative;
    width: 100%;
    background-color: #efefef;
}
');
$this->registerJs('
function progressBar(id) {
    $(id).animate({
        width: "+=" + 100 - $(id).attr("aria-valuenow") + "%",
        marginLeft: "+=" + $(id).attr("aria-valuenow") + "%",
    }, 500);
}
progressBar("#pb1 .progress-bar");
progressBar("#pb2 .progress-bar");
');
?>


<div class="card">
    <div class="card-header">
        <h5><?= $this->context->getTitle(); ?></h5>
        <div class="card-option">
            <?= Html::a(Html::icon('settings'), ['/admin/app/widgets/update', 'alias' => get_class($this->context)], ['class' => 'btn btn-link']); ?>
        </div>
    </div>
    <div class="card-body p-3">
        <h6>
            <?= Yii::t('wgt_Hosting/default', 'ACCOUNT_TITLE', [
                'name' => $this->context->config->account
            ]); ?>
        </h6>
        <?php if ($result['status'] == 'success') {

            $inode = $this->context->ssdPercentInode();
            $sdd = $this->context->ssdPercentSize();
            ?>

            <div class="progress" id="pb1">
                <div class="progress-bar" role="progressbar" aria-valuenow="<?= round($inode, 2); ?>"
                     aria-valuemin="0"
                     aria-valuemax="100">
                </div>
                <span class="progress-value">
                    <?= Yii::t('wgt_Hosting/default', 'PROGRESS_FILES', [
                        'used' => number_format($result['data']['used']['inode'],0,' ','.'),
                        'limit' => number_format($result['data']['limit']['inode'],0,' ','.'),
                        'percent' => round($inode, 2)
                    ]); ?>
                </span>
            </div>
            <br>

            <div class="progress" id="pb2">
                <div class="progress-bar" role="progressbar"
                     aria-valuenow="<?= round($sdd, 2); ?>"
                     aria-valuemin="0" aria-valuemax="100">
                </div>
                <span class="progress-value">
                    <?= Yii::t('wgt_Hosting/default', 'PROGRESS_SDD', [
                        'percent' => round($sdd, 2)
                    ]); ?>
                </span>
            </div>

            <?php
        } else {
            echo \panix\engine\bootstrap\Alert::widget([
                'body' => $result['message'],
                'options' => ['class' => 'alert-info']
            ]);
        }
        ?>
    </div>
</div>