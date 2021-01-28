<?php if ($result) { ?>


    <table class="table table-striped table-bordered">
        <tr>
            <th class="font-weight-normal">Валюта</th>
            <th class="font-weight-normal">Курс: покупка / продажа</th>

        </tr>
        <?php foreach ($result as $c) { ?>
            <tr>
                <td><strong><?= $c['ccy'] ?></strong></td>
                <td> <span class="text-muted"><?= $c['base_ccy'] ?></span> <strong><?= $c['buy'] ?> / <strong><?= $c['sale'] ?></strong></td>

            </tr>
        <?php } ?>
    </table>
<?php } else { ?>
    <div class="alert alert-info m-3"><?= $error; ?></div>
<?php } ?>
