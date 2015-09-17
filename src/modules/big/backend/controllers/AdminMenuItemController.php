<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\big\backend\controllers;

use Yii;

/**
 * AdminMenuItemController
 */
class AdminMenuItemController extends MenuItemController
{
    const ACTIVE_MENU_ID = '_cms_admin_menu_id_'; // overrides value in BaseMenuController


    /**
     * Returns the manager of this controller.
     * Overloaded to return a different manager than the default implementation.
     *
     * @return bigbrush\cms\components\AdminMenuManager the admin menu manager.
     */
    public function getManager()
    {
        return Yii::$app->cms->getAdminMenuManager();
    }
}
