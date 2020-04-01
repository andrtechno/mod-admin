<?php

namespace panix\mod\admin\controllers\admin;

use Yii;
use panix\engine\Html;
use panix\engine\blocks_settings\WidgetSystemManager;
use panix\engine\controllers\AdminController;
use yii\helpers\FileHelper;


/**
 * Class HelpController
 * @package panix\mod\admin\controllers\admin
 */
class HelpController extends AdminController
{

    public $icon = 'info';

    public function actionIndex()
    {
        $this->pageName = Yii::t('admin/default', 'HELP');
        $this->breadcrumbs = [$this->pageName];

        return $this->render('index', []);
    }

    public function actionIcon()
    {
        return $this->render('icon', []);
    }

}
