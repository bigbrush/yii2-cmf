<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $title ?></h3>
    </div>

    <div class="box-body">
        <?= $content ?>
    </div>

    <?php if ($isLoading) : ?>
    <div class="overlay">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
    <?php endif; ?>
</div>
