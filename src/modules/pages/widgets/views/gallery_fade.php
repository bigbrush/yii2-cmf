<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
?>
<div id="gallery-wrap">
    <?php foreach ($images as $image) : ?>
    
    <?php if (empty($image['image'])) {
        continue;
    } ?>

    <div class="gallery-img">
        <?php
        $img = Html::img($image['image'], ['alt' => $image['alt'], 'class' => 'img-responsive']);
        if (empty($image['link'])) {
            echo $img;
        } else {
            echo Html::a($img, $image['link']);
        }
        ?>
    </div>
    <?php endforeach; ?>
</div>
