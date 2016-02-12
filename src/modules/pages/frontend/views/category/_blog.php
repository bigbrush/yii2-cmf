<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use bigbrush\cms\modules\pages\components\Route;

$params = $category->params;
?>
<?php foreach ($pages as $page) : ?>
<div class="<?= $wrapperClass ?> blog-page">
    <?php
    $pageParams = $page['params'];
    // check if the category should show the intro image of each page
    // if true check if the page params has the key "images" and "intro_image"
    $showIntroImage = isset($params['show_page_intro_image']) && $params['show_page_intro_image']
        && isset($pageParams['images'], $pageParams['images']['intro_image'])
        && !empty($pageParams['images']['intro_image']['image']);
    ?>
    <?php if ($showIntroImage) : ?>
    <div class="intro-image">
        <?php
        $introImage = $pageParams['images']['intro_image'];
        $img = Html::img($introImage['image'], ['alt' => $introImage['alt']]);
        if (!empty($introImage['link'])) {
            echo Html::a($img, $introImage['link']);
        } else {
            echo $img;
        } ?>
    </div>
    <?php endif; ?>

    <h2><?= Html::a(Html::encode($page['title']), Route::page($page, '/')) ?></h2>

    <?php if ($showPageInformation) : ?>
    <div class="page-info">
        <ul>
            <?php if ($params['show_page_dates']) : ?>
            <li><?= '<i class="fa fa-pencil"></i> ' . Yii::$app->getFormatter()->asDate($page[$params['show_page_dates']]) ?></li>
            <?php endif; ?>
            <?php if (isset($params['show_page_editor_author']) && $params['show_page_editor_author']) : ?>
            <li><?= '<i class="fa fa-user"></i> ' . $page[$params['show_page_editor_author']]['name'] ?></li>
            <?php endif; ?>
        </ul>
    </div>
    <?php endif; ?>

    
    <?php if ($params['show_page_content']) : ?>
    <?= $page['intro_content'] ?>
    <?= Html::a(Yii::t('cms', 'Read more'), Route::page($page, '/'), ['class' => 'btn btn-default']) ?>
    <?php endif; ?>
</div>
<?php endforeach; ?>
