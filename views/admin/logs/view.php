<?php
use panix\engine\widgets\Pjax;
use panix\engine\grid\GridView;
use panix\engine\Html;


Pjax::begin([
    //  'dataProvider' => $dataProvider,
]);
echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'attribute' => 'file',
            'header' => Yii::t('app/default', 'FILENAME'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
            'value' => function ($model) use ($folder) {
                $file = basename($model['file']);
                $pathInfo = pathinfo($file);

                if ($pathInfo['extension'] == 'log') {
                    return Html::icon('external-link') . ' ' . Html::a($file, ['view', 'folder' => $folder, 'file' => $file]);
                } elseif($pathInfo['extension'] == 'zip') {
                    $zip = new ZipArchive();
                    $filename = [];
                    if ($zip->open($model['file']) == true) {
                        for ($i = 0; $i < $zip->numFiles; $i++) {
                            $filename[] = '&mdash; ' . $zip->getNameIndex($i);
                        }
                    }
                    return '<strong>' . $file . '</strong> ' . Html::tag('span', 'Архив', ['class' => 'badge badge-secondary']) . '<br/>' . implode('<br/>', $filename);
                }
            }
        ],
        [
            'attribute' => 'size',
            'header' => Yii::t('app/default', 'SIZE'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center']
        ],
        [
            'class' => 'panix\engine\grid\columns\ActionColumn',
            'template' => '{delete}',
            'header' => Yii::t('app/default', 'OPTIONS'),
            'buttons' => [
                'delete' => function ($url, $model, $key) use ($folder) {
                    $url = ['delete', 'folder' => $folder, 'file' => basename($model['file'])];
                    return Html::a(Html::icon('delete'), $url, [
                        'title' => Yii::t('app/default', 'DELETE'),
                        'class' => 'btn btn-sm btn-danger']);
                },
            ]
        ]
    ]
]);
Pjax::end();