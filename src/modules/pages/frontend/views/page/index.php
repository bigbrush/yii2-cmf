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
            <?= $model->content ?>
        </div>
    </div>
</div>
