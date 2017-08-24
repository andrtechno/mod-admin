<?php

use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use panix\engine\Html;
use panix\engine\CMS;
use panix\engine\grid\GridView;
?>








<?php
$type = Yii::$app->request->post('type');
?>


<?php
if (!$db->checkLimit()) {

    echo yii\bootstrap\Alert::widget([
        'closeButton'=>false,
        'options' => [
            'class' => 'alert-danger',
        ],
        'body' => Yii::t('admin/default', 'BACKUP_LIMIT', array(
            'maxsize' => CMS::files_size($db->limitBackup),
            'current_size' => CMS::files_size($db->checkFilesSize())
        ))
    ]);
}
?>




<div class="row">
    <div class="col-md-6">
<?php

$form = ActiveForm::begin([

            'layout' => 'horizontal',
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'label' => 'col-sm-4',
                    'offset' => 'col-sm-offset-4',
                    'wrapper' => 'col-sm-8',
                    'error' => '',
                    'hint' => '',
                ],
            ],
        ]);
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $this->context->pageName ?></h3>
    </div>
    <div class="panel-body">
        <?= $form->field($model, 'backup')->checkbox() ?>
        <?= $form->field($model, 'backup_limit') ?>


    </div>
    <div class="panel-footer text-center">
        <?= Html::submitButton(Yii::t('app', 'SAVE'), ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>


<?php
yii\widgets\Pjax::begin([
    'id' => 'pjax-container-backup',
    'enablePushState' => false,
    'enableReplaceState' => false,
]);
?>
<?=
GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $data_db,
    'filterModel' => $searchModel,
    'layout' => $this->render('@app/web/themes/admin/views/layouts/_grid_layout', ['title' => $this->context->pageName]), //'{items}{pager}{summary}'
    'columns' => [
        [
            'attribute' => 'filename',
            'header' => Yii::t('app', 'FILENAME'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'filesize',
            'header' => Yii::t('app', 'SIZE'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'url',
            'header' => Yii::t('app', 'OPTIONS'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'class' => 'panix\engine\grid\columns\ActionColumn',
            'template' => '{active}',
            'buttons' => [
                'delete' => function ($url, $model, $key) {

                    return Html::a('<i class="icon-delete"></i>', $url, [
                                'title' => Yii::t('app', 'DELETE'),
                                'class' => 'btn btn-sm btn-danger']);
                },
                        "active" => function ($url, $model) {

                    $url = Yii::$app->urlManager->createUrl(['/admin/app/database/delete', 'file' => $model['filename']]);

                    return Html::a('dsadas', $url, [
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'title' => Yii::t('app', 'Toogle Active'),
                                'data-pjax' => '#pjax-container-backup',
                                'data-method' => 'post'
                    ]);
                },
                    ]
                ]
            ]
        ]);
        ?>
                <?php Pjax::end(); ?>
    </div>



    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Yii::t('admin/default', 'DB_OPTIMIZE_REPAIR') ?></h3>
            </div>
            <div class="panel-body">
                <?php
                $db = Yii::$app->db;
                $dbSchema = $db->schema;
                $tables = array();





                //die;

                foreach ($dbSchema->tableNames as $tbl) {
                    // $tbl_name = str_replace('`', '', $tbl->rawName);
                    $tables[$tbl] = $tbl;
                }
                echo Html::beginForm('', 'POST', ['class' => 'form-horizontal']);
                ?>
                <div class="form-group" style="display: none;">
                    <div class="col-sm-12  text-center">
                        <?= Html::dropDownList('datatable[]', null, $tables, ['multiple' => true]) ?>

                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 text-center">

                        <?= Html::dropDownList('type', $type, array('optimize' => Yii::t('admin/default', 'OPTIMIZE_DB'), 'repair' => Yii::t('admin/default', 'REPAIR_DB'))) ?>
                        <?= Html::submitButton('OK', array('class' => 'btn btn-success')); ?>

                    </div>
                </div>

                <?=
                Html::endForm();






                if ($type == 'optimize') {
                    ?>
                    <ul class="list-group">
                        <li class="list-group-item"><?= Yii::t('admin/default', 'OPTIMIZE_DB') ?>: <span class="label label-default"><?= CMS::tableName() ?></span></li>
                        <li class="list-group-item"><?= Yii::t('admin/default', 'TOTAL_SIZE_DB') ?>: <span class="label label-default"><?= CMS::files_size($totaltotal) ?></span></li>
                        <li class="list-group-item"><?= Yii::t('admin/default', 'TOTAL_OVERHEAD') ?>: <span class="label label-default"><?= CMS::files_size($totalfree) ?></span></li>
                    </ul>

                    <?php
                    if ($providerOptimize) {
                        echo GridView::widget([
                            'tableOptions' => ['class' => 'table table-striped'],
                            'dataProvider' => $providerOptimize,
                            'layout' => $this->render('@app/web/themes/admin/views/layouts/_grid_layout', ['title' => Yii::t('admin/default', 'OPTIMIZE_DB')]), //'{items}{pager}{summary}'
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'text-center']
                                ],
                                [
                                    'attribute' => 'table',
                                    'header' => Yii::t('app', 'TABLE'),
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-left'],
                                ],
                                [
                                    'attribute' => 'total_size',
                                    'header' => Yii::t('app', 'SIZE'),
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'attribute' => 'status',
                                    'header' => Yii::t('app', 'OPTIONS'),
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'attribute' => 'free',
                                    'header' => Yii::t('app', 'free'),
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                            ]
                        ]);
                    }
                    ?>
                    <?php
                } elseif ($type == 'repair') {
                    ?>

                    <ul class="list-group">
                        <li class="list-group-item"><?= Yii::t('admin/default', 'REPAIR_DB') ?>: <span class="label label-default"><?= CMS::tableName() ?></span></li>
                        <li class="list-group-item"><?= Yii::t('admin/default', 'TOTAL_SIZE_DB') ?>: <span class="label label-default"><?= CMS::files_size($totaltotal) ?></span></li>
                    </ul>
                    <?php
                    if ($providerRepair) {
                        echo GridView::widget([
                            'tableOptions' => ['class' => 'table table-striped'],
                            'dataProvider' => $providerRepair,
                            'layout' => $this->render('@app/web/themes/admin/views/layouts/_grid_layout', ['title' => Yii::t('admin/default', 'REPAIR_DB')]), //'{items}{pager}{summary}'
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'text-center']
                                ],
                                [
                                    'attribute' => 'table',
                                    'header' => Yii::t('app', 'TABLE'),
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-left'],
                                ],
                                [
                                    'attribute' => 'total_size',
                                    'header' => Yii::t('app', 'SIZE'),
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'attribute' => 'status',
                                    'header' => Yii::t('app', 'OPTIONS'),
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                            ]
                        ]);
                    }
                    ?>
                    <?php
                }
                ?>

















            </div>
        </div>
    </div>

   
</div>