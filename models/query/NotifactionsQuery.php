<?php

namespace panix\mod\admin\models\query;

use yii\db\ActiveQuery;

class NotifactionsQuery extends ActiveQuery {

    public function read($state = 1) {
        return $this->andWhere(['{{%notifactions}}.is_read' => $state]);
    }

}
