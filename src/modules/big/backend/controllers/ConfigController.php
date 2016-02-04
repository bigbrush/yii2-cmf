<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\big\backend\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\bootstrap\ActiveForm;

/**
 * ConfigController
 */
class ConfigController extends Controller
{

    /**
     * Renders configuration for the specified section.
     *
     * @param string $section name of a config section.
     */
    public function actionShow($section)
    {
        $manager = $this->getManager();
        $config = $manager->getItems($section);
        $model = $manager->getModel();
        $model->section = $config->section;
        $dataProvider = new ArrayDataProvider([
            'allModels' => $config->asArray(),
            'key' => 'id',
        ]);
        return $this->render('config', [
            'model' => $model,
            'config' => $config,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Add a new config value.
     *
     * @param string $section name of a config section.
     */
    public function actionAdd($section)
    {
        $manager = $this->getManager();
        if ($manager->save(Yii::$app->getRequest()->post())) {
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Config value added.'));
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('cms', 'Config value not added. Please try again.'));
        }
        return $this->redirect(['show', 'section' => $section]);
    }

    /**
     * Updates a config value.
     *
     * @param string $section name of a config section.
     */
    public function actionUpdate($section)
    {
        $manager = $this->getManager();
        if ($manager->save(Yii::$app->getRequest()->post())) {
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Config value updated.'));
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('cms', 'Config value not updated. Please try again.'));
        }
        return $this->redirect(['show', 'section' => $section]);
    }

    /**
     * Deletes a config value.
     *
     * @param string $section name of a config section.
     */
    public function actionDelete($section)
    {
        $manager = $this->getManager();
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($manager->delete(Yii::$app->getRequest()->post())) {
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Config value deleted.'));
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('cms', 'Config value not found and not deleted.'));
        }
        return $this->redirect(['show', 'section' => $section]);
    }

    /**
     *
     */
    public function getManager()
    {
        return Yii::$app->big->configManager;
    }
}
