<?php

namespace panix\mod\admin\controllers\admin;

use Yii;
use yii\helpers\FileHelper;
use panix\engine\Html;
use panix\engine\blocks_settings\WidgetSystemManager;

class WidgetsController extends \panix\engine\controllers\AdminController {

    public $icon = 'icon-chip';

    const CHACHEID = 'widgets_cache';

    public function actionIndex() {

        $this->pageName = Yii::t('admin/default', 'WIDGETS');
        $this->breadcrumbs = array($this->pageName);


        $result = Yii::$app->cache->get(self::CHACHEID);
        if ($result === false) {
            $result = array();

            /* $extPath = Yii::getAlias("@admin/blocks");
              $files = FileHelper::findFiles($extPath, array(
              'fileTypes' => array('php'),
              'caseSensitive' => true,
              'recursive' => false,
              ));
              echo \yii\helpers\VarDumper::dump($files,10, true);
              die; */



            //Yii::import('app.blocks_settings.*');
            $manager = new WidgetSystemManager;
            /* foreach ($files as $k => $obj) {

              $obj = explode(DIRECTORY_SEPARATOR, $obj);


              $className = str_replace('.php', '', $obj[1]);
              $classDir = $obj[0];

              if (file_exists(Yii::getPathOfAlias("ext.blocks.{$classDir}") . DS . $obj[1])) {
              Yii::import("ext.blocks.{$classDir}.{$className}");
              if (new $className instanceof BlockWidget) {
              $class = new $className;

              Yii::import('app.blocks_settings.*');
              $manager = new WidgetSystemManager;

              $system = $manager->getClass("ext.blocks.{$classDir}", $className);

              if (!$system) {
              $edit = false;
              } else {
              $edit = true;
              }


              $result[] = array(
              'title' => $class->getTitle(),
              'alias' => "ext.blocks.{$classDir}.{$className}",
              'category' => 'ext',
              'edit' => ($edit) ? Html::link('<i class="icon-edit"></i>', array('/admin/app/widgets/update', 'alias' => "ext.blocks.{$classDir}.{$className}"), array('class' => 'btn btn-default')) : ''
              );
              }
              }
              } */




            /* start modules widget parse */
            foreach (Yii::$app->getModules() as $mod => $module) {
                $reflect = new \ReflectionClass($module);
                // print_r(dirname($reflect->name));
                //  echo dirname($reflect->getFileName());
                $path = dirname($reflect->getFileName()) . DIRECTORY_SEPARATOR . 'blocks';
                if (file_exists($path)) {

                    $namespace = $reflect->getNamespaceName();

                    $modulesfile = array_filter(glob($path . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR . '*'), 'is_file');
                    foreach ($modulesfile as $obj) {
                        if (file_exists(dirname($obj))) {
                            $fileName = basename($obj, '.php');
                            $fileDir = basename(dirname($obj));

                            //   print_r(dirname($obj));die;

                            $classNamespace = $namespace . '\\blocks\\' . $fileDir . '\\' . $fileName;
                            $class = new $classNamespace;
                            if ($class instanceof \panix\engine\data\Widget) {
                                //  echo 'pok';
                            }

                            $edit = false;
                            //if (file_exists(dirname($obj) . DIRECTORY_SEPARATOR . 'form')) {
                            $system = $manager->getClass($classNamespace);
                            if ($system) {
                                $edit = true;
                            }
                            //}


                            $result[] = array(
                                'title' => $class->getTitle() . $fileName,
                                'alias' => $classNamespace,
                                'category' => 'module',
                                'edit' => ($edit) ? Html::a('<i class="icon-edit"></i>', ['/admin/app/widgets/update', 'alias' => $classNamespace], ['class' => 'btn btn-default']) : ''
                            );
                        }
                    }
                }
                //
                /* if (file_exists(Yii::getPathOfAlias("mod.{$mod}.blocks"))) {
                  $modulesfile = CFileHelper::findFiles(Yii::getPathOfAlias("mod.{$mod}.blocks"), array(
                  'fileTypes' => array('php'),
                  'level' => 1,
                  'absolutePaths' => false
                  ));
                  } */

                /* foreach ($modulesfile as $obj) {

                  $obj = explode(DIRECTORY_SEPARATOR, $obj);


                  $className = str_replace('.php', '', $obj[1]);
                  $classDir = $obj[0];
                  if (file_exists(Yii::getPathOfAlias("mod.{$mod}.blocks"))) {
                  if (file_exists(Yii::getPathOfAlias("mod.{$mod}.blocks.{$classDir}") . DS . $obj[1])) {
                  Yii::import("mod.{$mod}.blocks.{$classDir}.{$className}");
                  if (new $className instanceof BlockWidget) {
                  $class = new $className;



                  $system = $manager->getClass("mod.{$mod}.blocks.{$classDir}", $className);

                  if (!$system) {
                  $edit = false;
                  } else {
                  $edit = true;
                  }


                  $result[] = array(
                  'title' => $class->getTitle(),
                  'alias' => "mod.{$mod}.blocks.{$classDir}.{$className}",
                  'category' => 'module',
                  'edit' => ($edit) ? Html::link('<i class="icon-edit"></i>', array('/admin/app/widgets/update', 'alias' => "mod.{$mod}.blocks.{$classDir}.{$className}"), array('class' => 'btn btn-default')) : ''
                  );
                  }
                  }
                  }
                  } */
            }
            Yii::$app->cache->set(self::CHACHEID, $result, 0); //3600 * 12
        }


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

    public function actionUpdate($alias) {

        if (empty($alias)) {
            return $this->redirect(['index']);
        }


        $this->pageName = Yii::t('admin/default', 'WIDGETS_UPDATE');
        $this->breadcrumbs = [
            [
                'label'=>Yii::t('admin/default', 'WIDGETS'),
                'url'=>['/admin/app/widgets']
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
                    Yii::$app->session->setFlash('success', Yii::t('app', 'SUCCESS_UPDATE'));
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('app', 'ERROR_UPDATE'));
                }
            }
        }
        return $this->render('update', array(
                    'form' => $system->getConfigurationFormHtml($alias),
                        //  'title'=>Yii::t(str_replace('Form','',get_class($system)).'.default','TITLE')
        ));
    }

}
