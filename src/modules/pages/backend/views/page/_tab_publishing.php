<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <?= $form->field($model, 'params[show_intro_content]')->dropDownList([Yii::t('cms', 'No'), Yii::t('cms', 'Yes')])->label(Yii::t('cms', 'Show page intro')) ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'params[show_intro_image]')->dropDownList([
                            Yii::t('cms', 'No'),
                            Yii::t('cms', 'Yes'),
                        ])->label(Yii::t('cms', 'Show intro image')) ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'params[show_dates]')->dropDownList([
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
                </div>
            </div>
        </div>
    </div>
</div>
