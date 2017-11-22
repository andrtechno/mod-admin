<?php
use yii\helpers\Inflector;
?>

<div class="alert alert-<?= $type ?>" id="alert<?= md5($type . Inflector::slug($message)) ?>">
    <?= $message ?>
    <?php if ($close) { ?>
        <button type="button" class="close" onClick="common.close_alert('<?= md5($type . Inflector::slug($message)) ?>'); return false;" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?php } ?>
</div>