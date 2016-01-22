<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;

$type = Yii::t('cms', 'category');
$title = $model->id ? Yii::t('cms', 'Edit {0}', $type) : Yii::t('cms', 'Create {0}', $type);
$this->title = $title;

if (!$model->getIsNewRecord()) {
    $title .= ' <span class="small">[ ' . $model->title . ' ]</span>';
}
?>

<?php $form = ActiveForm::begin(); ?>
    
    <?php Yii::$app->toolbar->save()->saveStay()->back(); ?>

    <h1><?= $title ?></h1>
    
    <div class="row">
        <div class="col-md-12">
            <?= Tabs::widget([
                'items' => [
                    [
                        'label' => Yii::t('cms', 'Category'),
                        'content' => $this->render('_tab_category', [
                            'form' => $form,
                            'model' => $model,
                            'parents' => $parents,
                        ]),
                    ],
                    [
                        'label' => Yii::t('cms', 'Publishing'),
                        'content' => $this->render('_tab_publishing', [
                            'form' => $form,
                            'model' => $model,
                        ]),
                    ],
                    [
                        'label' => Yii::t('cms', 'Images'),
                        'content' => $this->render('_tab_images', [
                            'form' => $form,
                            'model' => $model,
                        ]),
                    ],
                    [
                        'label' => Yii::t('cms', 'Seo'),
                        'content' => $this->render('_tab_seo', [
                            'form' => $form,
                            'model' => $model,
                        ]),
                    ],
                    [
                        'label' => Yii::t('cms', 'Info'),
                        'content' => $this->render('_tab_info', [
                            'form' => $form,
                            'model' => $model,
                        ]),
                    ],
                ],
            ]) ?>
        </div>
    </div>

<?php $form = ActiveForm::end(); ?>
