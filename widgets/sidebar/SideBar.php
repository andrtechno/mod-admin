<?php

namespace panix\mod\admin\widgets\sidebar;

use panix\engine\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class SideBar extends \yii\widgets\Menu {

    public $options = ['class' => 'sidebar-nav'];

    protected function renderItem($item) {
        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);

            return strtr($template, [
                '{url}' => Html::encode(Url::to($item['url'])),
                '{label}' => Html::icon($item['icon']) . ' ' . $item['label'],
            ]);
        }

        $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

        return strtr($template, [
            '{label}' => $item['label'],
        ]);
    }

}
