<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\big\backend\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use bigbrush\big\models\Menu;
use bigbrush\cms\base\BaseMenuController;

/**
 * MenuController
 */
class MenuController extends BaseMenuController
{
    /**
     * Show a list of all menus.
     *
     * @return string the rendering result.
     */
    public function actionIndex($id = 0)
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => $this->getManager()->getMenus(),
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates and edits menus
     *
     * @param int $id optional id of a model to load. If id is not
     * provided a new record is created.
     * @return string
     */
    public function actionEdit($id = 0)
    {
        $model = $this->getManager()->getModel($id);
        $model->setScenario(Menu::SCENARIO_MENU);
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
        	if ($model->getIsNewRecord()) {
        	    $model->makeRoot(false);
        	} else {
        	    $model->save(false);
        	}
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Menu saved.'));
            if (Yii::$app->toolbar->stayAfterSave()) {
                return $this->redirect(['edit', 'id' => $model->id]);
            } else {
                return $this->redirect(['index']);
            }
        }
        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes a menu.
     * TAKE CARE - All menu items will be deleted as well.
     *
     * @param int $id an id of a menu.
     */
    public function actionDelete($id)
    {
        $menuId = Yii::$app->getRequest()->post('id');
        if ($menuId != $id) {
            throw new InvalidCallException("Invalid form submitted. Menu with id: '$id' not deleted.");
        }
        $model = $this->getManager()->getModel($id);
        if ($model) {
            if ($model->deleteWithChildren()) {
                // remove the active menu from session if the currently active is the deleted one.
                if ($this->getActiveMenuId() == $id) {
                    $this->setActiveMenuId(null);
                }
                Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Menu deleted.'));
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('cms', 'Menu could not be deleted.'));
            }
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('cms', 'Menu with id "{id}" not found.', [
                'id' => $id
            ]));
        }
        return $this->redirect(['index']);
    }
}
