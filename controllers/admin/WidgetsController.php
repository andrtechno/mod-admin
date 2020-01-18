<?php

namespace panix\mod\admin\controllers\admin;

use Yii;
use panix\engine\Html;
use panix\engine\blocks_settings\WidgetSystemManager;
use panix\engine\controllers\AdminController;
use yii\helpers\FileHelper;

class WidgetsController extends AdminController
{

    public $icon = 'icon-chip';

    const CHACHEID = 'widgets_cache';

    public function actionIndex()
    {

        $this->pageName = Yii::t('admin/default', 'WIDGETS');
        $this->breadcrumbs = [$this->pageName];


        // $result = Yii::$app->cache->get(self::CHACHEID);
        // if ($result === false) {
        $result = [];


        $manager = new WidgetSystemManager;

        foreach (Yii::$app->getModules() as $mod => $module) {
            $reflect = new \ReflectionClass($module);
            $path = dirname($reflect->getFileName()) . DIRECTORY_SEPARATOR . 'blocks';
            if (file_exists($path)) {
                $namespace = $reflect->getNamespaceName();
                $modulesfile = array_filter(glob($path . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR . '*'), 'is_file');

                foreach ($modulesfile as $obj) {
                    if (file_exists(dirname($obj))) {
                        $fileName = basename($obj, '.php');
                        $fileDir = basename(dirname($obj));


                        $classNamespace = $namespace . '\\blocks\\' . $fileDir . '\\' . $fileName;
                        $class = new $classNamespace;
                        if ($class instanceof \panix\engine\data\Widget) {
                            //  echo 'pok';


                            $edit = false;
                            //if (file_exists(dirname($obj) . DIRECTORY_SEPARATOR . 'form')) {
                            $system = $manager->getClass($classNamespace);
                            if ($system) {
                                $edit = true;
                            }
                            //}


                            $result[] = [
                                'title' => $class->getTitle(),
                                'alias' => $classNamespace,
                                'category' => 'module',
                                'edit' => ($edit) ? Html::a(Html::icon('edit'), ['update', 'alias' => $classNamespace], ['class' => 'btn btn-sm btn-secondary']) : Yii::$app->formatter->asText(null)
                            ];
                        }
                    }
                }
            }

        }
        //    Yii::$app->cache->set(self::CHACHEID, $result, 0); //3600 * 12
        // }


        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $result,
            'pagination' => [
                'pageSize' => 10,
            ],
            // 'sort' => $sort,
        ]);


        /* $data_db = new CArrayDataProvider($result, array(
          'keyField' => false,
          'sort' => array(
          'attributes' => array('alias', 'category', 'title'),
          'defaultOrder' => array('alias' => false),
          ),
          'pagination' => array(
          'pageSize' => Yii::$app->settings->get('app', 'pagenum'),
          ),
          )
          ); */
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionUpdate($alias)
    {
        if (empty($alias)) {
            return $this->redirect(['index']);
        }
        $this->pageName = Yii::t('admin/default', 'WIDGETS_UPDATE');
        $this->breadcrumbs = [
            [
                'label' => Yii::t('admin/default', 'WIDGETS'),
                'url' => ['index']
            ],
            $this->pageName
        ];

        $manager = new WidgetSystemManager;
        //$alias = str_replace('.','\\',$alias);

        $system = $manager->getSystemClass($alias);

        if (!$system) {
            Yii::$app->session->setFlash('error', 'Виджет не использует конфигурации');
            die('error');
            //   return $this->redirect(['index']);
        }


        // if (Yii::$app->request->isPost) {
        if ($system) {
            //die(basename(get_class($system)));
            //$system->attributes = $_POST[basename(get_class($system))];
            $post = Yii::$app->request->post();
            if ($post) {

                if ($system->load($post) && $system->validate()) {

                    $system->saveSettings($alias, $post);
                    Yii::$app->session->setFlash('success', Yii::t('app/default', 'SUCCESS_UPDATE'));
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app/default', 'ERROR_UPDATE'));
                }
            }
        }
        return $this->render('update', [
            'form' => $system->getConfigurationFormHtml($alias),
            //  'title'=>Yii::t(str_replace('Form','',get_class($system)).'.default','TITLE')
        ]);
    }

}
