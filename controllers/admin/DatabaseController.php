<?php

namespace panix\mod\admin\controllers\admin;

use Yii;
use panix\engine\controllers\AdminController;
use panix\mod\admin\models\SettingsDatabaseForm;
use panix\engine\CMS;
use yii\helpers\Html;

class DatabaseController extends AdminController {


    public $icon = 'database';

    public function actionIndex() {
        $db = Yii::$app->db;


        $model = new SettingsDatabaseForm();
        $this->pageName = Yii::t('admin/default', 'DATABASE');
        $this->breadcrumbs = [
            [
                'label' => Yii::t('admin/default', 'DATABASE'),
                'url' => [],
            ],
            $this->pageName
        ];

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
                if ($model->backup) {
                    $db->export();
                }
        }


        $fdir = opendir(Yii::getAlias($db->backupPath));
        $data = array();

        while ($file = readdir($fdir)) {

            if ($file != '.' & $file != '..' & $file != '.htaccess' & $file != '.gitignore' & $file != 'index.html') {
                $data[] = array(
                    'filename' => $file,
                    'filesize' => CMS::files_size(filesize(Yii::getAlias($db->backupPath) . DIRECTORY_SEPARATOR . $file)),
                    'url' => Html::a('<i class="icon-delete"></i>', array('/admin/app/database/delete', 'file' => $file), array('class' => 'btn btn-xs btn-danger'))
                );
            }
            //   $this->_filesizes += filesize(Yii::getPathOfAlias($database->backupPath).DS.$file);
        }
        closedir($fdir);



        $sort = new \yii\data\Sort([
            'attributes' => [
                'filesize',
                'filename' => [
                    'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                    'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Filename',
                ],
            // or any other attribute
            ],
        ]);





        $type = Yii::$app->request->post('type');




        $totaltotal = 0;
        if ($type == 'optimize') {
            // $db = Yii::$app->db->schema->tableNames;

            $totalfree = 0;
            $dataOptimize = [];
            $result = Yii::$app->db->createCommand('SHOW TABLE STATUS FROM `' . CMS::tableName() . '`')->queryAll();
            foreach ($result as $row) {

                $total = $row['Data_length'] + $row['Index_length'];



                $totaltotal += $total;
                $free = ($row['Data_free']) ? $row['Data_free'] : 0;
                $totalfree += $free;
                if ($row['Engine'] == 'MyISAM') {

                    $otitle = (!$free) ? '<span class="label label-success">Не нуждается</span>' : '<span class="label label-danger">Оптимизирована</span>';
                    $result = Yii::$app->db->createCommand("OPTIMIZE TABLE " . $row['Name'] . "")->query();
                } else {

                    $otitle = '<span class="label label-warning">' . $row['Engine'] . ' (not support)</span>';
                }


                $dataOptimize[] = array(
                    'status' => $otitle,
                    'table' => str_replace(Yii::$app->db->tablePrefix, '', $row['Name']),
                    'total_size' => CMS::files_size($total),
                    'free' => CMS::files_size($free)
                );
            }
            $providerOptimize = new \yii\data\ArrayDataProvider([
                'allModels' => $dataOptimize,
                'pagination' => false,
            ]);
        } elseif ($type == 'repair') {
            $dataRepair = [];
            $totaltotal = 0;
            $result = Yii::$app->db->createCommand('SHOW TABLE STATUS FROM `' . CMS::tableName() . '`')->queryAll();
            foreach ($result as $row) {
                $total = $row['Data_length'] + $row['Index_length'];
                $totaltotal += $total;

                $rresult = Yii::$app->db->createCommand("REPAIR TABLE " . $row['Name'] . "")->query();
                $otitle = (!$rresult) ? '<span class="label label-danger">' . Yii::t('app', 'ERROR') . '</span>' : '<span class="label label-success">OK</span>';
                $dataRepair[] = array(
                    'status' => $otitle,
                    'table' => str_replace(Yii::$app->db->tablePrefix, '', $row['Name']),
                    'total_size' => CMS::files_size($total)
                );
            }
            $providerRepair = new \yii\data\ArrayDataProvider([
                'allModels' => $dataRepair,
                'pagination' => false,
            ]);
        }














        $data_db = new \yii\data\ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => $sort,
        ]);

        return $this->render('index', [
                    'model' => $model,
                    'data_db' => $data_db,
                    'db' => $db,
                    'providerRepair' => $providerRepair,
                    'providerOptimize' => $providerOptimize,
                    'totaltotal' => $totaltotal,
                    'totalfree' => $totalfree
        ]);
    }

    public function actionDelete($file) {
die;
        if (isset($file)) {
            $filePath = Yii::getAlias(Yii::$app->db->backupPath) . DIRECTORY_SEPARATOR . $file;
            if (file_exists($filePath)) {
                @unlink($filePath);
                //Yii::$app->session->addFlash("success", Yii::t('app', 'FILE_SUCCESS_DELETE'));
                //$this->setFlashMessage(Yii::t('app', 'FILE_SUCCESS_DELETE'));
                if(!Yii::$app->request->isPjax || !Yii::$app->request->isAjax){
                    //$this->redirect(['admin/database']);
                }
            } else {
                //Yii::$app->session->addFlash("danger", Yii::t('app', 'ERR_FILE_NOT_FOUND'));
               // $this->setFlashMessage(Yii::t('app', 'ERR_FILE_NOT_FOUND'));
            }
        }
    }

}
