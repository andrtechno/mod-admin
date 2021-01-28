<?php if ($result) { ?>

    <?= $result['date']; ?>
    <table class="table table-striped table-bordered">
        <tr>
            <th class="font-weight-normal">Валюта</th>
            <th class="font-weight-normal">Курс покупки НБ</th>
            <th class="font-weight-normal">Курс продажи НБ</th>
        </tr>
        <?php foreach ($result['exchangeRate'] as $c) { ?>
            <?php if(isset($c['currency']) && $c['currency'] != 'UAH'){ ?>
                <tr>
                    <td><strong><?= $c['currency'] ?></strong></td>
                    <?php if(isset($c['purchaseRate'])){ ?>
                        <td>
                            <span class="text-muted"><?= $c['baseCurrency'] ?></span> <strong><?= $c['purchaseRateNB'] ?></strong> / <strong><?= $c['purchaseRate'] ?></strong>

                        </td>
                    <?php }else{ ?>
                        <td><span class="text-muted"><?= $c['baseCurrency'] ?></span> <strong><?= $c['purchaseRateNB'] ?></strong></td>
                    <?php } ?>

                    <td> <span class="text-muted"><?= $c['baseCurrency'] ?></span> <strong><?= $c['saleRateNB'] ?></strong></td>
                </tr>
            <?php } ?>
        <?php } ?>
    </table>
<?php } else { ?>
    <div class="alert alert-info m-3"><?= $error; ?></div>
<?php } ?>