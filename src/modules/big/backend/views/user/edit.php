<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use bigbrush\big\widgets\filemanager\FileManager;

$this->registerJs('
    $(\'[data-toggle="tooltip"]\').tooltip();
');

$tooltipOptions = [
    'toggle' => 'tooltip',
    'placement' => 'right',
];

$type = Yii::t('cms', 'user');
$title = $model->id ? Yii::t('cms', 'Edit {0}', $type) : Yii::t('cms', 'Create {0}', $type);
$this->title = $title;

$this->registerJs('
    $("#btn-select-avatar").click(function(e){
        e.preventDefault();
    });
');
?>
<?php $form = ActiveForm::begin(); ?>
    
    <?php Yii::$app->toolbar->save()->saveStay()->back(); ?>
    
    <h1><?= $title ?></h1>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'username') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'phone') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'email')->input('email') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'state')->dropDownList($model->getStateOptions()) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php $link = Html::a(Yii::t('cms', 'Change'), '#', [
                    'class' => 'btn btn-info btn-sm',
                    'data' => [
                        'toggle' => 'modal', 'target' => '#modal'
                    ]
                ])?>
                <?= $form->field($model, 'avatar', [
                    'template' => "{label}\n{input}\n$link\n{hint}\n{error}",
                ])->hiddenInput() ?>
                <img id="avatar-image" src="<?= empty($model->avatar) ? '' : Yii::getAlias('@web') . '/../' . $model->avatar; ?>" >
            </div>
        </div>
        <?php if ($model->id) : ?>
        <div class="col-md-6">
            <fieldset>
                <legend><?= Yii::t('cms', 'User management') ?></legend>
                <?= $form->field($model, 'reset_password')->dropDownList([0 => Yii::t('cms', 'No'), 1 => Yii::t('cms', 'Yes')])->label($model->getAttributeLabel('reset_password'), [
                    'data' => $tooltipOptions + [
                        'title' => Yii::t('cms', 'Whether to reset the user password. An email will be sent to the user.'),
                    ]
                ]) ?>
            </fieldset>
        </div>
        <?php endif; ?>
    </div>

<?php ActiveForm::end(); ?>

<?php Modal::begin([
    'id' => 'modal',
    'header' => 'Vælg billede',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">' . Yii::t('cms', 'Close') . '</button>',
    'size' => Modal::SIZE_LARGE,
]); ?>
<?= FileManager::widget([
    'onClickCallback' => 'function(file){
        $("#user-avatar").val(file.url);
        $("#avatar-image").attr("src", file.baseUrl + file.url);
        $("#modal").modal("hide");
    }'
]); ?>
<?php Modal::end(); ?>
