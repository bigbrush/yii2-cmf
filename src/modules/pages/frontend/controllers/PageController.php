<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\pages\frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use bigbrush\cms\modules\pages\models\Page;

/**
 * PageController
 */
class PageController extends Controller
{    
    /**
     * Shows a single page.
     *
     * @param string $alias a page alias (slug).
     * @return string the rendering result of this action.
     * @throws InvalidParamException if a model with the provided id is not found. 
     */
    public function actionShow($alias)
    {
        $model = Page::find()->where(['alias' => $alias])->byState(Page::STATE_ACTIVE)->one();
        if (!$model) {
            throw new NotFoundHttpException(Yii::t('cms', 'Page not found.'));
        }
        Yii::$app->big->setTemplate($model->template_id);
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}