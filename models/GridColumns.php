<?php

namespace panix\mod\admin\models;

use panix\engine\db\ActiveRecord;

class GridColumns extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%grid_columns}}';
    }

}
