<?php

namespace panix\mod\admin\controllers\admin;

use Yii;
use panix\mod\admin\models\Block;
use panix\mod\admin\models\search\BlockSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * DefaultController implements the CRUD actions for Block model.
 */
class BlocksController extends \panix\engine\controllers\AdminController
{

    /**
     * @inheritdoc
     */
    public function behaviors2()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'switch' => [
                'class' => 'panix\engine\actions\SwitchAction',
                'modelClass' => Block::class,
            ],
            'delete' => [
                'class' => 'panix\engine\actions\DeleteAction',
                'modelClass' => Block::class,
            ],
        ];
    }

    /**
     * Lists all Block models.
     * @return mixed
     */
    public function actionIndex()
    {

        $this->pageName = Yii::t('admin/default', 'BLOCKS');
        if (Yii::$app->user->can("/{$this->module->id}/{$this->id}/*") || Yii::$app->user->can("/{$this->module->id}/{$this->id}/create")) {
            $this->buttons = [
                [
                    'icon' => 'add',
                    'label' => Yii::t('app/default', 'CREATE'),
                    'url' => ['create'],
                    'options' => ['class' => 'btn btn-success']
                ]
            ];
        }

        $this->view->params['breadcrumbs'][] = $this->pageName;


        $searchModel = new BlockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new Block model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->actionUpdate(false);
    }


    public function actionUpdate($id = false)
    {
        $model = Block::findModel($id);


        $isNew = $model->isNewRecord;


        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('admin/default','BLOCKS'),
            'url' => ['index']
        ];
        $this->pageName = Yii::t('admin/default', 'MODULE_NAME');
        $this->view->params['breadcrumbs'][] = ($isNew)?'Add':'update';


        //$model->setScenario("admin");
        $post = Yii::$app->request->post();
        if ($model->load($post)) {

            if ($model->validate()) {
                $model->save();
                $json['success'] = false;
                if (Yii::$app->request->isAjax && Yii::$app->request->post('ajax')) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    $json['success'] = true;
                    $json['message'] = Yii::t('app/default', 'SUCCESS_UPDATE');
                    return $json;
                }

                return $this->redirectPage($isNew, $post);
            } else {
                // print_r($model->getErrors());
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }


}
