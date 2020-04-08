<?php

namespace panix\mod\admin\controllers\admin;

use panix\mod\admin\models\SettingsLogForm;
use panix\mod\user\models\Session;
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
        $folders = array_reverse($folders);
        foreach ($folders as $folder) {
            $foldersSub = FileHelper::findDirectories($folder, ['recursive' => false]);
            $foldersSubList = [];
            foreach ($foldersSub as $sub_folder) {
                $foldersSubList[] = Html::a(Html::icon('folder-open') . ' ' . basename($sub_folder), ['view', 'folder' => basename(dirname($sub_folder)) . DIRECTORY_SEPARATOR . basename($sub_folder)]);
            }
            $data[] = [
                'sub_folders' => $foldersSubList,
                //'files'=>$filesList,
                'folder_name' => basename($folder)
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
        $file = Yii::$app->request->get('file');
        $view = 'view';
        if ($file) {
            $this->pageName = basename(ucfirst($file), '.log');
            $this->breadcrumbs[] = [
                'label' => Yii::t('admin/default', 'LOGS'),
                'url' => ['index']
            ];
            $this->breadcrumbs[] = [
                'label' => $folder,
                'url' => ['view', 'folder' => $folder]
            ];
            $this->breadcrumbs[] = $this->pageName;

            if (file_exists($logPath . DIRECTORY_SEPARATOR . $file)) {
                $log = file_get_contents($logPath . DIRECTORY_SEPARATOR . $file);
            }
            if (isset($log)) {
                //$log = preg_split("/([0-9]{4}-[0-9]{2}-[0-9]{2})\s/", $log, -1, PREG_SPLIT_NO_EMPTY);
                $log = preg_split("/(\#\>)/", $log, -1, PREG_SPLIT_NO_EMPTY);
                // $pop = array_pop($log);
                $log = array_reverse($log);
                // CMS::dump($log);die;
            } else {
                $log = [];
            }

            $data = [];
            foreach ($log as $l) {

                //$preg = preg_match('/([0-9]{2}:[0-9]{2}:[0-9]{2}\s)\[(.*)\]\[(.*)\]\[(.*)\]\[(.*)\]\[(\w.+)\]\s(\w.*)+/iu', CMS::slashNto($l,''), $match);
                $preg = preg_match('/(.*)\s\[(.*)\]\[(.*)\]\[(.*)\]\[(.*)\]\[(\w.+)\]\s(.+)/iu', CMS::slashNto($l, ''), $match);
                if ($preg) {
                    $stack = $this->showStack($match[7]);
                    $text = explode('Stack trace:', $match[7]);
                    $text = $text[0];

                    $data[] = [
                        'time' => Yii::$app->formatter->asTime(strtotime($match[1]), 'H:mm'),
                        'ip' => CMS::ip($match[2]),
                        'user_id' => ($match[3] !== '-') ? $match[3] : Yii::t('app/default', 'Guest'),
                        'session' => ($match[4] !== '-') ? $match[4] : null,
                        'type' => Html::tag('span', $match[5], $this->showStatus($match[5])),
                        'cmd' => $match[6],
                        'log' => htmlspecialchars($text) . $stack
                    ];
                } else {
                    echo 'error' . PHP_EOL . PHP_EOL;
                    echo $l;
                    die;
                }


            }
            $view = 'view_file';
        } else { //render only folder

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


            $files = FileHelper::findFiles($logPath, ['recursive' => false]);
            foreach ($files as $file) {
                $data[] = [
                    'size' => CMS::fileSize(filesize($file)),
                    'file' => $file
                ];
            }


            if (!isset($pathInfo['extension'])) {
                $folders = FileHelper::findDirectories($logPath, ['recursive' => false]);
                if ($folders) {
                    foreach ($folders as $dir) {
                        $data[] = [
                            'sub_folders' => null,
                            'folder' => Html::icon('folder-open') . ' ' . Html::a(basename($dir), ['view', 'folder' => $folder . DIRECTORY_SEPARATOR . basename($dir)])
                        ];
                    }
                    $view = 'view_folders';
                }
            }
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

    public function showStack($text)
    {
        $text = explode('Stack trace:', $text);
        $content = @$text[1];
        $html = '';
        if (!empty($content)) {

            $log = preg_split("/(\#\d+\s)/", $content, -1, PREG_SPLIT_NO_EMPTY);


           // CMS::dump($log);
           // die;
            $hash = CMS::hash($content);
            $html .= '<div><button class="btn btn-sm btn-outline-secondary" type="button" data-toggle="collapse" data-target="#collapse-' . $hash . '" aria-expanded="false">Stack</button>';
            $html .= '<div class="collapse" id="collapse-' . $hash . '">';
            foreach ($log as $key=>$l) {
                $html.= '<div><strong>#'.$key.'>:</strong> ' .Html::encode($l).'</div>';
            }


            $html .= '</div></div>';
        }
        return $html;

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
            return ['class' => 'badge badge-danger'];
        } elseif (preg_match('%warning%', $text)) {
            return ['class' => 'badge badge-warning'];
        } elseif (preg_match('%info%', $text)) {
            return ['class' => 'badge badge-info'];
        } elseif (preg_match('%trace%', $text)) {
            return ['class' => 'badge badge-primary'];
        } else {
            return ['status' => 'undefined', 'class' => ''];
        }
    }
    public function actionSettings()
    {
        $this->pageName = Yii::t('app/default', 'SETTINGS');
        $this->breadcrumbs = [
            [
                'label' => $this->module->info['label'],
                'url' => $this->module->info['url'],
            ],
            [
                'label' => Yii::t('admin/default', 'LOGS'),
                'url' => ['index'],
            ],
            $this->pageName
        ];

        $model = new SettingsLogForm();

        //Yii::$app->request->post()
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                Yii::$app->session->setFlash("success", Yii::t('app/default', 'SUCCESS_UPDATE'));
            }
            return $this->refresh();
        }
        return $this->render('settings', [
            'model' => $model
        ]);
    }

    public function getAddonsMenu()
    {
        return [
            [
                'label' => Yii::t('app/default', 'SETTINGS'),
                'url' => ['/admin/app/logs/settings'],
                'visible' => true,
            ],
        ];
    }

}
