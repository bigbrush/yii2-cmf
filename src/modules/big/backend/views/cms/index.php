<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use bigbrush\cms\modules\pages\models\Page;

$models = Page::find()->orderBy('updated_at')->limit(5)->asArray()->all();;
$dataProvider = new ArrayDataProvider([
    'allModels' => $models,
]);
$boxContent = '<div class="table-responsive">';
$boxContent .= GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => ['class' => 'table'],
    'showHeader' => false,
    'summary' => '',
    'columns' => [
        [
            'header' => Yii::t('cms', 'Title'),
            'format' => 'raw',
            'value' => function($data) {
                return Html::a($data['title'], ['/pages/page/edit', 'id' => $data['id']]);
            },
        ],
    ],
]);
$boxContent .= '</div>';
$boxContent .= Html::a('<i class="fa fa-plus-circle"></i> ' . Yii::t('cms', 'New page'), ['/pages/page/edit'], ['class' => 'btn btn-sm btn-primary pull-left']);
$boxContent .= Html::a('<i class="fa fa-eye"></i> ' . Yii::t('cms', 'See all'), ['/pages/page/index'], ['class' => 'btn btn-sm btn-default pull-right']);

$this->title = Yii::t('cms', 'Welcome to Big CMS');

$this->registerJs('
    $(".box").boxWidget();
');
?>
<div class="row">
    <div class="col-md-12">
        <h1><?= $this->title ?></h1>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?= $this->render('_box', [
            'title' => Yii::t('cms', 'Recently updated pages'),
            'content' => $boxContent,
            'isLoading' => false,
        ]) ?>
    </div>
</div>
