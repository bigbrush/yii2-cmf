<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

/* @var $this yii\web\View */
/* @var $model big\models\Block */
?>
<div class="block text">
    <?php if ($block->showTitle) : ?>
    <h3><?= $block->title ?></h3>
    <?php endif; ?>
    <?= $block->content ?>
</div>