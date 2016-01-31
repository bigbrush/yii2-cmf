<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms;

use Yii;
use yii\base\Object;
use yii\base\BootstrapInterface;
use yii\helpers\Url;
use bigbrush\cms\components\UrlManagerBehavior;

/**
 * Cms
 */
class Cms extends Object implements BootstrapInterface
{
    /**
     * scopes
     */
    const SCOPE_FRONTEND = 'frontend';
    const SCOPE_BACKEND = 'backend';
    /**
     * version
     */
    const VERSION = '0.0.4';

    /**
     * @var string the application scope.
     * Used to set correct base url for the editor and file manager in [[bootstrap()]] method.
     * Defaults to [[SCOPE_FRONTEND]].
     */
    private $_scope;

    private $_adminMenuManger;


    /**
     * Bootstraps the Cms component.
     * This method sets up Big Frameword by setting various properties. These properties can be
     * overridden when using the classes.
     * This method runs after the application has been configured.
     *
     * @param yii\base\Application $app the application currently running.
     */
    public function bootstrap($app)
    {        
        // register a default scope if not set
        if ($this->_scope === null) {
            $this->setScope(static::SCOPE_FRONTEND);
        }

        // enable translations
        $config = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@bigbrush/cms/messages',
        ];
        Yii::$app->i18n->translations['cms*'] = $config;
        // override translations registered by Big
        Yii::$app->big->registerTranslations($config);

        // attach behavior to the application url manager
        // Yii::$app->getUrlManager()->attachBehavior('cmsUrlManagerBehavior', UrlManagerBehavior::className());

        // set a default folder for plugins in the Cms
        Yii::$container->set('bigbrush\big\core\PluginManager', [
            'pluginsFolder' => '@bigbrush/cms/plugins',
        ]);

        // if scope is "backend" set default base url in editor and file manager
        if ($this->getIsBackend()) {
            $baseUrl = Url::to('@web/../');
            Yii::$container->set('bigbrush\cms\widgets\Editor', [
                'baseUrl' => $baseUrl,
            ]);
            Yii::$container->set('bigbrush\big\widgets\filemanager\FileManager', [
                'baseUrl' => $baseUrl,
            ]);
        }

        // activate system plugins
        $app->big->pluginManager->activateGroup('system');
    }

    /**
     * Returns the manager for the admin menu.
     *
     * @return bigbrush\cms\components\AdminMenuManager the admin menu manager.
     */
    public function getAdminMenuManager()
    {
        if ($this->_adminMenuManger === null) {
            $this->_adminMenuManger = Yii::createObject(['class' => 'bigbrush\cms\components\AdminMenuManager']);
        }
        return $this->_adminMenuManger;
    }

    /**
     * Sets the application scope.
     *
     * @return mixed the application scope.
     * @throws InvalidCallException if scope is set after application has been configured.
     */
    public function setScope($scope)
    {
        if ($this->_scope !== null) {
            throw new InvalidCallException("Scope can only be set through application configuration.");
        }
        $this->_scope = $scope;
    }

    /**
     * Returns the application scope.
     *
     * @return mixed the application scope.
     */
    public function getScope()
    {
        return $this->_scope;
    }

    /**
     * Returns a boolean indicating whether the current scope is frontend.
     *
     * @return boolean true if current scope is frontend false if not.
     */
    public function getIsFrontend()
    {
        return $this->getScope() === static::SCOPE_FRONTEND;
    }

    /**
     * Returns a boolean indicating whether the current scope is backend.
     *
     * @return boolean true if current scope is backend false if not.
     */
    public function getIsBackend()
    {
        return $this->getScope() === static::SCOPE_BACKEND;
    }

    /**
     * Returns an array of available scopes in the Cms. The keys are scope ids and the values are translated names of each scope.
     *
     * @return array list of avaiable scopes.
     */
    public function getAvailableScopes()
    {
        return [
            static::SCOPE_FRONTEND => Yii::t('cms', 'Frontend'),
            static::SCOPE_BACKEND => Yii::t('cms', 'Backend'),
        ];
    }

    /**
     * Returns the current version of Big CMS.
     *
     * @return string the current version of Big CMS.
     */
    public function getVersion()
    {
        return self::VERSION;
    }
}