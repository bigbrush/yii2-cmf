<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\components;

use Yii;
use yii\base\Behavior;

/**
 * UrlManagerBehavior
 */
class UrlManagerBehavior extends Behavior
{
    /**
     * @var yii\web\UrlManager the url manager.
     * Used to create urls from backend to frontend.
     */
    private $_urlManager;


    /**
     * Creates an url from the backend to the frontend.
     *
     * @param string|array $params use a string to represent a route (e.g. `site/index`),
     * or an array to represent a route with query parameters (e.g. `['site/index', 'param1' => 'value1']`).
     * @return string the created URL.
     */
    public function createUrlFrontend($params)
    {
        return $this->getUrlManager()->createUrl($params);
    }

    /**
     * Creates an internal url by Big.
     * If a $dynamicUrl is true the string "index.php?r=" is prepended to the url.
     * Urls created with this method will automatically be SEO optimized by Big. Interal urls
     * are intended to be saved in the database and displayed in the frontend. Big will
     * only parse urls in the frontend.
     *
     * @param string|array $route use a string to represent a route (e.g. `site/index`),
     * or an array to represent a route with query parameters (e.g. `['site/index', 'param1' => 'value1']`).
     * @param boolean $dynamicUrl if true the url will have "index.php?r" prepended. Defaults to true.
     * @return string the internal url
     * @see parseInternalUrl()
     */
    public function createInternalUrl($route, $dynamicUrl = true)
    {
        return Yii::$app->big->urlManager->createInternalUrl($route, $dynamicUrl);
    }

    /**
     * Parses an url created by Big.
     * Use this when using [[bigbrush\big\widgets\bigsearch\BigSearch]].
     *
     * @param string $url an internal url.
     * @return array route params ready for [[yii\web\UrlManager::createUrl()]].
     */
    public function parseInternalUrl($url)
    {
        return Yii::$app->big->urlManager->parseInternalUrl($url);
    }

    /**
     * Returns the url manager.
     *
     * @return yii\web\urlManager
     */ 
    public function getUrlManager()
    {
        if ($this->_urlManager === null) {
            $config = require(Yii::getAlias('@app/common/config/web.php'));
            // create a big url manager directed at the frontend with url rules enabled
            $bigUrlManager = Yii::createObject([
                'class' => Yii::$app->big->urlManager->className(),
                'enableUrlRules' => true,
            ]);
            // register frontend modules in Big url manager
            foreach ($config['modules'] as $id => $className) {
                $bigUrlManager->registerModule($id, $className);
            }

            // create a Yii url manager directed at the frontend and register Big url manager as a rule
            $config = $config['components']['urlManager'];
            $config['class'] = isset($config['class']) ? $config['class'] : $this->owner->className();
            $config['baseUrl'] = '@web/../';
            $config['rules'] = [$bigUrlManager];
            $this->_urlManager = Yii::createObject($config);
        }
        return $this->_urlManager;
    }
}
