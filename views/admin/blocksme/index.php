<?php

$columns = array();
$columns[] = array('class' => 'CheckBoxColumn');
if (Yii::app()->user->openAccess(array("Admin.Blocks.*", "Admin.Blocks.Sortable"))) {
    $columns[] = array('class' => 'ext.sortable.SortableColumn');
}
$columns[] = 'name';
$columns[] = array(
    'name' => 'content',
    'value' => '($data->content)?"---":$data->widget;',
    'htmlOptions' => array('class' => 'text-center')
);
$columns[] = array(
    'name' => 'position',
    'value' => '$data->showPosition("$data->position")',
    'htmlOptions' => array('class' => 'text-center')
);
$columns[] = array(
    'name' => 'access',
    'value' => 'Yii::app()->access->getName($data->access)',
    'htmlOptions' => array('class' => 'text-center')
);
$columns[] = array(
    'name' => 'expire',
    'value' => '($data->expire>0)?CMS::purchased_time("$data->expire"):"Без ограничений"',
    'htmlOptions' => array('class' => 'text-center')
);
$columns[] = array(
    'class' => 'ButtonColumn',
    'template' => '{switch}{update}{delete}',
);
$this->widget('ext.adminList.GridView', array(
    'dataProvider' => $model->search(),
    'name' => $this->pageName,
    'headerOptions' => false,
    'autoColumns' => false,
    'columns' => $columns
));
