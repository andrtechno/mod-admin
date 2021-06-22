<?php

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use panix\engine\Html;

//echo \panix\engine\CMS::dump($res);die;
$form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal'],
])
?>
<div class="card">
    <div class="card-header">
        <h5>ads</h5>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <tr>
                <th>KEY</th>
                <th>val</th>
            </tr>
            <?php foreach ($res as $name => $item) { ?>
                <tr>
                    <td>
                        <?= $name; ?>
                    </td>
                    <td>
                        <?php foreach ($item as $language => $value) { ?>

                        <?php } ?>
                        <ul class="nav nav-tabs" role="tablist">
                            <?php foreach ($item as $language => $value) { ?>
                                <?php $active = ($language == Yii::$app->language) ? 'active' : ''; ?>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link <?= $active ?>" id="home-tab" data-toggle="tab"
                                       href="#t<?= md5($name . $language); ?>" role="tab"
                                       aria-controls="t<?= md5($name . $language); ?>"
                                       aria-selected="true">

                                        <?php //echo Html::img("/uploads/language/{$tabs[$language]['slug']}.png"); ?>
                                        <span class="d-none d-md-inline-block">zz<?php // $tabs[$language]['name']; ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <?php foreach ($item as $language => $value) { ?>
                                <?php $active = ($language == Yii::$app->language) ? 'show active' : ''; ?>
                                <div class="tab-pane fade <?= $active ?>" id="t<?= md5($name . $language); ?>"
                                     role="tabpanel"
                                     aria-labelledby="t<?= md5($name . $language); ?>-tab">

                                    <?= \yii\helpers\Html::textarea("form[{$language}][$name]", $value, ['class' => 'form-control']); ?>

                                </div>
                            <?php } ?>
                        </div>
                    </td>

                </tr>
            <?php } ?>
        </table>
    </div>
    <div class="card-footer text-center">
        <?= Html::submitButton(Yii::t('app/default', 'SAVE'), ['class' => 'btn btn-success']) ?>
    </div>


</div>
<?php ActiveForm::end() ?>

