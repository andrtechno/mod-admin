<?php

namespace panix\mod\admin\models\query;

use panix\mod\admin\models\Notifications;
use yii\db\ActiveQuery;

class NotificationsQuery extends ActiveQuery {

    public function read($state = 1) {
        return $this->andWhere([Notifications::tableName().'.is_read' => $state]);
    }

}
