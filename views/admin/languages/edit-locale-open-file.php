<?php

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use panix\engine\Html;

/**
 * @var \yii\web\View $this
 */



$form = ActiveForm::begin([
    'id' => 'locale-form',
    'options' => ['class' => 'form-horizontal'],
])
?>
    <div class="card">
        <div class="card-header">
            <h5><?= $this->context->pageName; ?></h5>
        </div>
        <div class="card-body">
            <?php
            if ($noFindLanguages) { ?>
                <div class="alert alert-warning">
                    Внимаение! Не найден язык <strong>"<?= implode(', ', $noFindLanguages); ?>"</strong>
                </div>
            <?php }

            ?>
            <table class="table table-striped">
                <tr>
                    <th width="30%">Ключ</th>
                    <th width="70%">Значение</th>
                </tr>
                <?php foreach ($res as $name => $item) { ?>
                    <tr>
                        <td>
                            <?php
                            //\panix\engine\CMS::dump($item);
                            ?>
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

                                            <?php echo Html::img("/uploads/language/{$tabs[$language]['slug']}.png"); ?>
                                            <span class="d-none d-md-inline-block"><?php echo $tabs[$language]['name']; ?></span>
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

                                        <?= \yii\helpers\Html::textarea("form[{$language}][$name]", $value, ['class' => 'form-control', 'id' => 'textarea-' . md5($name . $language)]); ?>

                                        <?= Html::button('Визуальный редактор', [
                                            'data-textarea' => 'textarea-' . md5($name . $language),
                                            'data-lang' => $language,
                                            'class' => 'btn btn-sm btn-link visual-editor'
                                        ]); ?>
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

<?php
\panix\ext\tinymce\TinyMceAsset::register($this);
//\panix\ext\tinymce\TinyMceLangAsset::register($this);
//\panix\ext\tinymce\TinyMce::widget()
$this->registerJs("



        
$('.visual-editor').on('click',function(){
var selector = $(this).data('textarea');
var lang = $(this).data('lang');



    tinymce.init({
        selector:'#'+selector,
       // language:'ru',
        branding:false,
        statusbar:false,
        forced_root_block:'',
        menubar:false,
        plugins: [
                'textcolor autoresize image template advlist autolink lists link charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime table contextmenu paste'
            ],
        toolbar:'forecolor backcolor | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link |'
    });

//tinymce.EditorManager.execCommand('mceAddEditor', true, \"here_place_editor_class or ID\");
//console.log(tinymce.EditorManager.get('#'+selector));
//console.log(tinymce.get('#'+selector));
 // tinymce.execCommand('mceRemoveControl', false, '#'+selector);
//tinymce.EditorManager.remove('#'+selector)
});

");
