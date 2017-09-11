<?php
use panix\engine\Html;

 $menu = isset(Yii::$app->controller->addonsMenu) ? Yii::$app->controller->addonsMenu : array();
 if (isset($menu)) { ?>
    <div class="breadLinks">
        <ul>
            <?php
            foreach ($menu as $param) {
                $param['visible'] = isset($param['visible']) ? $param['visible'] : true;
                if ($param['visible']) {
                    if (isset($param['items'])) {
                        $htmlOptionsLi = (isset($param['icon'])) ? array('class' => 'dropdown has has-icon') : array('class' => 'dropdown has');
                        echo Html::beginTag('li', $htmlOptionsLi); //Обязательный класс has.
                        echo Html::a($param['icon'] . ' ' . $param['label'] . '<span class="caret"></span>', 'javascript:void(0)', isset($param['linkOptions']) ? $param['linkOptions'] : array(
                                    'data-toggle' => "dropdown",
                                    'aria-haspopup' => "true",
                                    'aria-expanded' => "false"));
                        echo Html::beginTag('ul', (isset($param['itemsHtmlOptions']) ? $param['itemsHtmlOptions'] : array('class' => 'dropdown-menu pull-right')));
                        if (isset($param['items'])) {
                            foreach ($param['items'] as $sparam) {
                                $sparam['visible'] = isset($sparam['visible']) ? $sparam['visible'] : true;
                                if ($sparam['visible']) {
                                    $htmlOptionsLi = (isset($sparam['icon'])) ? array('class' => 'has-icon') : array();
                                    $sparam['linkOptions'] = isset($sparam['linkOptions'])?$sparam['linkOptions']:array();
                                    echo Html::beginTag('li', $htmlOptionsLi);
                                    
                                    echo Html::a($sparam['icon'] . ' ' . $sparam['label'], $sparam['url'], $sparam['linkOptions']);
                                    echo Html::endTag('li');
                                }
                            }
                        }
                        echo Html::endTag('li');
                        echo Html::endTag('ul');
                    } else {
                        $htmlOptionsLi = (isset($param['icon'])) ? array('class' => 'has-icon') : array();
                        $icon = (isset($param['icon'])) ? $param['icon'] : '';
                        $param['linkOptions'] = (isset($param['linkOptions'])) ? $param['linkOptions'] : array();
                        echo Html::beginTag('li', $htmlOptionsLi);
                        echo Html::a($icon . ' ' . $param['label'], $param['url'], $param['linkOptions']);
                        echo Html::endTag('li');
                    }
                }
            }
            ?>
        </ul>
        <div class="clearfix"></div>
    </div>
<?php } ?> 