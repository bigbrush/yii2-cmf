<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */
?>
<div class="row">
    <div class="col-md-12">
        <h3><?= Yii::t('cms', 'Category') ?></h3>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'params[show_category_title]')->dropDownList([Yii::t('cms', 'No'), Yii::t('cms', 'Yes')])->label(Yii::t('cms', 'Show category title')) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'params[show_category_content]')->dropDownList([Yii::t('cms', 'No'), Yii::t('cms', 'Yes')])->label(Yii::t('cms', 'Show category content')) ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3><?= Yii::t('cms', 'Pages') ?></h3>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'params[pages_pr_row]')->dropDownList([
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    6 => 6,
                ])->label(Yii::t('cms', 'Pages pr row')) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'params[show_page_dates]')->dropDownList([
                    0 => Yii::t('cms', 'No'),
                    'created_at' => Yii::t('cms', 'Created'),
                    'updated_at' => Yii::t('cms', 'Updated'),
                ])->label(Yii::t('cms', 'Show page date')) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'params[show_page_content]')->dropDownList([Yii::t('cms', 'No'), Yii::t('cms', 'Yes')])->label(Yii::t('cms', 'Show page content')) ?>
            </div>
        </div>
    </div>
</div>
