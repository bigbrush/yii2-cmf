<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('cms', 'Reset password');
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-12">
        <h1><?= $this->title ?></h1>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('cms', 'Reset password'), ['class' => 'btn btn-primary']) ?>
            </div>
    </div>
</div>
<?php $form = ActiveForm::end(); ?>
