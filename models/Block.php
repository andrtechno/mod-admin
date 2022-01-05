<?php

namespace panix\mod\admin\models;

use panix\mod\admin\models\query\BlockQuery;
use Yii;
use panix\engine\db\ActiveRecord;

class Block extends ActiveRecord
{
    const MODULE_ID = 'admin';
    public $translationClass = BlockTranslate::class;
    public $disallow_delete = [1,2,3];

    public static function find()
    {
        return new BlockQuery(get_called_class());
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%block}}';
    }
    public function getGridColumns2()
    {
        return [
            'id' => [
                'attribute' => 'id',
                'contentOptions' => ['class' => 'text-center'],
            ],
            'name'=>[
                'attribute' => 'name',
                'contentOptions' => ['class' => 'text-left'],
            ],
            'content'=>[
                'attribute' => 'content',
                'format' => 'html'
            ],
            'DEFAULT_CONTROL' => [
                'class' => 'panix\engine\grid\columns\ActionColumn',
            ],
            'DEFAULT_COLUMNS' => [
                ['class' => 'panix\engine\grid\columns\CheckboxColumn'],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'content'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

}
