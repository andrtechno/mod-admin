<?php

use panix\engine\Html;
?>
<div class="card bg-light grid">
    <div class="grid-loading"></div>
    <div class="card-header">
        <h5 class="clearfix">

            <span class="float-left"><?php if (isset($title)) echo $title; ?></span>

            <?php if (isset($buttons)) { ?>
                <span class="float-right">
                    <?php
                    foreach ($buttons as $btn) {
                        $icon='';
                        if(isset($btn['icon'])){
                            $icon = Html::icon($btn['icon']);
                        }
                        echo Html::a($icon.' '.$btn['label'], $btn['url'], isset($btn['options']) ? $btn['options'] : ['class'=>'btn btn-sm btn-success']);
                    }
                    ?>
                </span>
            <?php } ?>
        </h5>


    </div>
    <div class="card-body">
        <div class="table-responsive">{items}</div>

    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-md-6">{summary}</div>
            <div class="col-md-6 text-right">{pager}</div>
        </div>
    </div>
</div>