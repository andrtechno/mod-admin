<?php

namespace panix\mod\admin\widgets\sidebar;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use panix\engine\Html;

class BackendNav extends \yii\bootstrap4\Nav {

    public $dropdownClass = '\panix\engine\bootstrap\Dropdown';

    /**
     * @var array the dropdown widget options
     */
    public $dropdownOptions = [];

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init() {
        if (!class_exists($this->dropdownClass)) {
            throw new InvalidConfigException("The dropdownClass '{$this->dropdownClass}' does not exist or is not accessible.");
        }

        $found = ArrayHelper::merge($this->items, $this->findMenu());
        $defaultItems = [
            'system' => [
                'label' => Yii::t('admin/default', 'SYSTEM'),
                'icon' => 'tools',
                // 'visible' => count($found['system']['items'])
            ],
            'modules' => [
                'label' => Yii::t('admin/default', 'MODULES'),
                'icon' => 'puzzle',
                // 'visible' => count($found['modules']['items'])
                //  'items'=>$found['modules']['items']
            ],
        ];
        $this->items = ArrayHelper::merge($defaultItems, $found);


        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function renderDropdown($items, $parentItem) {
        /**
         * @var \panix\engine\bootstrap\Dropdown $ddWidget
         */
        $ddWidget = $this->dropdownClass;
        $ddOptions = array_replace_recursive($this->dropdownOptions, [
            'items' => $items,
            'encodeLabels' => $this->encodeLabels,
            'clientOptions' => false,
            // 'options'=>['aria-labelledby'=>$id],
            'view' => $this->getView(),
        ]);
        return $ddWidget::widget($ddOptions);
    }

    /**
     * @inheritdoc
     */
    protected function isChildActive($items, &$active) {
        foreach ($items as $i => $child) {
            if (ArrayHelper::remove($items[$i], 'active', false) || $this->isItemActive($child)) {
                Html::addCssClass($items[$i]['options'], 'active');
                if ($this->activateParents) {
                    $active = true;
                }
            }
            if (isset($items[$i]['items']) && is_array($items[$i]['items'])) {
                $childActive = false;
                $items[$i]['items'] = $this->isChildActive($items[$i]['items'], $childActive);
                if ($childActive) {
                    Html::addCssClass($items[$i]['options'], 'active');
                    $active = true;
                }
            }
        }
        return $items;
    }

    public function findMenu($mod = false) {
        $result = array();
        $modules = Yii::$app->getModules();
        foreach ($modules as $mid => $module) {

            //Yii::import("mod.{$mid}.{$moduleName}Module");
            if (isset(Yii::$app->getModule($mid)->adminMenu)) {
                $result = ArrayHelper::merge($result, Yii::$app->getModule($mid)->getAdminMenu());
            }
        }

        $resultFinish = array();
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

    public function renderItem($item) {
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
            'aria-haspopup'=>"true",
            'aria-expanded'=>"false"
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

        if ($this->activateItems && $active) {
            Html::addCssClass($options, 'active');
        }

        return Html::tag('li', Html::a($icon . $label, $url, $linkOptions) . $items, $options);
    }

}
