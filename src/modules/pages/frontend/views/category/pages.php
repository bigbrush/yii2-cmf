<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use bigbrush\cms\modules\pages\widgets\Gallery;

// handle meta data
$this->title = (!empty($category->meta_title) ? $category->meta_title : $category->title);
$this->registerMetaTag(['name' => 'description', 'content' => $category->meta_description]);
if (!empty($category->meta_keywords)) {
    $this->registerMetaTag(['name' => 'keywords', 'content' => $category->meta_keywords]);
}

// setup list of pages
$params = $category->params;
$chunks = array_chunk($pages, $params['pages_pr_row']);
$class = 'col-md-' . 12 / $params['pages_pr_row'];
$showPageInformation = $params['show_page_dates'] || (isset($params['show_page_editor_author']) && $params['show_page_editor_author']);

// determine which type of view to render
$viewType = '_';
$viewType .= isset($params['category_type']) ? $params['category_type'] : 'blog';
$viewType .= '.php';

// prepare images for the gallery
$images = isset($params['images']) ? $params['images'] : [];
$options = [];
if (isset($images['config'])) {
    $options = $images['config'];
    unset($images['config']);
}
?>

<?= Gallery::widget([
    'images' => $images,
    'options' => $options,
]) ?>

<?php if ($category->params['show_category_title']) : ?>
    <h1><?= $category->title ?></h1>
<?php endif; ?>

<?php if ($category->params['show_category_content']) : ?>
	<?= $category->content ?>
<?php endif; ?>

<?php foreach ($chunks as $pages) : ?>
<div class="row">
    <?= $this->render($viewType, [
        'wrapperClass' => $class,
        'category' => $category,
        'pages' => $pages,
        'showPageInformation' => $showPageInformation,
    ]) ?>
</div>
<?php endforeach; ?>
