<?php

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Html;

//echo \panix\engine\CMS::dump($r);
?>
<div class="card">
    <div class="card-header">
        <h5><?= $this->context->pageName; ?></h5>
    </div>
    <div class="card-body">

        <?=
        GridView::widget([
            'id' => 'grid-locale',
            'tableOptions' => ['class' => 'table table-striped'],
            'dataProvider' => $provider,
            'showHeader' => false,
            'columns' => [
                [
                    'attribute' => 'key',
                    'header' => Yii::t('app/default', 'Группа'),
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-left'],
                    'value' => function ($data) {
                        if ($data['url']) {
                            //  return Html::a($data['key'], $data['url']);

                            $link = Html::a($data['key'], '#collapse-locale-' . md5($data['key']), [
                                'data-toggle' => 'collapse',
                                'class' => 'h5',
                                'aria-expanded' => 'false',
                                'aria-controls' => 'collapse-locale-' . md5($data['key'])
                            ]);
                            $html='';
                            if (isset($data['items'])) {
                                $html = $link . '<div class="collapse" id="collapse-locale-' . md5($data['key']) . '"><ul class="ml-3 mt-3 list-unstyled">';
                                foreach ($data['items'] as $item) {
                                    $html .= '<li>' . Html::a(ucfirst(basename($item, '.php')), ['/admin/app/languages/edit-locale', 'key' => $data['key'], 'file' => $item]) . '</li>';
                                }
                                $html .= '<ul></div>';
                            }
                            return $html;


                        }
                    }
                ],
                /* [
                     'attribute' => 'items',
                     'header' => Yii::t('app/default', 'Группа'),
                     'format' => 'raw',
                     'contentOptions' => ['class' => 'text-left'],
                     'value' => function ($data) {
                        // print_r($data['items']);die;
                         $html='<div class="collapse" id="collapse-locale-'.md5($data['key']).'">';
                         foreach ($data['items'] as $item){
                             $html.= $item.'<br>';
                         }
                         $html.='</div>';
                         return $html;
                     }
                 ],*/

                /* [
                     'class' => 'panix\engine\grid\columns\ActionColumn',
                     'template' => '{delete}',
                     'header' => Yii::t('app/default', 'OPTIONS'),
                     'buttons' => [
                         'delete' => function ($url, $model, $key) {

                             return Html::a('<i class="icon-delete"></i>', $url, [
                                 'title' => Yii::t('app/default', 'DELETE'),
                                 'class' => 'btn btn-sm btn-danger']);
                         }
                     ]
                 ]*/
            ]
        ]);
        ?>

    </div>
</div>

