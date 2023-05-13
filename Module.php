<?php

namespace panix\mod\admin;

use app\web\themes\dashboard\sidebar\BackendNav;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use panix\mod\admin\panel\Panel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use panix\engine\WebModule;

/**
 * Class Module
 * @package panix\mod\admin
 */
class Module extends WebModule implements BootstrapInterface
{
    public $panels = [];

    public function bootstrap($app)
    {
        /*$app->on(Application::EVENT_BEFORE_ACTION, function () use ($app) {
            $app->getView()->on(View::EVENT_END_BODY, [$this, 'renderToolbar']);
        });*/

    }

    public function getToolbarHtml()
    {
        $url = Url::toRoute([
            '/' . $this->id . '/default/toolbar',
            //'tag' => $this->logTarget->tag,
        ]);

        //  if (!empty($this->skipAjaxRequestUrl)) {
        //  foreach ($this->skipAjaxRequestUrl as $key => $route) {
        //   $this->skipAjaxRequestUrl[$key] = Url::to($route);
        //  }
        //  }
        return '<div id="pixelion-toolbar" data-url="' . Html::encode($url) . '" data-skip-urls="' . htmlspecialchars(json_encode([])) . '" style="display:block" class="pixelion-toolbar">123</div>';
    }

    public function renderToolbar($event)
    {
        if (Yii::$app->getRequest()->getIsAjax()) {
            return;
        }

        /* @var $view View */
        $view = $event->sender;
        echo $view->renderDynamic('return Yii::$app->getModule("' . $this->id . '")->getToolbarHtml();');

        // echo is used in order to support cases where asset manager is not available
        echo '<style>' . $view->renderPhpFile(__DIR__ . '/panel/assets/css/toolbar.css') . '</style>';
        //  echo '<script>' . $view->renderPhpFile(__DIR__ . '/panel/assets/js/toolbar.js') . '</script>';
    }

    protected function corePanels()
    {
        return [
            'config' => ['class' => 'yii\debug\panels\ConfigPanel'],
            'request' => ['class' => 'yii\debug\panels\RequestPanel'],
        ];
    }

    public function init()
    {
        parent::init();
        if (Yii::$app instanceof \yii\web\Application) {
            $this->initPanels();
        }
    }

    protected function initPanels()
    {
        // merge custom panels and core panels so that they are ordered mainly by custom panels
        if (empty($this->panels)) {
            $this->panels = $this->corePanels();
        } else {
            $corePanels = $this->corePanels();
            foreach ($corePanels as $id => $config) {
                if (isset($this->panels[$id])) {
                    unset($corePanels[$id]);
                }
            }
            $this->panels = array_filter(array_merge($corePanels, $this->panels));
        }

        foreach ($this->panels as $id => $config) {
            if (is_string($config)) {
                $config = ['class' => $config];
            }
            $config['module'] = $this;
            $config['id'] = $id;
            $this->panels[$id] = Yii::createObject($config);
            if ($this->panels[$id] instanceof Panel && !$this->panels[$id]->isEnabled()) {
                unset($this->panels[$id]);
            }
        }
    }

    public function getInfo()
    {
        return [
            'label' => Yii::t('admin/default', 'MODULE_NAME'),
            'author' => 'dev@pixelion.com.ua',
            'version' => '1.0',
            'icon' => 'icon-tools',
            'description' => Yii::t('admin/default', 'MODULE_DESC'),
            'url' => ['/admin/app'],
        ];
    }

