<?php

namespace panix\mod\admin\models\query;

use panix\engine\traits\query\TranslateQueryTrait;
use yii\db\ActiveQuery;
use panix\engine\traits\query\DefaultQueryTrait;

/**
 * This is the ActiveQuery class for [[Block]].
 *
 * @see Block
 */
class BlockQuery extends ActiveQuery
{
    use DefaultQueryTrait, TranslateQueryTrait;

}
