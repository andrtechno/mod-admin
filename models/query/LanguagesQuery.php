<?php

namespace panix\mod\admin\models\query;

use panix\engine\traits\query\DefaultQueryTrait;
use yii\db\ActiveQuery;

class LanguagesQuery extends ActiveQuery
{
    public function init()
    {
        /** @var \yii\db\ActiveRecord $modelClass */
        $modelClass = $this->modelClass;
        $tableName = $modelClass::tableName();
        $this->addOrderBy(["{$tableName}.ordern" => SORT_DESC]);
        parent::init();
    }

    public function published($state = 1)
    {
        return $this->andWhere(['switch' => $state]);
    }

}