    public function getAdminMenu()
    {
        return [
            'system' => [
                'items' => [
                    [
                        'label' => Yii::t('admin/default', 'LANGUAGES'),
                        'url' => ['/admin/app/languages'],
                        'icon' => 'fad fa-language',
                        'sort' => 2,
                        'visible' => Yii::$app->user->can('/admin/admin/languages/index') || Yii::$app->user->can('/admin/admin/languages/*')
                    ],
                    [
                        'label' => Yii::t('admin/default', 'WIDGETS'),
                        'url' => ['/admin/app/widgets'],
                        'icon' => 'fad fa-microchip',
                        'sort' => 1,
                        'visible' => Yii::$app->user->can('/admin/admin/widgets/index') || Yii::$app->user->can('/admin/admin/widgets/*')
                    ],
                    [
                        'label' => Yii::t('admin/default', 'BLOCKS'),
                        'url' => ['/admin/app/blocks'],
                        'icon' => 'fad fa-cubes',
                        'sort' => 1,
                        'visible' => Yii::$app->user->can('/admin/admin/blocks/index') || Yii::$app->user->can('/admin/admin/blocks/*')
                    ],
                    [
                        'label' => Yii::t('admin/default', 'Mails tpl'),
                        'url' => ['/admin/app/mail-template'],
                        'icon' => 'fad fa-envelope',
                        'sort' => 1,
                        'visible' => false,
                        //'visible' => Yii::$app->user->can('/admin/admin/mail-template/index') || Yii::$app->user->can('/admin/admin/mail-template/*')
                    ],
                    [
                        'label' => Yii::t('admin/default', 'DATABASE'),
                        'url' => ['/admin/app/database'],
                        'icon' => 'fad fa-database',
                        'sort' => 1,
                        'visible' => Yii::$app->user->can('/admin/admin/database/index') || Yii::$app->user->can('/admin/admin/database/*')
                    ],
                    [
                        'label' => Yii::t('admin/default', 'LOGS'),
                        'url' => ['/admin/app/logs'],
                        'icon' => 'fad fa-file',
                        'sort' => 1,
                        'visible' => Yii::$app->user->can('/admin/admin/logs/index') || Yii::$app->user->can('/admin/admin/logs/*')
                    ],
                    [
                        'label' => Yii::t('admin/default', 'MODULES'),
                        'url' => ['/admin/app/modules'],
                        'icon' => 'fad fa-puzzle-piece',
                        'visible' => false,
                        'sort' => 1,
                        //'visible' => Yii::$app->user->can('/admin/admin/modules/index') || Yii::$app->user->can('/admin/admin/modules/*')
                    ],
                    [
                        'label' => Yii::t('admin/default', 'DYNAMIC_FORM'),
                        'url' => ['/admin/app/dynamic-form'],
                        'icon' => 'arrow-right',
                        'sort' => 1,
                        'visible' => false,
                        //  'visible' => Yii::$app->user->can('/admin/admin/dynamic-form/index') || Yii::$app->user->can('/admin/admin/dynamic-form/*')
                    ],
                    [
                        'label' => Yii::t('admin/default', 'HELP'),
                        'url' => ['/admin/app/help'],
                        'icon' => 'info',
                        'sort' => 1,
                        'visible' => false,
                        //'visible' => Yii::$app->user->can('/admin/admin/help/index') || Yii::$app->user->can('/admin/admin/help/*')
                    ],
                    [
                        'label' => Yii::t('admin/default', 'TEMPLATE'),
                        'url' => ['/admin/app/template'],
                        'icon' => 'template',
                        'sort' => 1111,
                        'visible' => false,
                        //'visible' => Yii::$app->user->can('/admin/admin/template/index') || Yii::$app->user->can('/admin/admin/template/*')
                    ],
                    [
                        'label' => Yii::t('app/default', 'SETTINGS'),
                        'url' => ['/admin/app/settings'],
                        'icon' => 'fad fa-wrench', //fa-wrench fa-cog fa-cogs
                        'sort' => 1,
                        'visible' => Yii::$app->user->can('/admin/admin/settings/index') || Yii::$app->user->can('/admin/admin/settings/*')
                    ],
                ]
            ]
        ];
    }

    public function getAdminSidebar()
    {
        return Yii::$app->findMenu['system']['items'];
    }

}
