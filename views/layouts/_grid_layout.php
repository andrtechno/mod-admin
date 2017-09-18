<?php
use yii\helpers\Html;
?>
<div class="panel panel-default grid">
    <div class="grid-loading"></div>
    <div class="panel-heading">
        <div class="panel-title"><?php if(isset($title)) echo $title; ?>
            <?php if (isset($buttons)) { ?>
                <div id="grid-options" class="dropdown panel-option">
                    <?php
                    foreach ($buttons as $btn) {
                        echo Html::a($btn['label'], $btn['url'], isset($btn['options']) ? $btn['options'] : []);
                    }
                    ?>
                    <a class="dropdown-toggle btn btn-link" href="javascript:void(0);" data-toggle="dropdown" aria-expanded="true"><i class="icon-settings"></i></a>
                    <ul class="dropdown-menu dropup pull-right">
                        <li>
                            <a onclick="return grid.editcolums('orderproduct-grid', 'OrderProduct', 'cart');" href="javascript:void(0);">
                                <i class="icon-grid"></i>Изменить столбцы таблицы</a>
                        </li>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="panel-body">
        <div class="table-responsive">{items}</div>
            
    </div>
    <div class="panel-footer">
        <div class="row">
            <div class="col-md-6">{summary}</div>
            <div class="col-md-6 text-right">{pager}</div>
        </div>
    </div>
</div>