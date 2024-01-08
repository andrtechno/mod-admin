<?php

namespace panix\mod\admin\components;

use yii\base\Event;

class TimelineEvent extends Event
{
    public $params = [];
    public $callback = 'timeline';

    public function timeline()
    {
        return $this->params;
    }

    public function onRegister()
    {
        return 'Зарегистрировался';
    }

    public function onLogin()
    {
        return 'Вошел - '.$this->params['id'];
    }

    public function onLogout()
    {
        if(isset($this->params['id'])){

        }
        return 'Вышел - '.$this->params['id'];
    }
}
