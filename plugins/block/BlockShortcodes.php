<?php

namespace panix\mod\admin\plugins\block;


use panix\engine\bootstrap\Alert;
use panix\mod\admin\models\Block;
use panix\mod\plugins\BaseShortcode;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Response;

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
                    'id' => 0
                ],
                'callback' => function ($data) {
                    if ($data['id']) {
                        $model = Block::findOne($data['id']);
                        if (!$model) {
                            return Alert::widget(['body' => "[block id=\"{$data['id']}\"] Блок не найден.", 'options' => ['class' => 'alert-danger']]);
                        }
                        if ($model->switch) {
                            return Html::tag('div', $model->content, ['class' => (isset($data['class'])) ? $data['class'] : '']);
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
                    'id' => 0
                ],
                'callback' => function ($data) {
                    if ($data['id']) {
                        $model = Block::findOne($data['id']);
                        if (!$model) {
                            return Alert::widget(['body' => "[block id=\"{$data['id']}\"] Блок не найден.", 'options' => ['class' => 'alert-danger']]);
                        }
                        if ($model->switch) {
                            return Html::tag('span', $model->content, ['class' => (isset($data['class'])) ? $data['class'] : '']);
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
}
