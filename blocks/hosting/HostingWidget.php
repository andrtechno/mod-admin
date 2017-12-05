<?php

namespace panix\mod\admin\blocks\hosting;

use Yii;
use panix\engine\CMS;

class HostingWidget extends \panix\engine\data\Widget {

    public function run() {
        die('s');
        return $this->render($this->skin, array(
            'cms_ver' => $this->labelHtml(Yii::$app->version),
            'yii_ver' => $this->labelHtml(Yii::getVersion()),
            'globals' => $globals,

        ));
    }


}
