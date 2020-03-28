<?php

namespace panix\mod\admin\models\query;

use panix\mod\admin\models\Notification;
use yii\db\ActiveQuery;

class NotificationQuery extends ActiveQuery
{
    public function init()
    {
        return $this->addOrderBy([Notification::tableName() . '.id' => SORT_DESC]);
    }

    public function read(array $state)
    {
        return $this->andWhere([Notification::tableName() . '.status' => $state]);
    }

}
