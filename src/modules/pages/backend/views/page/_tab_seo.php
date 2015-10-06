<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */
?>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'params[show_title]')->dropDownList([Yii::t('cms', 'No'), Yii::t('cms', 'Yes')])->label(Yii::t('cms', 'Show page title')) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'meta_title') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'alias') ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'meta_description')->textArea() ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'meta_keywords')->textArea() ?>
    </div>
</div>
