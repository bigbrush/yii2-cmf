<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\base;

use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

/**
 * BaseConfigController provides basic functionality for modules implementing configurations
 * based on [[bigbrush\big\core\ConfigManager]].
 */
abstract class BaseConfigController extends Controller
{
    /**
     * @var string $viewFile defines the view file used when rendering configurations.
     * Defaults to the view of "big" module.
     */
    protected $viewFile = '@bigbrush/cms/modules/big/backend/views/config/config.php';


    /**
     * Returns the config manager used in this controller. This method enables subclasses to setup
     * the config manager before rendering.
     *
     * @return bigbrush\big\core\ConfigManager a config manager.
     */
    abstract public function getManager();

    /**
     * Renders a list of configurations for the specified section.
     *
     * @param string $section name of a config section.
     */
    public function actionShow($section)
    {
        $manager = $this->getManager();
        $model = $manager->getModel();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Config value updated.'));
            return $this->redirect(['show', 'section' => $section]);
        }
        $config = $manager->getItems($section);
        $model->section = $config->section;
        $dataProvider = new ArrayDataProvider([
            'allModels' => $config->asArray(),
            'key' => 'id',
        ]);
        return $this->render($this->viewFile, [
            'model' => $model,
            'config' => $config,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates a config value.
     *
     * @param string $section name of a config section.
     */
    public function actionUpdate($id, $section)
    {
        $model = $this->getManager()->getModel([$id, $section]);
        if ($model) {
            if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Config value updated.'));
            } else {
                Yii::$app->getSession()->setFlash('info', $model->getFirstError('id'));
            }
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('cms', 'Config value not found. Please try again.'));
        }
        return $this->redirect(['show', 'section' => $section]);
    }

    /**
     * Deletes a config value.
     *
     * @param string $section name of a config section.
     */
    public function actionDelete($id, $section)
    {
        $model = $this->getManager()->getModel([$id, $section]);
        if ($model && $model->delete()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'Config value deleted.'));
        } else {
            Yii::$app->getSession()->setFlash('info', $model->getFirstError('id'));
        }
        return $this->redirect(['show', 'section' => $section]);
    }
}
