<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\bootstrap\Modal;
use bigbrush\big\widgets\filemanager\FileManager;
use bigbrush\big\widgets\bigsearch\BigSearch;
use bigbrush\cms\modules\pages\widgets\Gallery;

// prevent form submission when modal buttons are clicked
$this->registerJs('
    $(".image-modal-btn").click(function(e){
        e.preventDefault();
    });
    $(".url-modal-btn").click(function(e){
        e.preventDefault();
    });

    var curImage;
    var curLink;
    $("document").ready(function(){
        $(".image-modal-btn").click(function(){
            curImage = $(this).data("image");;
            $("#image-modal").modal();
        });
        $(".url-modal-btn").click(function(){
            curLink = $(this).data("image");;
            $("#url-modal").modal();
        });
    });
');

$panels = [];
for ($i = 0; $i < 6; $i++) {
    $html = $form->field($model, 'images[' . $i . '][image]', [
        'template' => '
            {label}
            <div class="form-group">
                {error}
                <div class="input-group">
                    {input}
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-block image-modal-btn" data-toggle="modal" data-image="page-images-' . $i . '-image">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </div>
            '
    ])->label(Yii::t('cms', 'Image') . ' ' . ($i + 1));

    $html .= $form->field($model, 'images[' . $i . '][alt]')->label(Yii::t('cms', 'Alt'));

    $html .= $form->field($model, 'images[' . $i . '][link]', [
            'template' => '
            {label}
            <div class="form-group">
                {error}
                <div class="input-group">
                    {input}
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-block url-modal-btn" data-toggle="modal" data-image="page-images-' . $i . '-link">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </div>
            '
    ])->label(Yii::t('cms', 'Link'));

    $panels[] = $html;
}

$chunks = array_chunk($panels, 2);
?>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'images[intro_image][image]', [
                    'template' => '
                        {label}
                        <div class="form-group">
                            {error}
                            <div class="input-group">
                                {input}
                                <span class="input-group-btn">
                                    <button class="btn btn-info btn-block image-modal-btn" data-toggle="modal" data-image="page-images-intro_image-image">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                        '
                ])->label(Yii::t('cms', 'Intro image')); ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'images[intro_image][alt]', [
                    'template' => "{label}\n{error}\n{input}\n{hint}",
                ])->label(Yii::t('cms', 'Alt')); ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'images[intro_image][link]', [
                        'template' => '
                        {label}
                        <div class="form-group">
                            {error}
                            <div class="input-group">
                                {input}
                                <span class="input-group-btn">
                                    <button class="btn btn-info btn-block url-modal-btn" data-toggle="modal" data-image="page-images-intro_image-link">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                        '
                ])->label(Yii::t('cms', 'Link')); ?>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'images[config][type]')
                    ->dropDownList(Gallery::getGalleryTypes())
                    ->label(Yii::t('cms', 'Gallery type')) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'images[config][enableJs]')
                    ->dropDownList([1 => Yii::t('cms', 'Yes'), 0 => Yii::t('cms', 'No')])
                    ->label(Yii::t('cms', 'Enable javascript')) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'images[config][enableCss]')
                    ->dropDownList([1 => Yii::t('cms', 'Yes'), 0 => Yii::t('cms', 'No')])
                    ->label(Yii::t('cms', 'Enable CSS')) ?>
            </div>
        </div>
    </div>
</div>

<?php foreach ($chunks as $items) : ?>
<div class="row">
    <?php foreach ($items as $item) : ?>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= $item ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endforeach; ?>

<?php
Modal::begin([
    'header' => '<h4>' . Yii::t('cms', 'Select image') . '</h4>',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">' . Yii::t('cms', 'Close') . '</button>',
    'id' => 'image-modal',
    'size' => Modal::SIZE_LARGE,
]); ?>

<?= FileManager::widget([
    'onClickCallback' => 'function(file){
        $("#image-modal").on("hidden.bs.modal", function(){
            $("#" + curImage).val(file.url);
        }).modal("hide");
    }'
]); ?>

<?php Modal::end(); ?>

<?php
Modal::begin([
    'header' => '<h4>' . Yii::t('cms', 'Select content') . '</h4>',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">' . Yii::t('cms', 'Close') . '</button>',
    'id' => 'url-modal',
    'size' => Modal::SIZE_LARGE,
]); ?>

<?= BigSearch::widget([
    'dynamicUrls' => true,
    'onClickCallback' => 'function(e){
        e.preventDefault();
        var route = $(this).data("route");
        $("#url-modal").on("hidden.bs.modal", function(){
            $("#" + curLink).val(route);
        }).modal("hide");
    }',
]); ?>

<?php Modal::end(); ?>
