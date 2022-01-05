<?php

namespace panix\mod\admin\widgets\languageInput;

use panix\engine\CMS;
use panix\engine\data\Widget;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class LanguageInput extends InputWidget
{
    public $type = 'text';
    public function run() {
       // CMS::dump($this->field->form,1,true);die;
        if ($this->hasModel()) {
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textInput($this->name, $this->value, $this->options);
        }

    }
}