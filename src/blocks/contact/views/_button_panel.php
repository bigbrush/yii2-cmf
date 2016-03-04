<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use bigbrush\cms\widgets\RadioButtonGroup;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <strong><?= ucfirst($header) ?></strong>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <?= $form->field($model, 'fields')->widget(RadioButtonGroup::className(), [
                    'name' => 'Block[fields][' . $field . '][show]',
                    'value' => $model->getField($field, 'show'),
                ])->label(Yii::t('cms', 'Show')) ?>
            </div>

            <div class="col-md-5 col-md-offset-1">
                <?= $form->field($model, 'fields')->widget(RadioButtonGroup::className(), [
                    'name' => 'Block[fields][' . $field . '][required]',
                    'value' => $model->getField($field, 'required'),
                ])->label(Yii::t('cms', 'Required')) ?>
            </div>
        </div>
    </div>
</div>
