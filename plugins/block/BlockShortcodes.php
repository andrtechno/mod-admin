<?php

namespace panix\mod\admin\plugins\block;

use Yii;
use panix\engine\bootstrap\Alert;
use panix\mod\admin\models\Block;
use panix\mod\plugins\BaseShortcode;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Response;
use yii\web\View;

/**
 * Plugin Name: Blocks Shortcodes
 * Plugin URI: https://pixelion.com.ua
 * Version: 1.0
 * Description: Blocks Shortcodes
 * Author: Andrey S
 * Author URI: https://pixelion.com.ua
 */
class BlockShortcodes extends BaseShortcode
{
    public static function shortcodes()
    {
        return [
            'block' => [
                'config' => [
                    'id' => 0,
                    'view' => false
                ],
                'callback' => function ($data) {

                    if ($data['id']) {
                        $model = Block::findOne((int)$data['id']);

                        if (!$model) {
                            return Alert::widget(['body' => "[block id=\"{$data['id']}\"] Блок не найден.", 'options' => ['class' => 'alert-danger']]);
                        }
                        if ($model->switch) {
                            if ($data['view']) {
                                return Yii::$app->view->render($data['view'], ['content' => $model->content, 'name' => $model->name]);
                            } else {
                                return Html::tag('div', $model->content, ['class' => (isset($data['class'])) ? $data['class'] : '']);
                            }
                        } else {
                            return '';
                        }

                    } else {
                        return Alert::widget(['body' => '[block] Обязательный параментр "id" отсуствует', 'options' => ['class' => 'alert-danger']]);
                    }
                },
                'tooltip' => '[block id="1"]'
            ],
            'blockInline' => [
                'config' => [
                    'id' => 0,
                    'view' => false
                ],
                'callback' => function ($data) {
                    if ($data['id']) {
                        $model = Block::findOne($data['id']);
                        if (!$model) {
                            return Alert::widget(['body' => "[block id=\"{$data['id']}\"] Блок не найден.", 'options' => ['class' => 'alert-danger']]);
                        }
                        if ($model->switch) {
                            if ($data['view']) {
                                return Yii::$app->view->render($data['view'], ['content' => $model->content, 'name' => $model->name]);
                            } else {
                                return Html::tag('span', $model->content, ['class' => (isset($data['class'])) ? $data['class'] : '']);
                            }
                        } else {
                            return '';
                        }
                    } else {
                        return Alert::widget(['body' => '[block] Обязательный параментр "id" отсуствует', 'options' => ['class' => 'alert-danger']]);
                    }
                },
                'tooltip' => '[blockInline id="1"]'
            ],
        ];
    }

    public static $config = [
        'search' => 'Hello, world!',
        'replace' => 'Hello, Yii!',
        'color' => '#FFDB51'
    ];

    /**
     * @return array
     */
    public static function events()
    {
        return [
            Response::class => [
                Response::EVENT_AFTER_PREPARE => ['hello', self::$config]
            ]
        ];
    }

    /**
     * @param $event
     */
    public static function hello($event)
    {
        if (!$content = $event->sender->content) return;

        $search = ArrayHelper::getValue($event->data, 'search', self::$config['search']);
        $replace = ArrayHelper::getValue($event->data, 'replace', self::$config['replace']);
        $color = ArrayHelper::getValue($event->data, 'color', self::$config['color']);

        $event->sender->content = str_replace('foo', 'test rep', $content);
    }

}
