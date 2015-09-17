<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

/**
 * Render the view used by menu controller
 */
echo $this->render('@bigbrush/cms/modules/big/backend/views/menu/index.php', [
    'dataProvider' => $dataProvider,
]);

/**
 * Add another toolbar icon
 */
Yii::$app->toolbar->add(Yii::t('cms', 'Menu items'), ['admin-menu-item/index'], 'tree');
?>
