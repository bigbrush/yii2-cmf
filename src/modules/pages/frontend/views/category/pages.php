<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use bigbrush\cms\modules\pages\components\Route;

$params = $category->params;
$chunks = array_chunk($pages, $params['items_in_row']);
$class = 'col-md-' . 12 / $params['items_in_row'];
$dateDisplayed = $params['show_date'] ? $params['show_date'] : false;
?>
<?php if ($category->params['show_title']) : ?>
	<h1><?= $category->title ?></h1>
<?php endif; ?>

<?php foreach ($chunks as $pages) : ?>
<div class="row">
    <?php foreach ($pages as $page) : ?>
    <div class="<?= $class ?>">
        <?php if ($dateDisplayed) : ?>
        <div class="page-date">
            <?= Yii::$app->getFormatter()->asDate($page->$dateDisplayed) ?>
        </div>
        <?php endif; ?>

        <?= Html::a(Html::encode($page->title), Route::page($page, '/')) ?>
        
        <?php if ($category->params['show_content']) : ?>
        <?= $page->content ?>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>
<?php endforeach; ?>
