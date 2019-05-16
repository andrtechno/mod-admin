<?php

namespace panix\mod\admin\controllers\admin;

use panix\mod\admin\components\YandexTranslate;
use Yii;
use panix\engine\controllers\AdminController;
use panix\mod\admin\models\Languages;
use panix\mod\admin\models\search\LanguagesSearch;
use yii\base\Exception;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\Response;

class LanguagesController extends AdminController
{
    private $sources_locale; //SourceLanguage default is Class languageManager
    private $target_locale; //TargetLanguage

    public function actions()
    {
        return [
            'switch' => [
                'class' => 'panix\engine\actions\SwitchAction',
                'modelClass' => LanguagesSearch::class,
            ],
        ];
    }

    public function init()
    {
        parent::init();
        $this->sources_locale = Yii::$app->languageManager->default->code;
    }

    public function actionTester()
    {
        $this->generateMessagesModules('fr');
    }

    public function actionIndex()
    {
        $this->pageName = Yii::t('admin/default', 'LANGUAGES');
        $this->buttons = [
            [
                'icon' => 'icon-add',
                'label' => Yii::t('admin/default', 'CREATE_LANG'),
                'url' => ['create'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        $this->breadcrumbs = [
            $this->pageName
        ];

        $searchModel = new LanguagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionUpdate($id = false)
    {


        if ($id === true) {
            $model = new Languages;
        } else {
            $model = Languages::findModel($id);
        }


        $this->pageName = Yii::t('admin/default', 'LANGUAGES');
        $this->buttons = [
            [
                'icon' => 'icon-add',
                'label' => Yii::t('admin/default', 'CREATE_LANG'),
                'url' => ['create'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        $this->breadcrumbs[] = [
            'label' => $this->pageName,
            'url' => ['index']
        ];

        $this->breadcrumbs[] = Yii::t('app', 'UPDATE');


        //$model->setScenario("admin");
        $post = Yii::$app->request->post();


        if ($model->load($post) && $model->validate()) {
            $model->save();

            Yii::$app->session->addFlash('success', \Yii::t('app', 'SUCCESS_CREATE'));
            if ($model->isNewRecord) {
                return Yii::$app->getResponse()->redirect(['/app/languages']);
            } else {
                return Yii::$app->getResponse()->redirect(['/app/languages/update', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionEditFile($file)
    {


        echo VarDumper::dump(Yii::$app->i18n->translations,10,true);
   // echo file_get_contents(Yii::getAlias($file));
        print_r($file);die;
    }

    public function actionTranslate()
    {
        $this->pageName = 'Перевод сайта';
        /*$this->breadcrumbs = array(
            Yii::t('app', 'LANGUAGES') => array('admin/languages'),
            $this->pageName
        );*/
        return $this->render('translate', array('lang' => Yii::$app->request->get('lang')));
    }

    public function actionAjaxApplication()
    {
        if (Yii::$app->request->get('lang')) {
            $filename = Yii::$app->request->post('file');
            $fullpath = Yii::$app->request->post('path');
            return $this->generateMessages($filename, $fullpath, Yii::$app->request->get('lang'));
        } else {
            throw new Exception('Error no select language');
        }
    }

    private function generateMessages($file, $path, $locale)
    {
        $this->target_locale = $locale;
        $t = new YandexTranslate;
        $response = [];
        $pathDefault = Yii::getAlias($path) . DIRECTORY_SEPARATOR . $this->sources_locale;
        $newPath = Yii::getAlias($path) . DIRECTORY_SEPARATOR . $this->target_locale;

        if (!file_exists($newPath)) {
            FileHelper::copyDirectory($pathDefault, $newPath, array(
                'only' => ['*.php'],
            ));
        }
        $contentList = require($newPath . DIRECTORY_SEPARATOR . $file);
        $contentListTranslated = array();
        foreach ($contentList as $pkey => $val) {
            if (!empty($val)) {

                $response = $t->translatefile([$this->sources_locale, $this->target_locale], $val, true);
                if (!isset($response['hasError'])) {
                    $contentListTranslated[$pkey] = $response['text'][0];
                } else {
                    $contentListTranslated[$pkey] = '';
                }
            } else {
                $contentListTranslated[$pkey] = '';
            }


        }

        if (!isset($response['hasError'])) {

            $this->writeLanguageContent($newPath . DIRECTORY_SEPARATOR . $file, $contentListTranslated);
            $response = [
                'status' => 'success',
                'message' => 'ОК',
            ];

        } else {

            $response = [
                'status' => 'error',
                'message' => $response['message'],
            ];

        }
        $response['test'] = 'dasa';
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $response;
    }

    public function generateMessagesModules($locale)
    {
        $this->target_locale = $locale;
        $modules = Yii::$app->getModules();
        $yandex = new YandexTranslate();
        $num = -1;
        $result = [];
        $spec = [];
        foreach ($modules as $module_id => $module) {
            $reflector = new \ReflectionClass(get_class($module));
            $messagesPath = dirname($reflector->getFileName()) . DIRECTORY_SEPARATOR . 'messages';
            $pathDefault = $messagesPath . DIRECTORY_SEPARATOR . $this->sources_locale;
            if (file_exists($pathDefault)) {
                FileHelper::copyDirectory($pathDefault, $messagesPath . DIRECTORY_SEPARATOR . $this->target_locale, [
                    'only' => ['*.php'],
                    'recursive' => true
                ]);

                if (file_exists($messagesPath . DIRECTORY_SEPARATOR . $this->target_locale)) {
                    $listFiles = FileHelper::findFiles($messagesPath . DIRECTORY_SEPARATOR . $this->target_locale, [
                        'only' => ['*.php'],

                    ]);

                    foreach ($listFiles as $file) {
                        $contentList = include_once($file);

                        foreach ($contentList as $key => $val) {
                            $num++;
                            $spec[$num] = $key;
                        }

                        $response = $yandex->translate([$this->sources_locale, $this->target_locale], $contentList);
                        if (!$response['hasError']) {

                            foreach ($response['text'] as $k => $v) {
                                $result[$spec[$k]] = $v;
                            }
                            $this->writeLanguageContent($file, $result);
                        } else {
                            echo $response['message'];
                        }
                    }
                }
            }
            // die('Finished');
        }
        // die('Complate');
    }


    private function writeLanguageContent($filePath, $content)
    {
        if (!@file_put_contents($filePath, '<?php

/**
 * Message translations. (auto generation translate)
 * @author PIXELION CMS development team <info@pixelion.com.ua>
 * @license https://pixelion.com.ua/license.txt PIXELION CMS License
 * @link https://pixelion.com.ua PIXELION CMS
 * @ignore
 */
return ' . var_export($content, true) . ';')
        ) {
            throw new Exception(Yii::t('app', 'Error write modules setting in {file}...', ['file' => $filePath]));
        }
    }

    public function remove_old_lang_dir($path)
    {
        if (Yii::$app->request->get('lang')) {
            if (file_exists(Yii::getAlias($path))) {
                FileHelper::removeDirectory(Yii::getAlias($path), ['traverseSymlinks' => true]);
            }
        }
    }


    public function getArray($path)
    {
        $files = scandir($path);
        $tree = array();
        foreach ($files as $file) {
            if ($file != "." && $file != "..")
                $tree[$file] = str_replace('.php', '', $file);
        }
        return $tree;
    }


    public function getFindFiles($path)
    {
        if (file_exists(Yii::getAlias($path))) {
            return FileHelper::findFiles(Yii::getAlias($path), [
                'only' => ['*.php'],
            ]);
        } else {
            return false;
        }
    }
}
