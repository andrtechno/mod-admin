<?php

namespace panix\mod\admin\models\query;

use panix\mod\admin\models\Notifications;
use yii\db\ActiveQuery;

class NotificationsQuery extends ActiveQuery
{
    public function init()
    {
        return $this->addOrderBy([Notifications::tableName() . '.id' => SORT_DESC]);
    }

    public function read(array $state)
    {
        return $this->andWhere([Notifications::tableName() . '.status' => $state]);
    }

}
