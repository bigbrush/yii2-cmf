<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\ButtonDropdown;
use bigbrush\cms\widgets\DeleteButton;

$dropdown = [];
foreach ($installedBlocks as $id => $name) {
    $dropdown[] = ['label' => $name, 'url' => ['create', 'id' => $id]];
}
$toolbar = Yii::$app->toolbar;
$toolbar->addButton(ButtonDropdown::widget([
    'label' => $toolbar->createText('square', Yii::t('cms', 'New {0}', Yii::t('cms', 'block'))),
    'options' => ['class' => 'btn btn-default'],
    'encodeLabel' => false,
    'dropdown' => [
        'items' => $dropdown,
    ],
]));

$this->title = Yii::t('cms', 'Blocks');
?>
<div class="row">
    <div class="col-md-12">
        <h1><?= $this->title ?></h1>

        <div class="row">
            <div class="col-md-4">
                <?php $form = ActiveForm::begin(['layout' => 'inline', 'method' => 'get', 'action' => ['/big/block/index']]) ?>
                <?= $form->field($searchModel, 'q', ['inputOptions' => ['name' => 'q']]) ?>
                <?= Html::submitButton(Yii::t('cms', 'Search'), ['class' => 'btn btn-default']) ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'header' => Yii::t('cms', 'Title'),
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::a(Html::encode($model->title), ['edit', 'id' => $model->id]);
                        }
                    ],
                    [
                        'header' => Yii::t('cms', 'Type'),
                        'options' => ['width' => '20%'],
                        'value' => function($model) {
                            return Html::encode($model->extension->name);
                        }
                    ],
                    [
                        'header' => Yii::t('cms', 'State'),
                        'options' => ['width' => '5%'],
                        'value' => function($model) {
                            return Html::encode($model->getStateText());
                        }
                    ],
                    [
                        'header' => Yii::t('cms', 'Delete'),
                        'format' => 'raw',
                        'options' => ['width' => '1%'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                        'value' => function($model) {
                            return DeleteButton::widget([
                                'model' => $model,
                                'options' => ['class' => 'btn-xs'],
                            ]);
                        },
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
