<?php if ($result) { ?>
    <table class="table table-striped table-bordered">
        <tr>
            <th class="font-weight-normal"><?= Yii::t('wgt_PrivatBank/default', 'CURRENCY'); ?></th>
            <th class="font-weight-normal">Курс покупки НБ</th>
            <th class="font-weight-normal">Курс продажи НБ</th>
        </tr>
        <?php foreach ($result['exchangeRate'] as $c) { ?>
            <?php if (isset($c['currency']) && $c['currency'] != 'UAH') { ?>
                <?php if (in_array($c['currency'], ['USD', 'EUR'])) { ?>
                    <tr>
                        <td><strong><?= $c['currency'] ?></strong></td>
                        <?php if (isset($c['purchaseRate'])) { ?>
                            <td>
                                <strong><?= $c['purchaseRateNB'] ?></strong> /
                                <strong><?= $c['purchaseRate'] ?></strong> <span
                                        class="text-muted"><?= $c['baseCurrency'] ?></span>
                            </td>
                        <?php } else { ?>
                            <td><strong><?= $c['purchaseRateNB'] ?></strong> <span
                                        class="text-muted"><?= $c['baseCurrency'] ?></span></td>
                        <?php } ?>
                        <td><strong><?= $c['saleRateNB'] ?></strong> <span
                                    class="text-muted"><?= $c['baseCurrency'] ?></span></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </table>
<?php } else { ?>
    <div class="alert alert-info m-3"><?= $error; ?></div>
<?php } ?>
