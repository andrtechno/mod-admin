<?php

namespace panix\mod\admin\models\query;


class TagQuery extends \yii\db\ActiveQuery
{


    public function updateFrequency($oldTags, $newTags) {
        $oldTags = self::string2array($oldTags);
        $newTags = self::string2array($newTags);
        $this->addTags(array_values(array_diff($newTags, $oldTags)));
        $this->removeTags(array_values(array_diff($oldTags, $newTags)));
    }

    public function addTags($tags) {
       // $criteria = new CDbCriteria;
       // $criteria->addInCondition('name', $tags);
        //$this->updateCounters(array('frequency' => 1), $criteria);

        //$post = Tag::findOne($id);
        $this->andWhere(['name'=>$tags]);
        $this->updateCounters(['frequency' => 1]);


        foreach ($tags as $name) {
            if (!$this->exists('name=:name', array(':name' => $name))) {
                $tag = new Tag;
                $tag->name = $name;
                $tag->frequency = 1;
                $tag->save();
            }
        }
    }

    public function removeTags($tags) {
        if (empty($tags))
            return;
        //$criteria = new CDbCriteria;
       // $criteria->addInCondition('name', $tags);
       // $this->updateCounters(array('frequency' => -1), $criteria);
        $this->andWhere(['name'=>$tags]);
        $this->updateCounters(['frequency' => -1]);
        $this->deleteAll('frequency<=0');
    }

    public static function string2array($tags) {
        return preg_split('/\s*,\s*/', trim($tags), -1, PREG_SPLIT_NO_EMPTY);
    }

    public static function array2string($tags) {
        return implode(', ', $tags);
    }
}
