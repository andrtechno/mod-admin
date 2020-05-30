<?php

namespace panix\mod\admin\controllers\admin;

use panix\engine\CMS;
use panix\engine\Html;
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
        if (Yii::$app->user->can("/{$this->module->id}/{$this->id}/*") || Yii::$app->user->can("/{$this->module->id}/{$this->id}/create")) {
            $this->buttons = [
                [
                    'icon' => 'add',
                    'label' => Yii::t('admin/default', 'CREATE_LANG'),
                    'url' => ['create'],
                    'options' => ['class' => 'btn btn-success']
                ]
            ];
        }
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
        $model = Languages::findModel($id);
        $isNew = $model->isNewRecord;
        $this->pageName = Yii::t('admin/default', 'LANGUAGES');

        $this->breadcrumbs[] = [
            'label' => $this->pageName,
            'url' => ['index']
        ];

        $this->breadcrumbs[] = Yii::t('app/default', 'UPDATE');


        //$model->setScenario("admin");
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $model->save();
            return $this->redirectPage($isNew, $post);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param string $path "@user/messages"
     * @param string $file Example "default.php"
     * @return string
     */
    public function actionEditFile($path,$file)
    {
        $path = Yii::getAlias($path);
        $absolutePath=$path.'/ru/'.$file;
        $newAbsolutePath= $path.'/en/'.$file;
        $translateApi = new YandexTranslate;
        $response=[];
        $result=[];
        //echo VarDumper::dump(Yii::$app->i18n->translations,10,true);die;
        if (file_exists($absolutePath)) {
            $contentList = require_once($absolutePath);


            $response = $translateApi->translatefile(['ru', 'en'], $contentList, true);
            $i=0;
            foreach ($contentList as $key => $value) {
                $result[$key]=$response['text'][$i];
                $i++;
                //$response[] = $translateApi->translatefile(['ru', 'en'], $value, true);
            }

            FileHelper::copyDirectory($path.'/ru', $path.'/en', [
                'only' => ['*.php'],
                'recursive' => true
            ]);
            $this->writeLanguageContent($newAbsolutePath, $result);
        }


        $r = [];
        $i18n = Yii::$app->i18n;
       // CMS::dump($i18n->translations);die;
        foreach ($i18n->translations as $key => $translation) {
            if (isset($i18n->translations[$key])) {
                $basePath = (isset($i18n->translations[$key]->basePath)) ? $i18n->translations[$key]->basePath : $i18n->translations[$key]['basePath'];
                $r['path'][] = $basePath;
                $r['s'][] = $key;
            }
            //  echo $key.'<br>   ';
        }
        // echo file_get_contents(Yii::getAlias($file));
        return $this->render('edit-file', [
            'r' => $r
        ]);
    }

    public function actionTranslate()
    {
        $this->pageName = 'Перевод сайта';
        /*$this->breadcrumbs = array(
            Yii::t('app/default', 'LANGUAGES') => array('admin/languages'),
            $this->pageName
        );*/
        $this->breadcrumbs[] = $this->pageName;
        return $this->render('translate', ['lang' => Yii::$app->request->get('lang')]);
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
            FileHelper::copyDirectory($pathDefault, $newPath, [
                'only' => ['*.php'],
            ]);
        }
        $contentList = require($newPath . DIRECTORY_SEPARATOR . $file);
        $contentListTranslated = [];
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
        $result['success']=false;
        if (!isset($response['hasError'])) {
            $this->writeLanguageContent($newPath . DIRECTORY_SEPARATOR . $file, $contentListTranslated);
            $result['success'] = true;
            $result['message'] = 'ОК';
        } else {
            $result['message'] = $response['message'];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
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
            throw new Exception(Yii::t('app/default', 'Error write modules setting in {file}...', ['file' => $filePath]));
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


    public function getAddonsMenu2()
    {
        return [
            [
                'label' => Yii::t('app/default', 'SETTINGS'),
                'url' => ['/admin/seo/settings'],
                'icon' => Html::icon('settings'),
            ],
            [
                'label' => Yii::t('seo/default', 'REDIRECTS'),
                'url' => ['/admin/seo/redirects'],
                'icon' => Html::icon('refresh'),
            ],
        ];
    }


    public function getAllFiles(){
        $i18n = Yii::$app->i18n;
        $result=[];
        foreach ($i18n->translations as $key => $translation) {
            if (isset($translation->basePath) && isset($translation->fileMap)) {
                if($translation->fileMap){
                    $result[$translation->basePath] = $translation->fileMap;
                }
            }
        }
        return $result;
    }


    public function actionCreate()
    {
        return $this->actionUpdate(false);
    }
}
