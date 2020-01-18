<?php

use panix\engine\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use panix\engine\Html;
use panix\engine\CMS;
use panix\engine\grid\GridView;


$type = Yii::$app->request->post('type');

if (!$db->checkLimit()) {

    echo panix\engine\bootstrap\Alert::widget([
        //'closeButton' => false,
        'options' => [
            'class' => 'alert-danger',
        ],
        'body' => Yii::t('admin/default', 'BACKUP_LIMIT', [
            'maxsize' => CMS::fileSize($db->limitBackup),
            'current_size' => CMS::fileSize($db->checkFilesSize())
        ])
    ]);
}

?>


<div class="row">
    <div class="col-md-6">
        <?php

        $form = ActiveForm::begin();
        ?>
        <div class="card">
            <div class="card-header">
                <h5><?= $this->context->pageName ?></h5>
            </div>
            <div class="card-body">
                <?= $form->field($model, 'backup')->checkbox() ?>
                <?= $form->field($model, 'backup_limit') ?>


            </div>
            <div class="card-footer text-center">
                <?= Html::submitButton(Yii::t('app/default', 'SAVE'), ['class' => 'btn btn-success']) ?>
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
            // 'filterModel' => $searchModel,
            'layoutOptions' => ['title' => $this->context->pageName],
            'columns' => [
                [
                    'attribute' => 'filename',
                    'header' => Yii::t('app/default', 'FILENAME'),
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-left'],
                ],
                [
                    'attribute' => 'filesize',
                    'header' => Yii::t('app/default', 'SIZE'),
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'attribute' => 'url',
                    'header' => Yii::t('app/default', 'OPTIONS'),
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'class' => 'panix\engine\grid\columns\ActionColumn',
                    'template' => '{active}',
                    'header' => Yii::t('app/default', 'OPTIONS'),
                    'buttons' => [
                        'delete' => function ($url, $model, $key) {

                            return Html::a('<i class="icon-delete"></i>', $url, [
                                'title' => Yii::t('app/default', 'DELETE'),
                                'class' => 'btn btn-sm btn-danger']);
                        },
                        "active" => function ($url, $model) {

                            $url = Yii::$app->urlManager->createUrl(['/admin/app/database/delete', 'file' => $model['filename']]);

                            return Html::a('dsadas', $url, [
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'title' => Yii::t('app/default', 'Toogle Active'),
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
        <div class="card">
            <div class="card-header">
                <h5><?= Yii::t('admin/default', 'DB_OPTIMIZE_REPAIR') ?></h5>
            </div>
            <?php
            echo Html::beginForm('', 'POST', ['class' => 'form-horizontal']);
            ?>
            <div class="card-body">
                <?php
                $db = Yii::$app->db;
                $dbSchema = $db->schema;
                $tables = array();


                //die;

                foreach ($dbSchema->tableNames as $tbl) {
                    // $tbl_name = str_replace('`', '', $tbl->rawName);
                    $tables[$tbl] = $tbl;
                }

                ?>
                <div class="form-group row" style="">
                    <div class="col-sm-12 text-center">
                        <?= Html::dropDownList('datatable[]', null, $tables, ['multiple' => true, 'class' => 'custom-select']) ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        <?= Html::dropDownList('type', $type, [
                            'optimize' => Yii::t('admin/default', 'OPTIMIZE_DB'),
                            'repair' => Yii::t('admin/default', 'REPAIR_DB')
                        ], ['class' => 'custom-select']); ?>

                    </div>
                </div>

                <?php


                if ($type == 'optimize') {
                    ?>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <?= Yii::t('admin/default', 'OPTIMIZE_DB') ?>: <span
                                    class="badge badge-secondary"><?= CMS::tableName() ?></span>
                        </li>
                        <li class="list-group-item">
                            <?= Yii::t('admin/default', 'TOTAL_SIZE_DB') ?>: <span
                                    class="badge badge-secondary"><?= CMS::fileSize($totaltotal) ?></span>
                        </li>
                        <li class="list-group-item">
                            <?= Yii::t('admin/default', 'TOTAL_OVERHEAD') ?>: <span
                                    class="badge badge-secondary"><?= CMS::fileSize($totalfree) ?></span>
                        </li>
                    </ul>

                    <?php
                    if ($providerOptimize) {
                        echo GridView::widget([
                            'tableOptions' => ['class' => 'table table-striped'],
                            'dataProvider' => $providerOptimize,
                            'layoutOptions' => ['title' => Yii::t('admin/default', 'OPTIMIZE_DB')],
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'text-center']
                                ],
                                [
                                    'attribute' => 'table',
                                    'header' => Yii::t('app/default', 'TABLE'),
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-left'],
                                ],
                                [
                                    'attribute' => 'total_size',
                                    'header' => Yii::t('app/default', 'SIZE'),
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'attribute' => 'status',
                                    'header' => Yii::t('app/default', 'OPTIONS'),
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'attribute' => 'free',
                                    'header' => Yii::t('app/default', 'free'),
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
                        <li class="list-group-item">
                            <?= Yii::t('admin/default', 'REPAIR_DB') ?>: <span
                                    class="badge badge-secondary"><?= CMS::tableName() ?></span>
                        </li>
                        <li class="list-group-item">
                            <?= Yii::t('admin/default', 'TOTAL_SIZE_DB') ?>: <span
                                    class="badge badge-secondary"><?= CMS::fileSize($totaltotal) ?></span>
                        </li>
                    </ul>
                    <?php
                    if ($providerRepair) {
                        echo GridView::widget([
                            'tableOptions' => ['class' => 'table table-striped'],
                            'dataProvider' => $providerRepair,
                            'layoutOptions' => ['title' => Yii::t('admin/default', 'REPAIR_DB')],
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'text-center']
                                ],
                                [
                                    'attribute' => 'table',
                                    'header' => Yii::t('app/default', 'TABLE'),
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-left'],
                                ],
                                [
                                    'attribute' => 'total_size',
                                    'header' => Yii::t('app/default', 'SIZE'),
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'attribute' => 'status',
                                    'header' => Yii::t('app/default', 'OPTIONS'),
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
            <div class="card-footer text-center">
                <?= Html::submitButton('OK', ['class' => 'btn btn-success']); ?>
            </div>
            <?php
            echo Html::endForm();
            ?>
        </div>

    </div>


</div>