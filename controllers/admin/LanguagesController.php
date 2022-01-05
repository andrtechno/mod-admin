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
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\helpers\Url;
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
            'sortable' => [
                'class' => 'panix\engine\grid\sortable\Action',
                'modelClass' => Languages::class,
            ],
        ];
    }

    public function init()
    {
        parent::init();
        $this->sources_locale = Yii::$app->languageManager->default->code;
    }

    public function actionAjaxOpen()
    {
        $dl = Yii::$app->languageManager->default['code'];
        $current = [];

        $path = Yii::$app->request->get('path');
        $file = Yii::$app->request->get('file');
        $lang = Yii::$app->request->get('lang');
        $type = Yii::$app->request->get('type');
        $filePath = Yii::getAlias($path) . DIRECTORY_SEPARATOR . $lang . DIRECTORY_SEPARATOR . $file;
        // $filePath = Yii::getAlias($path) . DIRECTORY_SEPARATOR . 'en' . DIRECTORY_SEPARATOR . $file;


        //  $ss = Yii::$app->i18n->getMessageSource('admin/*');

        //  CMS::dump(Yii::$app->i18n->translations);
//die;
        if (Yii::$app->request->post('TranslateForm')) {
            $trans = [];
            foreach (Yii::$app->request->post('TranslateForm') as $key => $val) {
                if (is_array($val)) {
                    $param = [];
                    foreach ($val as $key2 => $value) {
                        $param[] = $key2 . '#' . $value;
                    }
                    $trans[stripslashes($key)] = implode('|', $param);
                } else {
                    $trans[stripslashes($key)] = $val;
                }
            }
            $this->writeContent($path, Yii::$app->request->post('lang'), $file, $trans);
        }


        $defaultPath = Yii::getAlias($path) . DIRECTORY_SEPARATOR . $dl . DIRECTORY_SEPARATOR . $file;
        $default = include_once($defaultPath);
        if (file_exists($filePath)) {
            $current = include_once($filePath);
        }
        return $this->render('_ajaxOpen', [
                'return' => ArrayHelper::merge($default, $current),

                //'locale' => $this->_tl,
                'file' => $file,
                'type' => $type
            ]
        );
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
        $this->view->params['breadcrumbs'] = [
            $this->pageName
        ];

        $searchModel = new LanguagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());


        $i18n = Yii::$app->i18n;

        $r = [];

        $data = [];
        foreach ($i18n->translations as $key => $translation) {
            if (isset($i18n->translations[$key])) {
                $basePath = (isset($i18n->translations[$key]->basePath)) ? $i18n->translations[$key]->basePath : $i18n->translations[$key]['basePath'];
                $r['path'][] = $basePath;
                $r['s'][] = $key;
            }
            $data[] = [
                //'filename' => $file,
                //'filesize' => CMS::fileSize(filesize(Yii::getAlias($db->backupPath) . DIRECTORY_SEPARATOR . $file)),
                'key' => $key,
                'url' => Html::a(Html::icon('edit'), ['/admin/app/languages/edit-locale', 'key' => $key], ['class' => 'btn btn-sm btn-secondary'])
            ];
            //  echo $key.'<br>   ';
        }
        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => false,
        ]);


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'provider' => $provider,
            //  'r' => $r
        ]);
    }

    public function actionUpdate($id = false)
    {
        $model = Languages::findModel($id);
        $isNew = $model->isNewRecord;
        $this->pageName = Yii::t('admin/default', 'LANGUAGES');

        $this->view->params['breadcrumbs'][] = [
            'label' => $this->pageName,
            'url' => ['index']
        ];

        $this->view->params['breadcrumbs'][] = Yii::t('app/default', 'UPDATE');


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
    public function actionEditFile($path, $file)
    {
        $path = Yii::getAlias($path);
        $absolutePath = $path . '/ru/' . $file;
        $newAbsolutePath = $path . '/en/' . $file;
        $translateApi = new YandexTranslate;
        $response = [];
        $result = [];
        //echo VarDumper::dump(Yii::$app->i18n->translations,10,true);die;
        if (file_exists($absolutePath)) {
            $contentList = require_once($absolutePath);


            $response = $translateApi->translatefile(['ru', 'en'], $contentList, true);
            $i = 0;
            foreach ($contentList as $key => $value) {
                $result[$key] = $response['text'][$i];
                $i++;
                //$response[] = $translateApi->translatefile(['ru', 'en'], $value, true);
            }

            FileHelper::copyDirectory($path . '/ru', $path . '/en', [
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
        /*$this->view->params['breadcrumbs'] = array(
            Yii::t('app/default', 'LANGUAGES') => array('admin/languages'),
            $this->pageName
        );*/
        $this->view->params['breadcrumbs'][] = $this->pageName;
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
                if ($response['success']) {
                    if (!isset($response['hasError'])) {

                        $contentListTranslated[$pkey] = $response['text'][0];
                    } else {
                        $contentListTranslated[$pkey] = '';
                    }
                }
            } else {
                $contentListTranslated[$pkey] = '';
            }


        }
        $result['success'] = false;
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


    public function getAllFiles()
    {
        $i18n = Yii::$app->i18n;
        $result = [];
        foreach ($i18n->translations as $key => $translation) {
            if (isset($translation->basePath) && isset($translation->fileMap)) {
                if ($translation->fileMap) {
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


    /**
     * @param string $path @path/messages
     * @param string $lang en|fr etc
     * @param string $file default.php
     * @param array $array
     * @return bool
     */
    private function writeContent($path, $lang, $file, $array)
    {
        $date = CMS::date(time());
        $array = VarDumper::export($array);
        $content = <<<EOD
<?php
/**
 * Message translations. (auto generation translate)
 * Date update $date
 * 
 * @author PIXELION CMS development team <info@pixelion.com.ua>
 * @link https://pixelion.com.ua PIXELION CMS
 * @ignore
 */
return $array;

EOD;

        if (FileHelper::createDirectory(Yii::getAlias($path) . DIRECTORY_SEPARATOR . $lang) === false || file_put_contents(Yii::getAlias($path) . DIRECTORY_SEPARATOR . $lang . DIRECTORY_SEPARATOR . $file, $content, LOCK_EX) === false) {
            //echo "Configuration file was NOT created: ''.\n\n";
            return false;
        }
        return true;
    }


    public function actionEditLocale()
    {
        $this->pageName = 'Редактирование локали';
        $i18n = Yii::$app->i18n;
        $data = [];
        $res = [];
        $this->view->params['breadcrumbs'][] = [
            'label' => Yii::t('admin/default', 'LANGUAGES'),
            'url' => ['/admin/app/languages']
        ];

        $languages = Yii::$app->languageManager->getLanguages();
        $fileGet = Yii::$app->request->get('file');
        if (Yii::$app->request->post('form')) {
            foreach (Yii::$app->request->post('form') as $lang => $data) {
                $basePath = $i18n->translations[Yii::$app->request->get('key')]['basePath'];
                //  print_r($basePath);die;
                $this->writeContent($basePath, $lang, $fileGet, $data);
                // CMS::dump($data);die;
                //  echo 'save';

            }
            Yii::$app->session->setFlash('success', 'OK');
            return $this->refresh();
        }

        if (Yii::$app->request->get('key') && $fileGet) {
            $t = $i18n->translations[Yii::$app->request->get('key')];
            $basePath = (is_object($t)) ? $t->basePath : $t['basePath'];
            //$filesMap = $i18n->translations[Yii::$app->request->get('key')];


            $ll = [];
            $content = [];
            $tabs = [];
            foreach ($languages as $lang) {
                $tabs[$lang->code] = ['name' => $lang->name, 'slug' => $lang->slug];
                $path = Yii::getAlias("{$basePath}/{$lang->code}/$fileGet");

                if (file_exists($path)) {
                    $content[$lang->code] = require($path);
                    $ll[$lang->code] = $content[$lang->code];
                } else {
                    $ll[$lang->code] = $content[Yii::$app->language]; //load default language values
                }


            }


            $gg = [];
            $default = $ll[Yii::$app->language];


            foreach ($ll as $k => $l) {
                // if (is_array($l)) {
                // if (is_array($default)) {
                foreach ($default as $kk => $ss) {
                    //  CMS::dump($default);die;
                    $res[$kk][$k] = '';
                    // $res[$key][$k]
                    // $res[$key][$k] = $p;
                }
                //}
                // if (is_array($l)) {

                foreach ($l as $key => $p) {
                    if (isset($res[$key][$k]))
                        $res[$key][$k] = $p;
                }
                // }
                // }
            }


            $this->view->params['breadcrumbs'][] = [
                'label' => $this->pageName,
                'url' => ['/admin/app/languages/edit-locale']
            ];

            $this->view->params['breadcrumbs'][] = [
                'label' => Yii::$app->request->get('key'),
                'url' => ['/admin/app/languages/edit-locale', 'key' => Yii::$app->request->get('key')]
            ];
            $this->pageName = ucfirst(basename(Yii::$app->request->get('file'), '.php'));
            $this->view->params['breadcrumbs'][] = $this->pageName;
            //  CMS::dump($res);  die;
            return $this->render('edit-locale-open-file', ['res' => $res, 'languages' => $languages, 'tabs' => $tabs]);

        } elseif (Yii::$app->request->get('key')) {
            $t = $i18n->translations[Yii::$app->request->get('key')];
            $filesMap = (is_object($t)) ? $t->fileMap : $t['fileMap'];

            foreach ($filesMap as $key => $file) {
                $data[] = [
                    'key' => $key,
                    'url' => Html::a(Html::icon('edit'), ['/admin/app/languages/edit-locale', 'key' => Yii::$app->request->get('key'), 'file' => $file], ['class' => 'btn btn-sm btn-secondary'])
                ];
            }
            $provider = new ArrayDataProvider([
                'allModels' => $data,
                'pagination' => false,
            ]);

            $this->view->params['breadcrumbs'][] = [
                'label' => $this->pageName,
                'url' => ['/admin/app/languages/edit-locale']
            ];
            $this->pageName = Yii::$app->request->get('key');
            $this->view->params['breadcrumbs'][] = $this->pageName;
            return $this->render('edit-locale-open', ['provider' => $provider]);
        }
        $r = [];
        $this->view->params['breadcrumbs'][] = $this->pageName;
        $data = [];
        foreach ($i18n->translations as $key => $translation) {
            if (is_object($translation)) {
                if (isset($translation->fileMap)) {
                    $filesMap = $translation->fileMap;
                }
            } else {
                if (isset($translation['fileMap'])) {
                    $filesMap = $translation['fileMap'];
                }
            }

            if (isset($filesMap)) {
                if (!in_array($key, ['yii'])) { //!preg_match('/[a-z]\/[a-z]/', $key) //  && preg_match('/^[\w]+\/(\*)?$/', $key)
                    if (isset($i18n->translations[$key])) {
                        $basePath = (isset($i18n->translations[$key]->basePath)) ? $i18n->translations[$key]->basePath : $i18n->translations[$key]['basePath'];
                        $r['path'][] = $basePath;
                        $r['s'][] = $key;
                    }

                    $data[] = [
                        'key' => $key,
                        'url' => Url::to(['/admin/app/languages/edit-locale', 'key' => $key]),
                        'items' => $filesMap
                    ];
                }
            }
        }

        sort($data);
        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => false,
        ]);
        // echo file_get_contents(Yii::getAlias($file));
        return $this->render('edit-locale', [
            'provider' => $provider,
            'r' => $r
        ]);
        return $this->render('edit-locale', ['r' => $r]);
    }


    public function getAddonsMenu()
    {
        return [
            [
                'label' => Yii::t('admin/default', 'EDIT_LOCALE'),
                'url' => ['/admin/app/languages/edit-locale'],
                'visible' => true,

            ],
        ];
    }
}
