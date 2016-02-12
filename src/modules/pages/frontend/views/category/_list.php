<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use bigbrush\cms\modules\pages\components\Route;

$list = [];
foreach ($pages as $page) {
    $list[] = Html::a($page['title'], Route::page($page, '/'));
}
?>
<?= Html::ul($list, ['encode' => false]); ?>
