<?php

namespace panix\mod\admin\controllers\admin;

use Yii;
use yii\helpers\FileHelper;
use panix\engine\Html;
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

        $folders = FileHelper::findDirectories($logPath, ['recursive' => false]);
        $data = [];
        foreach ($folders as $folder) {
            $foldersSub = FileHelper::findDirectories($folder, ['recursive' => false]);
            $foldersSubList = [];
            foreach ($foldersSub as $sub_folder) {
                $foldersSubList[] = Html::a(Html::icon('folder-open') . ' ' . basename($sub_folder), ['view', 'folder' => basename(dirname($sub_folder)) . DIRECTORY_SEPARATOR . basename($sub_folder)]);
            }
            $data[] = [
                'sub_folders' => $foldersSubList,
                //'files'=>$filesList,
                'folder' => basename($folder)
            ];
        }


        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 10,
            ],
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
                $log = preg_split("/([0-9]{4}-[0-9]{2}-[0-9]{2})\s/", $log, -1, PREG_SPLIT_NO_EMPTY);
                // $pop = array_pop($log);
                $log = array_reverse($log);
                //  CMS::dump($log);die;
            } else {
                $log = [];
            }

            $data = [];
            foreach ($log as $l) {
                $preg = preg_match('/([0-9]{2}:[0-9]{2}:[0-9]{2}\s)\[(.*)\]\[(.*)\]\[(.*)\]\[(.*)\]\[(\w.+)\]\s(\w.*)+/', $l, $match);

                if ($preg) {
                    $data[] = [
                        'time' => Yii::$app->formatter->asTime(strtotime($match[1]), 'H:mm'),
                        'ip' => $match[2],
                        'user_id' => $match[3],
                        'session' => $match[4],
                        'type' => Html::tag('span', $match[5], $this->showStatus($match[5])),
                        'cmd' => $match[6],
                        'log' => $match[7]
                    ];
                } else {
                    echo $l;
                    die;
                }


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

            if (strpos(DIRECTORY_SEPARATOR, $folder)) {
                $e = explode(DIRECTORY_SEPARATOR, $folder);
                $this->pageName = CMS::date(strtotime($e[0]), false) . ' / ' . $e[1];
            } else {
                $this->pageName = $folder;
            }

            $this->breadcrumbs[] = [
                'label' => Yii::t('admin/default', 'LOGS'),
                'url' => ['index']
            ];
            $this->breadcrumbs[] = $this->pageName;
            $pathInfo = pathinfo($logPath);
            $data = [];
            if (!isset($pathInfo['extension'])) {
                $folders = FileHelper::findDirectories($logPath, ['recursive' => false]);
                foreach ($folders as $folder) {
                    $data[] = [
                        'sub_folders' => null,
                        'folder' => basename($folder)
                    ];
                }
                $view = 'view_folders';
            } else {
                $files = FileHelper::findFiles($logPath, ['recursive' => false]);
                foreach ($files as $file) {

                    $data[] = [
                        'size' => CMS::fileSize(filesize($file)),
                        'file' => $file
                    ];
                }

                $view = 'view';
            }

            $dataProvider = new ArrayDataProvider([
                'allModels' => $data,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);

            return $this->render($view, [
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

    public function actionDeleteFolder($folder)
    {

        $path = Yii::getAlias(Yii::$app->runtimePath) . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . $folder;
        if (file_exists($path)) {
            FileHelper::removeDirectory($path);
            Yii::$app->session->setFlash("success", Yii::t('app/default', 'FILE_SUCCESS_DELETE'));
        } else {
            Yii::$app->session->setFlash("danger", Yii::t('app/default', 'FILE_NOT_FOUND'));
        }

        return $this->redirect(['index']);
    }

    public function showStatus($text)
    {
        if (preg_match('%error%', $text)) {
            return ['status' => 'error', 'class' => 'badge badge-danger'];
        } elseif (preg_match('%warning%', $text)) {
            return ['status' => 'warning', 'class' => 'badge badge-warning'];
        } elseif (preg_match('%info%', $text)) {
            return ['status' => 'info', 'class' => 'badge badge-info'];
        } elseif (preg_match('%trace%', $text)) {
            return ['status' => 'trace', 'class' => 'badge badge-primary'];
        } else {
            return ['status' => 'undefined', 'class' => ''];
        }
    }
}
