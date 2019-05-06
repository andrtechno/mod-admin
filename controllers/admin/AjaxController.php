<?php

namespace panix\mod\admin\controllers\admin;


use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use panix\engine\CMS;
use yii\web\Response;


class AjaxController extends \panix\engine\controllers\AdminController
{

    public function actionSetHashstate()
    {
        Yii::$app->user->setState('redirectTabsHash', $_POST['hash']);
    }


    public function beforeAction($action)
    {
        if ($action->id === 'viber') {
            Yii::$app->controller->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }


    public function actionGeo($ip)
    {
        // die($ip);
        $city = CMS::getCityNameByIp($ip);
        $this->render('_geo', array(
            'city' => $city,
            'ip' => $ip
        ));
    }

    public function actionCounters()
    {
        Yii::import('mod.cart.models.Order');
        echo Json::encode(array(
            // 'comments' => (int) Comment::model()->waiting()->count(),
            //'orders' => Yii::app()->getModule('cart')->countOrder,
        ));
    }

    /**
     * Экшен для CEditableColumn
     * @throws HttpException
     */
    public function actionUpdateGridRow()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $response = array();
            $modelClass = $_POST['modelClass'];
            $id = intval($_POST['pk']);
            $field = $_POST['field'];
            $q = $_POST['q'];
            $model = $modelClass::model()->findByPk($id);
            $model->$field = $q;
            if ($model->validate()) {
                $model->save(false, false);
                $response['message'] = Yii::t('app', 'SUCCESS_UPDATE');
                $response['value'] = $q;
            } else {
                $response['message'] = 'error validate';
            }
            echo Json::encode($response);
            Yii::$app->end();
        } else {
            throw new HttpException(403, 'no ajax');
        }
    }

    public function actionDeleteFile()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $dir = $_POST['aliasDir'];
        $filename = $_POST['filename'];
        $model = $_POST['modelClass'];
        $record_id = $_POST['id'];
        $attr = $_POST['attribute'];
        $path = Yii::getPathOfAlias($dir);
        if (file_exists($path . DIRECTORY_SEPARATOR . $filename)) {
            unlink($path . DIRECTORY_SEPARATOR . $filename);
            $m = $model::model()->findByPk($record_id);
            $m->$attr = '';
            $m->save(false);
            return [
                'response' => 'success',
                'message' => Yii::t('app', 'FILE_SUCCESS_DELETE')
            ];
        } else {
            return [
                'response' => 'error',
                'message' => Yii::t('app', 'ERR_FILE_NOT_FOUND')
            ];
        }
    }

    public function actionCheckalias()
    {
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isAjax) {
            //  $model = $_POST['model'];

            $model = str_replace('/', DIRECTORY_SEPARATOR, $request->post('model'));
            $url = $request->post('alias');
            $pk = $request->post('pk');
            $attribute_slug = $request->post('attribute_slug');
            $message = $request->post('successMessage');

            if (!empty($pk)) {
                $check = $model::find()
                    ->where([$attribute_slug => $url])
                    ->andWhere(['!=', 'id', $pk])
                    ->one();
            } else {
                $check = $model::find()
                    ->where([$attribute_slug => $url])
                    ->one();
            }

            if (isset($check))
                return ['result' => true, 'message' => $message];
            else
                return ['result' => false];
        } else {
            throw new \yii\web\ForbiddenHttpException('denied');
        }
    }

    /*
      public function actionGetStats() {
      $n = Stats::model()->findAll();
      echo Json::encode(array(
      'hits' => (int) count($n),
      'hosts' => (int) count($n),
      ));
      }
     */

    public function actionAutocomplete()
    {
        $model = $_GET['modelClass'];
        $string = $_GET['string'];
        $field = $_GET['field'];
        $criteria = new CDbCriteria;
        $criteria->addSearchCondition('t.' . $field, $string);
        $results = $model::model()->findAll($criteria);

        $json = array();
        foreach ($results as $item) {
            $json[] = array(
                'label' => $item->title,
                'value' => $item->title,
                'test' => 'test.param'
            );
        }
        echo Json::encode($json);
        Yii::$app->end();
    }

    public function actionSendMailForm()
    {
        Yii::import('mod.admin.models.MailForm');
        $model = new MailForm;
        $model->toemail = $_GET['mail'];
        $form = new CMSForm($model->config, $model);
        $this->renderPartial('_sendMailForm', array('form' => $form));
    }

}
