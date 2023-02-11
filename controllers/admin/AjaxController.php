<?php

namespace panix\mod\admin\controllers\admin;

use Yii;
use yii\base\Exception;
use yii\helpers\Json;
use yii\web\Response;
use panix\engine\controllers\AdminController;

class AjaxController extends AdminController
{

    public function actionSetHashstate()
    {
        Yii::$app->user->setState('redirectTabsHash', $_POST['hash']);
    }

    public function actionSwitchTheme()
    {
        //Yii::$app->session->set('dashboard_theme', (Yii::$app->request->post('theme')=='light')?'dark':'light');
        Yii::$app->session->set('dashboard_theme', Yii::$app->request->post('theme'));
        return $this->asJson(['success'=>true]);
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
        /** @var \panix\engine\components\geoip\GeoIP $geoIp */
        $geoIp = Yii::$app->geoip->ip($ip);
        return $this->render('_geo', [
            'ip' => $ip,
            'geoIp' => $geoIp,
        ]);
    }


    /**
     * Экшен для CEditableColumn
     * @throws Exception
     */
    public function ___actionUpdateGridRow()
    {
        if (Yii::$app->request->isAjax) {
            $response = array();
            $modelClass = $_POST['modelClass'];
            $id = intval($_POST['pk']);
            $field = $_POST['field'];
            $q = $_POST['q'];
            $model = $modelClass::model()->findByPk($id);
            $model->$field = $q;
            if ($model->validate()) {
                $model->save(false, false);
                $response['message'] = Yii::t('app/default', 'SUCCESS_UPDATE');
                $response['value'] = $q;
            } else {
                $response['message'] = 'error validate';
            }
            echo Json::encode($response);
            Yii::$app->end();
        } else {
            throw new Exception(403, 'no ajax');
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
                'message' => Yii::t('app/default', 'FILE_SUCCESS_DELETE')
            ];
        } else {
            return [
                'response' => 'error',
                'message' => Yii::t('app/default', 'FILE_NOT_FOUND')
            ];
        }
    }

    public function actionCheckSlug()
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

    public function actionAutoComplete()
    {
        /** @var yii\db\ActiveRecord $model */
        $model = $_GET['modelClass'];
        $string = $_GET['string'];
        $field = $_GET['field'];
        $query = $model::find();
        $query->where('LIKE', [$field => $string]);
        $results = $query->all();

        $json = [];
        foreach ($results as $item) {
            $json[] = [
                'label' => $item->title,
                'value' => $item->title,
                'test' => 'test.param'
            ];
        }
        return $this->asJson($json);
    }


}
