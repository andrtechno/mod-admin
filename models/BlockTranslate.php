<?php

namespace panix\mod\admin\models;

use yii\db\ActiveRecord;

/**
 * Class BlockTranslate
 *
 * @property array $translationAttributes
 */
class BlockTranslate extends ActiveRecord
{

    public static $translationAttributes = ['name', 'content'];

    public static function tableName()
    {
        return '{{%block_translate}}';
    }

}
