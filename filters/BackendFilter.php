<?php

namespace profitcode\blocks\filters;

use yii\web\NotFoundHttpException;
use yii\base\ActionFilter;

/**
 * BackendFilter is used to allow access only to admin and security controller in frontend when using Yii2-blocks with
 * Yii2 advanced template.
 *
 * @author Arif Allahverdiev <cheaterby@gmail.com>
 */
class BackendFilter extends ActionFilter
{
    /**
     * @var array
     */
    public $controllers = [''];

    /**
     * @param \yii\base\Action $action
     *
     * @return bool
     * @throws \yii\web\NotFoundHttpException
     */
    public function beforeAction($action)
    {
        if (in_array($action->controller->id, $this->controllers)) {
            throw new NotFoundHttpException('Not found');
        }

        return true;
    }
}
