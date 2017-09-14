<?php

namespace panix\mod\admin\blocks\sysinfo;

use Yii;
use panix\engine\CMS;

class SysinfoWidget extends \panix\engine\data\Widget {

    public function run() {

        $memorylimit = CMS::files_size(str_replace("M", "", ini_get('memory_limit')) * 1024 * 1024);
        $globals = (ini_get('register_globals') == 1) ? $this->labelHtml(Yii::t('app', 'ON', 0), 'danger') : $this->labelHtml(Yii::t('app', 'OFF', 0), 'success');
        $magic_quotes = (ini_get('magic_quotes_gpc') == 1) ? $this->labelHtml(Yii::t('app', 'ON', 0), 'danger') : $this->labelHtml(Yii::t('app', 'OFF', 0), 'success');

        $p_max = $this->labelHtml(CMS::files_size(str_replace("M", "", ini_get('post_max_size')) * 1024 * 1024));
        $u_max = $this->labelHtml(CMS::files_size(str_replace("M", "", ini_get('upload_max_filesize')) * 1024 * 1024));
        if (CMS::getMemoryLimit() <= 64) {
            $m_max = $this->labelHtml($memorylimit, 'danger');
        } elseif (CMS::getMemoryLimit() <= 128) {
            $m_max = $this->labelHtml($memorylimit, 'warning');
        } else {
            $m_max = $this->labelHtml($memorylimit, 'success');
        }

        $phpver = phpversion();
        $gd = (extension_loaded('gd')) ? $this->labelHtml(Yii::t('app', 'ON', 0), 'success') : $this->labelHtml(Yii::t('app', 'OFF', 0), 'danger');
        $pdo = (extension_loaded('pdo')) ? $this->labelHtml(Yii::t('app', 'ON', 0), 'success') : $this->labelHtml("<font color=\"red\">" . Yii::t('app', 'OFF', 0) . "</font>", 'danger');
        $php = ($phpver >= "5.1") ? $this->labelHtml("$phpver (" . @php_sapi_name() . ")", 'success') : $this->labelHtml("$phpver (" . @php_sapi_name() . ")", 'danger');


        $uploadsDirSize = Yii::$app->cache->get('cache-uploads-' . $this->id);
        if ($uploadsDirSize === false) {
            $uploadsDirSize = CMS::dir_size(Yii::getAlias('@app/web/uploads'));
            Yii::$app->cache->set('cache-uploads-' . $this->id, $uploadsDirSize, 3600 * 12);
        }

        $backupsDirSize = Yii::$app->cache->get('cache-backup-' . $this->id);
        if ($backupsDirSize === false) {
            $backupsDirSize = CMS::dir_size(Yii::getAlias('@app/backups'));
            Yii::$app->cache->set('cache-backup-' . $this->id, $backupsDirSize, 3600 * 12);
        }


        $assetsDirSize = Yii::$app->cache->get('cache-assets-' . $this->id);
        if ($assetsDirSize === false) {
            $assetsDirSize = CMS::dir_size(Yii::getAlias('@app/web/assets'));
            Yii::$app->cache->set('cache-assets-' . $this->id, $assetsDirSize, 3600 * 12);
        }

        $cacheDirSize = Yii::$app->cache->get('cache-dir-' . $this->id);
        if ($cacheDirSize === false) {
            $cacheDirSize = CMS::dir_size(Yii::getAlias('@app/runtime/cache'));
            Yii::$app->cache->set('cache-dir-' . $this->id, $cacheDirSize, 3600 * 12);
        }

        return $this->render($this->skin, array(
            'cms_ver' => $this->labelHtml(Yii::$app->version),
            'yii_ver' => $this->labelHtml(Yii::getVersion()),
            'globals' => $globals,
            'magic_quotes' => $magic_quotes,
            'p_max' => $p_max,
            'u_max' => $u_max,
            'm_max' => $m_max,
            'gd' => $gd,
            'os' =>@php_uname('s'),
            'php' => $php,
            'pdo' => $pdo,
            'backup_dir_size' => CMS::files_size($backupsDirSize['size']),
            'uploads_dir_size' => CMS::files_size($uploadsDirSize['size']),
            'assets_dir_size' => CMS::files_size($assetsDirSize['size']),
            'cache_dir_size' => CMS::files_size($cacheDirSize['size']),
            'timezone' => Yii::$app->settings->get('app', 'timezone'),
        ));
    }

    private function labelHtml($value, $class = 'default') {
        return '<span class="label label-' . $class . '">' . $value . '</span>';
    }

}
