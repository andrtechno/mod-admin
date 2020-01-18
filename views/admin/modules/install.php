<?php
use panix\engine\Html;
if (!empty($modules)) {
    ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th></th>
                <th><?= Yii::t('app/default', 'NAME') ?></th>
                <th><?= Yii::t('app/default', 'DESCRIPTION') ?></th>
                <th><?= Yii::t('app/default', 'VERSION') ?></th>
                <th><?= Yii::t('app/default', 'AUTHOR') ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($modules as $module => $info) { ?>
                <tr>
                    <td class="text-center"><?=$info->icon?><?= Html::icon($info->icon, array('class' => 'size-x3')) ?></td>
                    <td><?= Html::encode($info->name) ?></td>
                    <td><?= $info->description ?></td>
                    <td class="text-center"><?= $info->version ?></td>
                    <td class="text-center"><?= Html::a($info->author, 'mailto:' . $info->author) ?></td>
                    <td class="text-center"><?= Html::a(Yii::t('admin/default', 'INSTALLED'), ['install', 'name' => $module], array('class' => 'btn btn-success')) ?></td>
                </tr>
            <?php } ?>
        </tbody></table>
<?php } else { ?>
    <?php Yii::t('admin/default', 'NO_MODULES_INSTALL') ?>
<?php } ?>




