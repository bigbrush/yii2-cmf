<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use bigbrush\cms\modules\pages\widgets\Gallery;

$this->title = (!empty($model->meta_title) ? $model->meta_title : $model->title);
$this->registerMetaTag(['name' => 'description', 'content' => $model->meta_description]);
if (!empty($model->meta_keywords)) {
    $this->registerMetaTag(['name' => 'keywords', 'content' => $model->meta_keywords]);
}

// setup page
$params = $model->params;
$showPageInformation = (isset($params['show_dates']) && $params['show_dates']) || (isset($params['show_editor_author']) && $params['show_editor_author']);

$images = $model->images;

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

<div class="row">
    <div class="col-md-12">
        <div id="content-wrap">
            <?php if ($model->params['show_title']) : ?>
            <h1><?= Html::encode($model->title) ?></h1>
            <?php endif; ?>

            <?php if ($showPageInformation) : ?>
            <div class="page-info">
                <ul>
                    <?php if ($params['show_dates']) : ?>
                    <li><?= '<i class="fa fa-pencil"></i> ' . Yii::$app->getFormatter()->asDate($model[$params['show_dates']]) ?></li>
                    <?php endif; ?>
                    <?php if (isset($params['show_editor_author']) && $params['show_editor_author']) : ?>
                    <li><?= '<i class="fa fa-user"></i> ' . $model[$params['show_editor_author']]['name'] ?></li>
                    <?php endif; ?>
                </ul>
            </div>
            <?php endif; ?>

            <?php if (isset($model->params['show_intro_content']) && $model->params['show_intro_content']) : ?>
            <?= $model->intro_content ?>
            <?php endif; ?>

            <?= $model->content ?>
        </div>
    </div>
</div>
