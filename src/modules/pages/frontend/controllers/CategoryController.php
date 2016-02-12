<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\pages\frontend\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use bigbrush\cms\modules\pages\models\Page;

/**
 * CategoryController
 */
class CategoryController extends Controller
{
    /**
     * Shows pages from a single category.
     *
     * @param int $catid id of a category to load pages from.
     * @return string the rendering result.
     */
    public function actionPages($catid)
    {
        $category = Yii::$app->big->categoryManager->getItem($catid);
        if (!$category) {
            throw new NotFoundHttpException(Yii::t('cms', 'Category not found.'));
        }
        Yii::$app->big->setTemplate($category->template_id);
        $pages = Page::find()->with(['author', 'editor'])
            ->byCategory($catid)
            ->byState(Page::STATE_ACTIVE)
            ->orderBy('created_at')
            ->asArray()
            ->all();
        foreach ($pages as &$page) {
            $page['params'] = Json::decode($page['params']);
        }
        return $this->render('pages', [
            'category' => $category,
            'pages' => $pages,
        ]);
    }
}
