<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;
use bigbrush\cms\modules\pages\components\Route;

$type = Yii::t('cms', 'page');
$title = $model->id ? Yii::t('cms', 'Edit {0}', $type) : Yii::t('cms', 'Create {0}', $type);
$this->title = $title;

$url = Yii::$app->getUrlManager()->createUrlFrontend(Route::page($model, '/'));
$toolbar = Yii::$app->toolbar;
$toolbarBtn = Html::a($toolbar->createText('eye', Yii::t('cms', 'Go to page')), $url, $toolbar->createButtonOptions(['target' => '_blank']));
?>

<?php
$form = ActiveForm::begin();

$toolbar->save()->saveStay()->back()->addButton($toolbarBtn);

$items = [
    [
        'label' => Yii::t('cms', 'Page'),
        'content' => $this->render('_tab_page', [
            'model' => $model,
            'form' => $form,
            'categories' => $categories,
            'templates' => $templates
        ]),
    ],
    [
        'label' => Yii::t('cms', 'Seo'),
        'content' => $this->render('_tab_seo', [
            'model' => $model,
            'form' => $form
        ]),
    ],
    [
        'label' => Yii::t('cms', 'Images'),
        'content' => $this->render('_tab_images', [
            'model' => $model,
            'form' => $form
        ]),
    ],
];
if ($model->getIsNewRecord() === false) {
    $items[] = [
        'label' => Yii::t('cms', 'Info'),
        'content' => $this->render('_tab_info', [
            'model' => $model,
            'form' => $form
        ]),
    ];

    $title .= ' <span class="small">[ ' . $model->title . ' ]</span>';
}
?>
    <h1><?= $title ?></h1>
    
    <div class="row">
        <div class="col-md-12">
            <?= Tabs::widget([
                'items' => $items,
            ]) ?>
        </div>
    </div>

<?php $form = ActiveForm::end(); ?>
