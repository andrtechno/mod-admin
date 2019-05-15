<?php

namespace panix\mod\admin\controllers\admin;

use Yii;
use yii\helpers\Html;
use yii\data\ArrayDataProvider;
use panix\engine\controllers\AdminController;
use panix\mod\admin\models\SettingsDatabaseForm;
use panix\engine\CMS;

class DatabaseController extends AdminController
{

    public $icon = 'database';

    public function actionIndex()
    {
        $db = Yii::$app->db;

        $this->enableCsrfValidation = false;
        $model = new SettingsDatabaseForm();
        $this->pageName = Yii::t('admin/default', 'DATABASE');
        $this->breadcrumbs[] = $this->pageName;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                if ($model->backup) {
                    $db->export();
                }
            }
        }


        $fdir = opendir(Yii::getAlias($db->backupPath));
        $data = [];

        while ($file = readdir($fdir)) {

            if ($file != '.' & $file != '..' & $file != '.htaccess' & $file != '.gitignore' & $file != 'index.html') {
                $data[] = [
                    'filename' => $file,
                    'filesize' => CMS::fileSize(filesize(Yii::getAlias($db->backupPath) . DIRECTORY_SEPARATOR . $file)),
                    'url' => Html::a('<i class="icon-delete"></i>', ['/admin/app/database/delete', 'file' => $file], ['class' => 'btn btn-sm btn-danger'])
                ];
            }
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
            ],
        ]);


        $type = Yii::$app->request->post('type');

        $providerRepair = null;
        $providerOptimize = null;
        $totaltotal = 0;
        $totalfree = 0;
        if ($type == 'optimize') {
            // $db = Yii::$app->db->schema->tableNames;


            $dataOptimize = [];
            $result = Yii::$app->db->createCommand('SHOW TABLE STATUS FROM `' . CMS::tableName() . '`')->queryAll();
            foreach ($result as $row) {

                $total = $row['Data_length'] + $row['Index_length'];


                $totaltotal += $total;
                $free = ($row['Data_free']) ? $row['Data_free'] : 0;
                $totalfree += $free;
                if ($row['Engine'] == 'MyISAM') {

                    $otitle = (!$free) ? '<span class="badge badge-success">Не нуждается</span>' : '<span class="badge badge-danger">Оптимизирована</span>';
                    $result = Yii::$app->db->createCommand("OPTIMIZE TABLE " . $row['Name'] . "")->query();
                } else {

                    $otitle = '<span class="badge badge-danger">' . $row['Engine'] . ' (not support)</span>';
                }


                $dataOptimize[] = array(
                    'status' => $otitle,
                    'table' => str_replace(Yii::$app->db->tablePrefix, '', $row['Name']),
                    'total_size' => CMS::fileSize($total),
                    'free' => CMS::fileSize($free)
                );
            }
            $providerOptimize = new ArrayDataProvider([
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
                $otitle = (!$rresult) ? '<span class="badge badge-danger">' . Yii::t('app', 'ERROR') . '</span>' : '<span class="badge badge-success">OK</span>';
                $dataRepair[] = array(
                    'status' => $otitle,
                    'table' => str_replace(Yii::$app->db->tablePrefix, '', $row['Name']),
                    'total_size' => CMS::fileSize($total)
                );
            }
            $providerRepair = new ArrayDataProvider([
                'allModels' => $dataRepair,
                'pagination' => false,
            ]);
        }


        $data_db = new ArrayDataProvider([
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

    public function actionDelete($file)
    {
        if (isset($file)) {
            $filePath = Yii::getAlias(Yii::$app->db->backupPath) . DIRECTORY_SEPARATOR . $file;
            if (file_exists($filePath)) {
                @unlink($filePath);
                Yii::$app->session->setFlash("success", Yii::t('app', 'FILE_SUCCESS_DELETE'));
            } else {
                Yii::$app->session->setFlash("danger", Yii::t('app', 'ERR_FILE_NOT_FOUND'));
            }
        }
        if (!Yii::$app->request->isPjax || !Yii::$app->request->isAjax) {
            return $this->redirect(['/admin/app/database']);
        }
    }

}
