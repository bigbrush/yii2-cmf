<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use bigbrush\cms\widgets\DeleteButton;

$this->title = Yii::t('cms', '{module} configurations', ['module' => ucfirst($config->section)]);
?>
<div class="row">
    <div class="col-md-12">
        <h1><?= $this->title ?></h1>
    </div>
</div>
<?php $form = ActiveForm::begin(['action' => ['show', 'section' => $config->section], 'id' => 'add-config-form']); ?>
    <div class="row">
        <div class="col-sm-1">
            <?= Html::submitButton(Yii::t('cms', 'Add'), ['class' => 'btn btn-default btn-sm']); ?>
            <?= $form->field($model, 'section')->hiddenInput()->label(false) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'id', [
                'inputOptions' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('cms', 'Name')
                ]
            ])->label(false) ?>
        </div>
        <div class="col-sm-7">
            <?= $form->field($model, 'value', [
                'inputOptions' => [
                    'class' => 'form-control input-sm',
                    'placeholder' => Yii::t('cms', 'Value')
                ]
            ])->label(false) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>

<div class="row">
    <div class="col-md-12">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table'],
            'columns' => [
                [
                    'header' => Yii::t('cms', 'Name'),
                    'format' => 'raw',
                    'options' => ['style' => 'width: 20%;'],
                    'value' => function ($data) {
                        return Html::input('text', '', $data['id'], ['class' => 'form-control input-sm', 'readonly' => 'readonly']);
                    },
                ],
                [
                    'header' => Yii::t('cms', 'Value'),
                    'format' => 'raw',
                    'value' => function ($data) {
                        $icon = '<i class="fa fa-save"></i>';
                        
                        $html = Html::beginForm(['update', 'id' => $data['id'], 'section' => $data['section']]);
                        $html .= '<div class="input-group">';
                        $html .= '<span class="input-group-btn">';
                        $html .= Html::submitButton($icon, ['class' => 'btn btn-default btn-sm']);
                        $html .= '</span>';
                        $html .= Html::input('text', 'Config[value]', $data['value'], ['class' => 'form-control input-sm']);
                        $html .= '</div>';
                        $html .= Html::hiddenInput('Config[id]', $data['id']);
                        $html .= Html::hiddenInput('Config[section]', $data['section']);
                        $html .= Html::endForm();

                        return $html;
                    },
                ],
                [
                    'header' => Yii::t('cms', 'Delete'),
                    'options' => ['style' => 'width: 5%;'],
                    'format' => 'raw',
                    'value' => function ($data) {
                        $fields = [];
                        $fields[] = Html::submitButton('<i class="fa fa-check"></i>', ['class' => 'btn btn-success']);
                        $fields[] = Html::hiddenInput('Config[id]', $data['id']);
                        $fields[] = Html::hiddenInput('Config[value]', $data['value']);
                        $fields[] = Html::hiddenInput('Config[section]', $data['section']);
                        return DeleteButton::widget([
                            'action' => ['delete', 'id' => $data['id'], 'section' => $data['section']],
                            'content' => implode("\n", $fields),
                            'options' => [
                                'class' => 'btn btn-default btn-sm',
                            ]
                        ]);
                    },
                ],
            ],
        ]) ?>
    </div>
</div>
