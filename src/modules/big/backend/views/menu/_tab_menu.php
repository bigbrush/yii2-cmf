<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */
?>
<div class="row">
    <div class="col-md-12">        
        <?= $form->field($model, 'title', ['inputOptions' => ['class'  =>'form-control input-lg']]) ?>
        <?= $form->field($model, 'route', [
            'template' => '
                {label}
                <div class="form-group">
                    {error}
                    <div class="input-group">
                        {input}
                        <span class="input-group-btn">
                            <button id="btn-select-content" class="btn btn-info btn-block" data-toggle="modal" data-target="#content-modal">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                </div>
                '
        ]); ?>
        <div class="row">
                <div class="col-md-6">
                <?= $form->field($model, 'menu_id')->dropDownList($menus) ?>
            </div>
            <div class="col-md-6">
                <?php if ($model->menu_id) : ?>
                <?= $form->field($model, 'parent_id')->dropDownList($parents) ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'state')->dropDownList($model->getStateOptions()) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'is_default')->dropDownList($model->getIsDefaultOptions()) ?>
            </div>
        </div>
    </div>
</div>
