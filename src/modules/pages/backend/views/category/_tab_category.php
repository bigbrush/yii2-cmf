<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use bigbrush\cms\widgets\Editor;
?>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'title', ['inputOptions' => ['class'  =>'form-control input-lg']]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'parent_id')->dropDownList($parents) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'template_id')->dropDownList($templates) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'state')->dropDownList($model->getStateOptions()) ?>
            </div>
        </div>
        
        <?= $form->field($model, 'content')->widget(Editor::className(), ['useReadMore' => false]) ?>

    </div>
</div>
