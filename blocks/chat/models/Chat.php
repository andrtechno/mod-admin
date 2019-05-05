<?php

namespace panix\mod\admin\blocks\chat\models;

use Yii;
use panix\engine\CMS;
use panix\engine\Html;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "chat".
 *
 * @property integer $id
 * @property string $message
 * @property integer $userId
 * @property string $updateDate
 */
class Chat extends ActiveRecord {

    public $userModel;
    public $userField;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%chat}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['message'], 'required'],
            [['user_id'], 'integer'],
            [['date_update', 'message'], 'safe']
        ];
    }

    public function getUser() {
        if (isset($this->userModel))
            return $this->hasOne($this->userModel, ['id' => 'user_id']);
        else
            return $this->hasOne(Yii::$app->getUser()->identityClass, ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'user_id' => 'User',
            'date_update' => 'Update Date',
        ];
    }

    public function beforeSave($insert) {
        $this->user_id = Yii::$app->user->id;
        return parent::beforeSave($insert);
    }

    public static function records() {
        return static::find()->limit(10)->orderBy('id DESC')->all();
    }

    public function data() {
        $userField = $this->userField;
        $output = '';
        $models = Chat::records();
        krsort($models);
        reset($models);
        if ($models)
            foreach ($models as $model) {
                if (isset($model->user->$userField)) {
                    $avatar = $model->user->$userField;
                } else {
                    $avatar = Yii::$app->assetManager->getPublishedUrl("@admin/assets/images/chat/avatar.png");
                }

                $isYouPosition = ($model->user->id == Yii::$app->user->id) ? 'left' : 'right';
                $isYouBool = ($model->user->id == Yii::$app->user->id) ? true : false;



                $output .= '<div class="' . $isYouPosition . ' clearfix chat-item">';
                $output .= '<div class="chat-img float-' . $isYouPosition . '"><img src="http://placehold.it/50/55C1E7/fff" alt="' . $model->user->username . '" class="rounded-circle" /></div>';
                $output .= '<div class="chat-body">';
                $output .= '<div class="chat-header">';
                if ($isYouBool) {
                    $output .= '<strong class="primary-font">' . $model->user->username . '</strong>';
                    $output .= '<small class="float-right text-muted">';
                    $output .= '<i class="icon-time"></i> ' . CMS::date($model->date_update, true) . '</small>';
                } else {
                    $output .= '<small class=" text-muted">';
                    $output .= '<i class="icon-time"></i> ' . CMS::date($model->date_update, true) . '</small>';
                    $output .= '<strong class="float-right primary-font">' . $model->user->username . '</strong>';
                }

                $output .= '</div>';
                $output .= '<div class="chat-text">' . Html::text(CMS::replace_urls($model->message)) . '</div>';
                $output .= '</div>';
                $output .= '</div>';
            }

        return $output;
    }

}
