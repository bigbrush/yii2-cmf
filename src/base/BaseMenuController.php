<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\base;

use Yii;
use yii\base\InvalidCallException;
use yii\web\Controller;

/**
 * BaseMenuController provides a default implementation used by menu related controllers.
 * 
 * It does 2 things:
 *    - saves an id of the currently viewed menu
 *    - provides a manager used by menu related controllers
 */
abstract class BaseMenuController extends Controller
{
    const ACTIVE_MENU_ID = '_cms_menu_id_';


    /**
     * Returns the manager of this controller.
     *
     * @return bigbrush\big\core\MenuManager the manager used in controller.
     */
    public function getManager()
    {
        return Yii::$app->big->menuManager;
    }

    /**
     * Returns an id of the active menu.
     *
     * @return string a numerical id of the active menu as a string.
     */
    public function getActiveMenuId()
    {
        $id = Yii::$app->getSession()->get(static::ACTIVE_MENU_ID, false);
        if ($id) {
            return $id;
        }

        $menus = $this->getManager()->getMenus();
        if (!empty($menus)) {
            $id = array_keys($menus)[0];
            $this->setActiveMenuId($id);
            return $id;
        } else {
            return '0';
        }
    }

    /**
     * Registers an id of the active menu.
     *
     * @param string $id an id of the active menu.
     */
    public function setActiveMenuId($id)
    {
        Yii::$app->getSession()->set(static::ACTIVE_MENU_ID, $id);
    }
}
