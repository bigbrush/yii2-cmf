<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */
?>
<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'params[show_title]')->dropDownList([Yii::t('cms', 'No'), Yii::t('cms', 'Yes')])->label(Yii::t('cms', 'Show title')) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'params[show_content]')->dropDownList([Yii::t('cms', 'No'), Yii::t('cms', 'Yes')])->label(Yii::t('cms', 'Show content')) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'params[show_date]')->dropDownList([
            0 => Yii::t('cms', 'No'),
            'created_at' => Yii::t('cms', 'Created'),
            'updated_at' => Yii::t('cms', 'Updated'),
        ])->label(Yii::t('cms', 'Show date')) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
	    <?= $form->field($model, 'params[items_in_row]')->dropDownList([
	        1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            6 => 6,
	    ])->label(Yii::t('cms', 'Categories pr row')) ?>
    </div>
</div>
