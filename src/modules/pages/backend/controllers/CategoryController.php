<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\pages\backend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use bigbrush\cms\base\BaseCategoryController;
use bigbrush\cms\modules\pages\widgets\Gallery;

/**
 * CategoryController
 */
class CategoryController extends BaseCategoryController
{
    /**
     * Returns an id used to load a category tree.
     * If no tree exists for the returned id one will automatically be created.
     * 
     * An example of the method body:
     * ~~~php
     * return $this->module->id;
     * ~~~
     * 
     * Please note that if the categories are used in a block the active module could be different than
     * the module of this controller. In this case you need to provide the tree id directly.
     * For instance:
     * ~~~php
     * $categories = Yii::$app->big->categoryManager->getItems('YOUR_MODULE_ID');
     * ~~~
     * 
     * @return string id of a category tree.
     */
    public function getTreeId()
    {
        return 'pages';
    }

    /**
     * @inheritdoc
     */
    public function getModel($id = 0)
    {
        $model = parent::getModel($id);
        if (!$id || !isset($model->params['images'])) {
            $params = is_array($model->params) ? $model->params : [];
            $params['images'] = [
                'images' => [],
                'config' => Gallery::getDefaultOptions(),
            ];
            $model->params = $params;
        }
        return $model;
    }
}
