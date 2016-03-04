<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\grid\GridView;
use bigbrush\cms\widgets\DeleteButton;

Yii::$app->toolbar->add();

$this->title = Yii::t('cms', 'Menus');
?>
<div class="row">
    <div class="col-md-12">
        <h1><?= $this->title ?></h1>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'header' => Yii::t('cms', 'Title'),
                        'format' => 'raw',
                        'value' => function($data) {
                            return Html::a($data->title, ['edit', 'id' => $data->id]);
                        },
                    ],
                    [
                        'header' => Yii::t('cms', 'Delete'),
                        'format' => 'raw',
                        'options' => ['width' => '1%'],
                        'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                        'value' => function($data) {
                            $popover = [];
                            $popover[] = '<p>' . Yii::t('cms', 'Are you sure to delete this menu?') . '</p>';
                            $popover[] = '<p><strong>' . Yii::t('cms', 'All menu items are removed as well!') . '</strong></p>';
                            return DeleteButton::widget([
                                'model' => $data,
                                'options' => ['class' => 'btn-xs'],
                                'title' => '<div style="text-align: center;"><strong>' . Yii::t('cms', 'Are you sure?')  . '</strong></div>',
                                'content' => implode("\n", $popover),
                            ]);
                        },
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
