<?php

use yii\helpers\Html;
use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;
?>



<?php

Pjax::begin([
    'id' => 'pjax-container', 'enablePushState' => false,
]);
?>
<?=

GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [

        'name',
        [
            'class' => 'panix\engine\grid\columns\ActionColumn',
            'template' => '{update} {switch} {delete}',
        ]
    ]
]);
?>
<?php Pjax::end(); ?>


<?php

/*
  $this->widget('ext.adminList.GridView', array(
  'dataProvider' => $model->search(),
  'enableCustomActions' => false,
  'selectableRows' => false,
  'autoColumns' => false,
  'enableHeader' => false, //rowHtmlOptionsExpression
  //'rowCssStyleExpression' => function($row, $data) {
  //    return ($data->info->name == 'unknown') ? 'background-color:#f2dede' : '';
  //},
  'columns' => array(
  array(
  'header' => '',
  'type' => 'html',
  'value' => 'Html::icon($data->info->icon,array("class"=>"size-x3"))',
  'htmlOptions' => array('class' => 'text-center')
  ),
  array(
  'name' => 'name',
  'type' => 'raw',
  'value' => '($data->info->adminHomeUrl) ? Html::link(CHtml::encode($data->info->name), $data->info->adminHomeUrl) : Html::encode($data->info->name)',
  ),
  array(
  'name' => 'access',
  'type' => 'html',
  'value' => 'Yii::app()->access->getName($data->access)',
  'htmlOptions' => array('class' => 'text-center')
  ),
  array(
  'name' => 'description',
  'value' => 'Html::encode($data->info->description)',
  'header' => Yii::t('app', 'DESCRIPTION'),
  ),
  array(
  'header' => Yii::t('app', 'VERSION'),
  'type' => 'raw',
  'value' => '$data->info->version',
  'htmlOptions' => array('class' => 'text-center')
  ),
  array(
  'header' => Yii::t('app', 'AUTHOR'),
  'type' => 'raw',
  'class' => 'EmailColumn',
  'value' => '$data->info->author',
  'htmlOptions' => array('class' => 'text-center')
  ),
  array(
  'class' => 'ButtonColumn',
  'template' => '{insert_sql}{switch}{update}{delete}',
  'buttons' => array(
  'insert_sql' => array(
  'label' => 'Insert SQL',
  'icon' => 'icon-upload',
  'url' => 'Yii::app()->controller->createUrl("insertSql",array("mod"=>$data->name))',
  'visible' => '$data->isInsertSql',
  'options'=>array('title'=>'Имортировать базу данных','onclick'=>'if(!confirm("Импортировать база данных?")) return false;'),


  )
  )
  ),
  ),
  ));
 */
?>
