<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use bigbrush\cms\widgets\Editor;
?>
<div class="row">
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'title', ['inputOptions' => ['class'  =>'form-control input-lg']]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'parent_id')->dropDownList($parents) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'state')->dropDownList($model->getStateOptions()) ?>
            </div>
        </div>
        
        <?= $form->field($model, 'content')->widget(Editor::className()) ?>

    </div>
    <div class="col-md-3">
        <h3><?= Yii::t('cms', 'Category SEO') ?></h3>
        <?= $form->field($model, 'meta_title') ?>
        <?= $form->field($model, 'meta_description')->textArea() ?>
        <?= $form->field($model, 'alias') ?>
        <?= $form->field($model, 'meta_keywords') ?>
    </div>
</div>