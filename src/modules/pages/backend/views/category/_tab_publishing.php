<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

$categoryTypes = [
    'blog' => Yii::t('cms', 'Blog'),
    'list' => Yii::t('cms', 'List')
];
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><?= Yii::t('cms', 'Category') ?></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <?= $form->field($model, 'params[category_type]')->dropDownList($categoryTypes)->label(Yii::t('cms', 'Category type')) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, 'params[show_category_title]')->dropDownList([Yii::t('cms', 'No'), Yii::t('cms', 'Yes')])->label(Yii::t('cms', 'Show category title')) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, 'params[show_category_content]')->dropDownList([Yii::t('cms', 'No'), Yii::t('cms', 'Yes')])->label(Yii::t('cms', 'Show category content')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><?= Yii::t('cms', 'Pages') ?></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <?= $form->field($model, 'params[pages_shown]')->label(Yii::t('cms', 'Pages shown')) ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'params[pages_pr_row]')->dropDownList([
                            1 => 1,
                            2 => 2,
                            3 => 3,
                            4 => 4,
                            6 => 6,
                        ])->label(Yii::t('cms', 'Pages pr row')) ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'params[show_page_intro_image]')->dropDownList([
                            Yii::t('cms', 'No'),
                            Yii::t('cms', 'Yes'),
                        ])->label(Yii::t('cms', 'Show intro image')) ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'params[show_page_content]')->dropDownList([
                            // 2 => Yii::t('cms', 'Use page setting'),
                            0 => Yii::t('cms', 'No'),
                            1 => Yii::t('cms', 'Yes'),
                        ])->label(Yii::t('cms', 'Show intro content')) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <?= $form->field($model, 'params[show_page_dates]')->dropDownList([
                            0 => Yii::t('cms', 'No'),
                            'created_at' => Yii::t('cms', 'Created'),
                            'updated_at' => Yii::t('cms', 'Updated'),
                        ])->label(Yii::t('cms', 'Show date')) ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'params[show_page_editor_author]')->dropDownList([
                            0 => Yii::t('cms', 'No'),
                            'author' => Yii::t('cms', 'Author'),
                            'editor' => Yii::t('cms', 'Editor'),
                        ])->label(Yii::t('cms', 'Show author/editor')) ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'params[sort_by]')->dropDownList([
                            'title' => Yii::t('cms', 'Title'),
                            'id' => Yii::t('cms', 'Id'),
                            'created_at' => Yii::t('cms', 'Created date'),
                            'updated_at' => Yii::t('cms', 'Updated date'),
                        ])->label(Yii::t('cms', 'Sort by')) ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'params[sort_direction]')->dropDownList([
                            'ASC' => Yii::t('cms', 'Ascending'),
                            'DESC' => Yii::t('cms', 'Descending'),
                        ])->label(Yii::t('cms', 'Sort direction')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
