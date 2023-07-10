<?php

namespace panix\mod\admin\blocks\sysinfo;

use Yii;
use panix\engine\CMS;
use panix\engine\data\Widget;

class SysInfoWidget extends Widget
{

    public function run()
    {

        $memorylimit = CMS::fileSize(str_replace("M", "", ini_get('memory_limit')) * 1024 * 1024);
        $globals = (ini_get('register_globals') == 1) ? $this->labelHtml(Yii::t('app/default', 'ON'), 'danger') : $this->labelHtml(Yii::t('app/default', 'OFF'), 'success');
        $magic_quotes = (ini_get('magic_quotes_gpc') == 1) ? $this->labelHtml(Yii::t('app/default', 'ON'), 'danger') : $this->labelHtml(Yii::t('app/default', 'OFF'), 'success');

        $p_max = $this->labelHtml(ini_get('post_max_size'));
        $u_max = $this->labelHtml(ini_get('upload_max_filesize'));
        if (CMS::getMemoryLimit() <= 64) {
            $m_max = $this->labelHtml($memorylimit, 'danger');
        } elseif (CMS::getMemoryLimit() <= 128) {
            $m_max = $this->labelHtml($memorylimit, 'warning');
        } else {
            $m_max = $this->labelHtml($memorylimit, 'success');
        }

        $phpver = phpversion();
        $gd = (extension_loaded('gd')) ? $this->labelHtml(Yii::t('app/default', 'ON', 0), 'success') : $this->labelHtml(Yii::t('app/default', 'OFF'), 'danger');
        $pdo = (extension_loaded('pdo')) ? $this->labelHtml(Yii::t('app/default', 'ON', 0), 'success') : $this->labelHtml("<span style=\"color:red\">" . Yii::t('app/default', 'OFF') . "</span>", 'danger');
        $php = ($phpver >= "5.1") ? $this->labelHtml(PHP_VERSION, 'success') : $this->labelHtml("$phpver (" . @php_sapi_name() . ")", 'danger');


        $checkOs = ini_set('disable_functions', "php_uname") ? @php_uname('s') : PHP_OS;
        return $this->render($this->skin, array(
            'cms_ver' => $this->labelHtml(Yii::$app->version),
            'yii_ver' => $this->labelHtml(Yii::getVersion()),
            'globals' => $globals,
            'magic_quotes' => $magic_quotes,
            'p_max' => $p_max,
            'u_max' => $u_max,
            'm_max' => $m_max,
            'gd' => $gd,
            'os' => $checkOs,
            'php' => $php,
            'pdo' => $pdo,
            'timezone' => Yii::$app->settings->get('app', 'timezone'),
        ));
    }

    private function labelHtml($value, $class = 'secondary')
    {
        return '<span class="badge badge-' . $class . '">' . $value . '</span>';
    }

}
