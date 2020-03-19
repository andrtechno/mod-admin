<?php
use yii\helpers\Json;
use yii\helpers\Html;
use panix\mod\admin\models\Languages;

$langModel = new Languages;


?>
    <div style="padding: 15px">
        <?php
        //   Yii::app()->tpl->alert('info',Yii::t('app/default','TRANSLATE_ALERT_INFO'),false);

        $lang = Yii::$app->request->get('lang');
        if (!$lang) {

            echo Html::beginForm('', 'GET');
            echo Html::dropDownList('lang', null, $langModel->dataLangList, array('class' => 'form-control'));
            echo Html::submitButton('Начать перевод', array('class' => 'btn btn-success'));
            echo Html::endForm();
            ?>

            <?php
            // return;
        } ?>
    </div>

<?php


$result = [];

if ($lang) {
    $defaultLang = Yii::$app->languageManager->default->code;

    foreach ($this->context->getAllFiles() as $path => $files) {
        foreach ($files as $file) {
            $result[$path][] = ['file' => basename($file), 'path' => $path];
            break;
        }
    }

    ?>
    <div class="card">
        <div class="card-header">
            <div class="container-fluid pt-2 pb-2">
                <div class="row">
                    <div class="col-sm-4">
                        <h5>Переведино: <span id="current-send">0</span> из <span id="total-files">0</span></h5>
                    </div>
                    <div class="col-sm-8 d-flex align-items-center">
                        <div class="progress d-none w-100">
                            <div class="progress-bar progress-bar-success progress-bar-striped progress-bar-animated"
                                 style="width: 0%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body panel-container">
            <table id="result" class="table table-striped table-bordered">
                <thead>
                <th width="70%">Файл</th>
                <th width="15%">Раздел</th>
                <th width="15%"><?= Yii::t('app/default', 'STATUS') ?></th>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

<?php } ?>


<?php

$this->registerJs("


   var json = " . Json::encode($result) . ";
    var counter = 0;
    var lang = '" . $lang . "';

    function getFilesTotalCount() {
        var result = 0;
        $.each(json, function (i, v) {
            result += v.length;
        });
        return result;
    }

    function doTask(taskNum, next, i, mod, num) {
        var time = Math.floor(Math.random() * 3000);
        $('.progress').removeClass('d-none');
        


        setTimeout(function () {
            var start_time = new Date().getTime();
            console.time(\"concatenation\");
            $.ajax({
                type: 'POST',
                url: '/admin/app/languages/ajax-application?lang=' + lang,
                data: {
                    file: taskNum[i].file,
                    path: taskNum[i].path
                },
                dataType: 'json',
                success: function (data) {
                    var end_time = (start_time - (new Date().getTime()));

console.log(end_time);
console.timeEnd(\"concatenation\");
console.time();
                    var status = (data.success)?'success':'danger';
                    var result = Math.round((num / getFilesTotalCount() * 100), 2);
                    $('.progress .progress-bar').css({'width': result + '%'}).html(result + '%');
                    $('#current-send').text(num - 1 + 1);
                    $('#result tbody #row' + num).html('<td>' + taskNum[i].file + ' </td><td class=\"text-center\">' + mod + '</td><td class=\"text-center\"><span class=\"badge badge-' + status + '\">' + data.message + '</span></td>');
                    next();
                },
                beforeSend: function () {
                    $('#result tbody').prepend($('<tr/>', {'id': 'row' + num}));
                    $('#result tbody #row' + num).html('<td><div class=\"ajax-loading\"></div>Подождите, идет процес перевода.</td><td colspan=\"2\"><div id=\"progress'+ num + '\" class=\"progress\"><div class=\"progress-bar progress-bar-success\" style=\"width: 0%;\"></div></div></td>');
                },
                complate: function () {

                },
                error: function (XHR, textStatus, errorThrown) {
                    $('#result tbody #row' + num).html('<td colspan=\"2\">Error: ' + XHR.status + ' ' + XHR.statusText + '</td>');
                    common.notify('Error: ' + XHR.status + ' ' + XHR.statusText,'error');

                }
            });



        }, time);
    }

    function createTask(taskNum, i, mod, num) {
        return function (next) {
            doTask(taskNum, next, i, mod, num);
        };
    }
    
    $('#total-files').html(getFilesTotalCount());

    $.each(json, function (mod, files) {
        for (var i = 0; i < files.length; i++) {
            counter++;
            $(document).queue('tasks', createTask(files, i, mod, counter));
        }
    });

    $(document).queue('tasks', function () {
        console.log('Translate: all done');
        $('.progress .progress-bar').removeClass('progress-bar-animated').html('Готово');
    });

    $(document).dequeue('tasks');


", \yii\web\View::POS_END);

?>