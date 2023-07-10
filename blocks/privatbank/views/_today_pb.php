<?php if ($result) { ?>
    <table class="table table-striped table-bordered">
        <tr>
            <th class="font-weight-normal"><?= Yii::t('wgt_PrivatBank/default','CURRENCY'); ?></th>
            <th class="font-weight-normal"><?= Yii::t('wgt_PrivatBank/default','BUY'); ?></th>
            <th class="font-weight-normal"><?= Yii::t('wgt_PrivatBank/default','SELL'); ?></th>
        </tr>
        <?php foreach ($result as $c) { ?>
            <tr>
                <td><strong><?= $c['ccy'] ?></strong></td>
                <td><strong><?= $c['buy'] ?></strong> <span class="text-muted"><?= $c['base_ccy'] ?></span></td>
                <td><strong><?= $c['sale'] ?></strong> <span class="text-muted"><?= $c['base_ccy'] ?></span></td>

            </tr>
        <?php } ?>
    </table>
<?php } else { ?>
    <div class="alert alert-info m-3"><?= $error; ?></div>
<?php } ?>
