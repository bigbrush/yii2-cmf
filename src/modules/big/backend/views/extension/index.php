<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use bigbrush\cms\widgets\DeleteButton;

$dropdown = [];
foreach ($types as $type => $name) {
    $dropdown[] = ['label' => $name, 'url' => ['install', 'type' => $type]];
}
$toolbar = Yii::$app->toolbar;
$toolbar->addButton(ButtonDropdown::widget([
    'label' => $toolbar->createText('plug', Yii::t('cms', 'Install {0}', Yii::t('cms', 'extension'))),
    'options' => ['class' => 'btn btn-default'],
    'encodeLabel' => false,
    'dropdown' => [
        'items' => $dropdown,
    ],
]));

$this->title = Yii::t('cms', 'Extensions');
?>
<div class="row">
    <div class="col-md-12">
        <h1><?= $this->title ?></h1>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'header' => Yii::t('cms', 'Name'),
                        'format' => 'raw',
                        'value' => function($data) {
                            return Html::a($data->name, ['edit', 'id' => $data->id]);
                        }
                    ],
                    [
                        'header' => Yii::t('cms', 'Type'),
                        'options' => ['width' => '15%'],
                        'value' => function($data) {
                            return Html::encode($data->getTypeText());
                        }
                    ],
                    [
                        'header' => Yii::t('cms', 'State'),
                        'options' => ['width' => '5%'],
                        'value' => function($data) {
                            return Html::encode($data->getStateText());
                        }
                    ],
                    [
                        'header' => Yii::t('cms', 'Delete'),
                        'format' => 'raw',
                        'options' => ['width' => '5%'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                        'value' => function($data) {
                            $popover = [];
                            $popover[] = '<div style="text-align: center;">';
                            $popover[] = '<p>' . Yii::t('cms', 'Are you sure to delete this extension?') . '</p>';
                            $popover[] = '<p><strong>' . Yii::t('cms', 'All related {type} are removed as well!', ['type' => Yii::t('cms', 'blocks')]) . '</strong></p>';
                            $popover[] = Html::submitButton('<i class="fa fa-check"></i>', [
                                'class' => 'btn btn-success',
                            ]);
                            $popover[] = Html::hiddenInput('id', $data->id);
                            $popover[] = '</div>';
                            return DeleteButton::widget([
                                'model' => $data,
                                'options' => ['class' => 'btn-xs'],
                                'content' => implode("\n", $popover),
                            ]);
                        },
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>