<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\bootstrap\Tabs;
use bigbrush\big\widgets\bigsearch\BigSearch;

$this->registerJs('$("#btn-select-content").click(function(e){
    e.preventDefault();
});');

$type = Yii::t('cms', 'menu item');
$title = $model->id ? Yii::t('cms', 'Edit {0}', $type) : Yii::t('cms', 'Create {0}', $type);
$this->title = $title;
?>
<?php $form = ActiveForm::begin(); ?>
    <?php Yii::$app->toolbar->save()->saveStay()->back(); ?>

    <div class="row">
        <div class="col-md-12">

            <h1><?= $title ?></h1>

            <?= Tabs::widget([
                'items' => [
                    [
                        'label' => Yii::t('cms', 'Menu'),
                        'content' => $this->render('_tab_menu', [
                            'model' => $model,
                            'menus' => $menus,
                            'parents' => $parents,
                            'form' => $form,
                        ]),
                    ],
                    [
                        'label' => Yii::t('cms', 'Seo'),
                        'content' => $this->render('_tab_seo', [
                            'model' => $model,
                            'form' => $form,
                        ]),
                    ],
                ],
            ]) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>

<?php
Modal::begin([
    'header' => '<h4>' . Yii::t('cms', 'Select content') . '</h4>',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">' . Yii::t('cms', 'Close') . '</button>',
    'id' => 'content-modal',
    'size' => Modal::SIZE_LARGE,
]); ?>

<?= BigSearch::widget([
    'onClickCallback' => 'function(e){
        e.preventDefault();
        var route = $(this).data("route");
        $("#content-modal").on("hidden.bs.modal", function(){
            $("#menu-route").val(route);
        }).modal("hide");
    }',
    /**
     * TODO
     * implement linking to files from menus.
     */
    // 'fileManager' => [
    //     'onClickCallback' => 'function(file){
    //         var baseUrl = "' . Url::to('@web/../') . '";
    //         var url = file.url.slice(baseUrl.length);
    //         $("#content-modal").on("hidden.bs.modal", function(){
    //             $("#menu-route").val(url);
    //         }).modal("hide");
    //     }',
    // ],
]); ?>

<?php Modal::end(); ?>