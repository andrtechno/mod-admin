<?php

namespace panix\mod\admin\widgets\sidebar;

use panix\engine\bootstrap\Nav;
use yii\web\View;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use panix\engine\Html;

class SiderbarNav extends Nav
{


    //public $dropdownClass = '\panix\engine\bootstrap\DropdownSidebar';

    public function init()
    {
        $this->view->registerJs("
            $('#sidebar-wrapper .dropdown-toggle').dropdown({display:'static'});
        ",View::POS_END);

        //$items = ArrayHelper::merge($this->items,$this->findMenu());
        //$this->items = $items;
        parent::init();

    }

    public function findMenu($mod = false) {
        $result = [];
        $modules = Yii::$app->getModules();
        foreach ($modules as $mid => $module) {
            if (isset(Yii::$app->getModule($mid)->adminMenu)) {
                $result = ArrayHelper::merge($result, Yii::$app->getModule($mid)->getAdminMenu());
            }
        }

        $resultFinish = [];
        foreach ($result as $mid => $res) {
            $resultFinish[$mid] = $res;
            if (isset($res['items'])) {
                foreach ($res['items'] as $k => $item) {
                    if (isset($item['visible'])) {
                        if (!$item['visible']) {
                            unset($resultFinish[$mid]['items'][$k]);
                        }
                    }
                }
            }
        }
        return ($mod) ? $resultFinish[$mod] : $resultFinish;
    }


    public function renderItem($item)
    {
        if (is_string($item)) {
            return $item;
        }

        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        // $id=crc32($item['label']).CMS::gen(4);
        $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
        $icon = isset($item['icon']) ? Html::icon($item['icon']) . ' ' : '';
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', [
            // 'id'=>'dropdown-'.$id,
            'aria-haspopup' => "true",
            'aria-expanded' => "false"
        ]);

        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        } else {
            $active = $this->isItemActive($item);
        }

        if ($items !== null) {
            $linkOptions['data-toggle'] = 'dropdown';
            Html::addCssClass($options, 'nav-item dropdown');
            Html::addCssClass($linkOptions, 'nav-link dropdown-toggle');
            // $label .= ' ' . Html::tag('b', '', ['class' => 'caret2']);
            if (is_array($items)) {
                if ($this->activateItems) {
                    $items = $this->isChildActive($items, $active);
                }
                $items = $this->renderDropdown($items, $item);

            }
        }
        Html::addCssClass($options, 'nav-item');
        Html::addCssClass($linkOptions, 'nav-link');
        if ($this->activateItems && $active) {
            Html::addCssClass($options, 'active'); // In NavBar the "nav-item" get's activated
            Html::addCssClass($linkOptions, 'active');
        }

        return Html::tag('li', Html::a( $icon.$label, $url, $linkOptions) . $items, $options);
    }

}
