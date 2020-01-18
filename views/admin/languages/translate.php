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
    <div style="padding: 15px">
<?php


$result = array();

if ($lang) {
    $defaultLang = Yii::$app->languageManager->default->code;
    $modules = Yii::$app->getModules();

    // $this->remove_old_lang_dir("webroot.protected.messages.{$lang}");
    //$result = Yii::$app->cache->get('CACHE_LANGUAGE_TRANSLATE');
    //if ($result === false) {


    //  $dir = Yii::getPathOfAlias("webroot.protected.messages.{$defaultLang}");
    $engineFiles = $this->context->getFindFiles('@vendor/panix/engine/messages/' . $defaultLang);
    foreach ($engineFiles as $file) {
     //  $result['application'][] = array('file' => basename($file), 'path' => '@vendor/panix/engine/messages');
    }



    foreach ($modules as $mod => $obj) {

        $this->context->remove_old_lang_dir("@{$mod}/messages/" . $lang);
        $files = $this->context->getFindFiles("@{$mod}/messages/" . $defaultLang);
        if ($files) {
            foreach ($files as $file) {
                $result[$mod][] = array('file' => basename($file), 'path' => "@{$mod}/messages");
                break;
            }
        }
    }
//print_r($result);die;

    // Yii::app()->cache->set('CACHE_LANGUAGE_TRANSLATE', $result, 3600);
    //}
    ?>

    <?php
    // Yii::app()->tpl->alert('info', 'Пожалуйста дождитесь окончание результата.', false);
    ?>

    <div class="card card-default">
        <div class="card-header">
            <div class="panel-title" style="padding-right: 15px;">
                <div class="row">
                    <div class="col-sm-4">
                        <h5 id="progress-send"></h5>
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
                    var status = (data.status == 'success')?data.status:'danger';
                    var result = Math.round((num / getFilesTotalCount() * 100), 2);
                    $('.progress .progress-bar').css({'width': result + '%'}).html(result + '%');
                    $('#sended').text(num - 1 + 1);
                    $('#result tbody #row' + num).html('<td>' + taskNum[i].file + ' </td><td class=\"text-center\">' + mod + '</td><td class=\"text-center\"><span class=\"badge badge-' + status + '\">' + data.message + '</span></td>');
                    next();
                },
                beforeSend: function () {

                    $('#result tbody').prepend($('<tr/>', {'id': 'row' + num}));
                    $('#result tbody #row' + num).html('<td><div class=\"ajax-loading\"></div>Подождите, идет процес перевода.</td><td colspan=\"2\"><div id=\"progress'+ num + '\" class=\"progress\"><div class=\"progress-bar progress-bar-success\" style=\"width: 0%;\"></div></div></td>');
                    //$('.senden-row' + i).text('Идет отправка...');
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

    $('#progress-send').html('Переведино: <span id=\"sended\">0</span> из ' + getFilesTotalCount());
    

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