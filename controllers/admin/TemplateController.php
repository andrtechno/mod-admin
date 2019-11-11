<?php

namespace panix\mod\admin\controllers\admin;

use panix\engine\assets\codemirror\CodeMirrorPhpAsset;
use panix\engine\FileSystem;
use Yii;
use panix\engine\controllers\AdminController;
use yii\base\Exception;
use yii\web\Response;

/**
 * Class TemplateController
 * @package panix\mod\admin\controllers\admin
 */
class TemplateController extends AdminController
{

    public $icon = 'template';

    public function actionIndex()
    {
        $this->pageName = Yii::t('admin/default', 'TEMPLATE');
        $this->breadcrumbs = [$this->pageName];

        $post = Yii::$app->request->post();
        if ($post) {
            $fs = new FileSystem($post['file'], Yii::getAlias('@web_theme'));
            $fs->write($post['code']);
        }
        return $this->render('index');
    }

    public function actionOperation()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->get('operation')) {


            $fs = new FileSystem();

            $fs->setPath(Yii::getAlias('@web_theme'));
            try {
                $rslt = null;
                switch (Yii::$app->request->get('operation')) {
                    case 'get_node':
                        $node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';

                        $rslt = $fs->lst($node, (isset($_GET['id']) && $_GET['id'] === '#'));
                        break;
                    case "get_content":


                        $node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
                        $rslt = $fs->data($node);
                        if ($rslt['type'] == 'php') {
                            //CodeMirrorPhpAsset::register($this->view);
                        }

                        break;
                    case 'create_node':
                        $node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
                        $rslt = $fs->create($node, isset($_GET['text']) ? $_GET['text'] : '', (!isset($_GET['type']) || $_GET['type'] !== 'file'));
                        break;
                    case 'rename_node':
                        $node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
                        $rslt = $fs->rename($node, isset($_GET['text']) ? $_GET['text'] : '');
                        break;
                    case 'delete_node':
                        $node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
                        $fs->setName($node);
                        $rslt = $fs->delete();
                        //$rslt = $fs->delete($node);
                        break;
                    case 'move_node':
                        $node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
                        $parn = isset($_GET['parent']) && $_GET['parent'] !== '#' ? $_GET['parent'] : '/';
                        $rslt = $fs->move($node, $parn);
                        break;
                    case 'copy_node':
                        $node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
                        $parn = isset($_GET['parent']) && $_GET['parent'] !== '#' ? $_GET['parent'] : '/';
                        $rslt = $fs->copy($node, $parn);
                        break;
                    default:
                        throw new Exception('Unsupported operation: ' . $_GET['operation']);
                        break;
                }

                return $rslt;
            } catch (Exception $e) {
                header($_SERVER["SERVER_PROTOCOL"] . ' 500 Server Error');
                header('Status:  500 Server Error');
                return $e->getMessage();
            }

        }
    }

}
