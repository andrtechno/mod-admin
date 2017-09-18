<?php

namespace panix\mod\admin\controllers;

use Yii;
use panix\engine\controllers\AdminController;
use panix\mod\admin\models\Notifactions;

class DefaultController extends AdminController {


    public function actionIndex(){
        $this->breadcrumbs[]=Yii::t('admin/default','SYSTEM');
        return $this->render('index', [
           
        ]);
    }
    
    public function actionAjaxCounters(){
        
        $notifactions = Notifactions::find()->read(0)->all();
        $result = [];
        $result['count']['cart'] = 5;
        $result['count']['comments'] = 10;
        $result['notify'] = [];
        foreach($notifactions as $notify){
            $result['notify'][$notify->id]=[
                'text'=>$notify->text,
                'type'=>$notify->type
            ];

        }

        return \yii\helpers\Json::encode($result);
    }
    
    
    public function actionAjaxReadNotifaction($id){
        
        //$notifactions = Notifactions::find()->where(['id'=>$id])->one();
        $notifactions = Notifactions::findOne($id);
        $notifactions->is_read = 1;
        $notifactions->save(false);

        return \yii\helpers\Json::encode(['ok']);
    }

}
