<?php

namespace panix\mod\admin\controllers\admin;

use panix\engine\CMS;
use Yii;
use yii\helpers\ArrayHelper;

class EditorfileController extends \panix\engine\controllers\AdminController {

    public $icon = 'icon-file';
    public $path_robots = false;

    public function init() {

        if (file_exists(Yii::getAlias('@frontend/web') . DIRECTORY_SEPARATOR . 'robots.txt')) {
            $this->path_robots = Yii::getAlias('@frontend/web') . DIRECTORY_SEPARATOR . 'robots.txt';
        }
        parent::init();
    }

    public function actionIndex() {
        $request = Yii::$app->request;
        $this->pageName = Yii::t('app', 'Редактирование файлов');
        // $this->breadcrumbs = array($this->pageName);

        if ($this->path_robots) {
            $robots = file_get_contents($this->path_robots, false);
        }

        if ($request->post('robots_reset')) {
            if ($request->post('robots_reset')) {
                $robots_h = fopen($this->path_robots, "wb");
                fwrite($robots_h, $this->defaultRobots());
                fclose($robots_h);
            }
            Yii::$app->session->setFlash('success', 'Success! default');
            return $this->redirect(['/admin/app/editorfile']);
        }




        $contentRobots = $request->post('robots');
        if ($contentRobots) {

            $robots_h = fopen($this->path_robots, "wb");
            fwrite($robots_h, CMS::textReplace($contentRobots));
            fclose($robots_h);

            Yii::$app->session->setFlash('success', 'Success! default');
            $this->redirect(['/admin/app/editorfile']);
        }



        return $this->render('index', array(
                    'robots' => CMS::textReplace($robots,[],true)
        ));
    }

    protected function defaultHtaccess() {
        return '
# Required parameter
#AddDefaultCharset ' . Yii::$app->charset . '

Options +FollowSymLinks
IndexIgnore */*
RewriteEngine On


RewriteCond %{REQUEST_URI} !^/(web)
RewriteRule ^assets/(.*)$ /web/assets/$1 [L]
RewriteRule ^css/(.*)$ web/css/$1 [L]
RewriteRule ^js/(.*)$ web/js/$1 [L]
RewriteRule ^uploads/(.*)$ web/uploads/$1 [L]
RewriteRule ^robots.txt$ web/robots.txt$1 [L]
RewriteRule (.*) /web/$1


# Redirect HTTP to HTTPS.
#RewriteCond %{HTTPS} !=on
#RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
# If there is a cyclic redirect, then use this option
#RewriteCond %{HTTPS} off
#RewriteCond %{HTTP:X-Forwarded-Proto} !https
#RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]


# if a directory or a file exists, use it directly
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

RewriteRule . /web/index.php
';
    }

    protected function defaultRobots() {
        return 'User-Agent: *
Disallow: /placeholder
Disallow: /admin/auth
Disallow: /assets/
Disallow: /protected/
Disallow: /themes/
Disallow: /upgrade/

Host: ' . Yii::$app->request->hostInfo . '

' . ((Yii::$app->hasModule('sitemap')) ? 'Sitemap: ' . Yii::$app->request->hostInfo . '/sitemap.xml' : '') . '';
    }

}
