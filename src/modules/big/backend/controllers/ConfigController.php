<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\big\backend\controllers;

use Yii;
use bigbrush\cms\base\BaseConfigController;

/**
 * ConfigController
 */
class ConfigController extends BaseConfigController
{
    /**
     * Returns the config manager used in this controller. This method enables subclasses to setup
     * the config manager before rendering.
     *
     * @return bigbrush\big\core\ConfigManager a config manager.
     */
    public function getManager()
    {
        $manager = Yii::$app->big->configManager;
        $manager->configureSection('cms', [
            'lockedFields' => ['appName', 'systemEmail'],
            'changeLockedFields' => true,
        ]);
        return $manager;
    }
}
