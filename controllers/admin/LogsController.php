<?php

namespace panix\mod\admin\controllers\admin;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\data\ArrayDataProvider;
use panix\engine\controllers\AdminController;
use panix\engine\CMS;

class LogsController extends AdminController
{

    public $icon = 'log';

    public function actionIndex()
    {

        $this->pageName = Yii::t('admin/default', 'LOGS');
        $this->breadcrumbs[] = $this->pageName;

        $logPath = Yii::getAlias(Yii::$app->runtimePath) . DIRECTORY_SEPARATOR . 'logs';

        //  $fdir = opendir(Yii::getAlias(Yii::$app->runtimePath).DIRECTORY_SEPARATOR.'logs');
        $folders = FileHelper::findDirectories($logPath, ['recursive' => false]);
        $data = [];
        foreach ($folders as $folder) {
            $foldersSub = FileHelper::findDirectories($folder, ['recursive' => false]);
            $foldersSubList = [];
            foreach ($foldersSub as $sub_folder) {
                $foldersSubList[] = Html::a(basename($sub_folder), ['view', 'folder' => basename(dirname($sub_folder)) . DIRECTORY_SEPARATOR . basename($sub_folder)]);
                //$filesList=[];
                //$files = FileHelper::findFiles($sub_folder);
                //foreach ($files as $file){
                //    $filesList[]=basename($file);
                //}
            }
            $data[] = [
                'sub_folders' => $foldersSubList,
                //'files'=>$filesList,
                'folder' => basename($folder)
            ];
        }
        // CMS::dump($folders);
        // CMS::dump($data);
        // die;


        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 10,
            ],
            // 'sort' => $sort,
        ]);


        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($folder)
    {
        $logPath = Yii::getAlias(Yii::$app->runtimePath) . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . $folder;
        $getFile = Yii::$app->request->get('file');


        if ($getFile) {

            $this->pageName = basename(ucfirst($getFile), '.log');
            $this->breadcrumbs[] = [
                'label' => Yii::t('admin/default', 'LOGS'),
                'url' => ['index']
            ];
            $this->breadcrumbs[] = [
                'label' => $folder,
                'url' => ['view', 'folder' => $folder]
            ];
            $this->breadcrumbs[] = $this->pageName;

            if (file_exists($logPath . DIRECTORY_SEPARATOR . $getFile)) {
                $log = file_get_contents($logPath . DIRECTORY_SEPARATOR . $getFile);
            }
            if (isset($log)) {
                $log = preg_split("/([0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}\s)+/", $log, -1, PREG_SPLIT_NO_EMPTY);
                // $pop = array_pop($log);
                $log = array_reverse($log);
            } else {
                $log = [];
            }

            $data = [];
            foreach ($log as $l) {
                preg_match('/\[(\w.*)\]\[(\d)\]\[(.*)\]\[(\w+)\]\[(\w.+)\]\s(\w.*)+/', $l, $match);
                $data[] = [
                    'ip' => isset($match[1]) ? $match[1] : null,
                    'user_id' => $match[2],
                    'session' => $match[3],
                    'type' => Html::tag('span', $match[4], $this->showStatus($match[4])),
                    'cmd' => $match[5],
                    'log' => $match[6]
                ];

            }

            $dataProvider = new ArrayDataProvider([
                'allModels' => $data,
                'pagination' => [
                    'pageSize' => 300,
                ],
            ]);


            return $this->render('view_file', [
                'content' => $log,
                'dataProvider' => $dataProvider
            ]);
        } else {


            $this->pageName = $folder;
            $this->breadcrumbs[] = [
                'label' => Yii::t('admin/default', 'LOGS'),
                'url' => ['index']
            ];
            $this->breadcrumbs[] = $this->pageName;

            $files = FileHelper::findFiles($logPath);
            $data = [];
            foreach ($files as $file) {
                $data[] = [
                    'size' => CMS::fileSize(filesize($file)),
                    'file' => $file
                ];
            }

            $dataProvider = new ArrayDataProvider([
                'allModels' => $data,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);


            return $this->render('view', [
                'dataProvider' => $dataProvider,
                'folder' => $folder
            ]);
        }

    }

    public function actionDelete($folder, $file)
    {

        $path = Yii::getAlias(Yii::$app->runtimePath) . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $file;
        if (file_exists($path)) {
            @unlink($path);
            Yii::$app->session->setFlash("success", Yii::t('app/default', 'FILE_SUCCESS_DELETE'));
        } else {
            Yii::$app->session->setFlash("danger", Yii::t('app/default', 'FILE_NOT_FOUND'));
        }

        // if (!Yii::$app->request->isPjax || !Yii::$app->request->isAjax) {
        return $this->redirect(['view', 'folder' => $folder]);
        // }
    }

    public function showStatus($text)
    {
        if (preg_match('%error%', $text)) {
            //  $this->last_status = '[error]';
            return array('status' => 'error', 'class' => 'badge badge-danger');
        } elseif (preg_match('%warning%', $text)) {
            // $this->last_status = '[warning]';
            return array('status' => 'warning', 'class' => 'badge badge-warning');
        } elseif (preg_match('%info%', $text)) {
            // $this->last_status = '[info]';
            return array('status' => 'info', 'class' => 'badge badge-info');
        } elseif (preg_match('%trace%', $text)) {
            // $this->last_status = '[sql]';
            return array('status' => 'trace', 'class' => 'badge badge-primary');
        } else {
            return array('status' => 'undefined', 'class' => '');
        }
    }
}
