<?php

namespace panix\mod\admin\widgets\dynamicform;

use panix\engine\CMS;
use panix\engine\data\Widget;
use panix\mod\admin\models\DynamicForm;
use yii\base\DynamicModel;

class DynamicFormWidget extends Widget
{
    public $id;

    public function run()
    {
        $form = DynamicForm::findOne($this->id);


        $validators = [];
        $fieldsList = [];
        $attributesList = [];
        if ($form->rules) {
            foreach ($form->rules as $field) {
                $attributesList[]=$field['label'];
                $fieldsList[] = [
                    'type' => $field['type'],
                    'label' => $field['label'],
                    'placeholder' => $field['placeholder']
                ];
                if ($field['validator']) {
                    foreach ($field['validator'] as $validator) {
                        $validators[$validator][] = $field['label'];

                    }
                }
            }
        }
        $model = new DynamicModel($attributesList);

        foreach ($validators as $validate => $fields) {
            $model->addRule($fields, $validate);
        }
//CMS::dump($model);die;
        return $this->render($this->skin, ['form' => $form, 'model' => $model, 'fieldsList' => $fieldsList]);
    }
}
