<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\helpers\Url;
?>
<?= Yii::t('cms', 'Hi {name},', ['name' => $model->name]) ?>
<?= Yii::t('cms', 'Please visit the url below to reset your password') ?>
<?= Yii::t('cms', 'Reset url') ?> : <?= Html::a(Yii::t('cms', 'Click here to reset your password'), Url::to(['reset-password', 'token' => $model->password_reset_token], true)) ?>
<?= Yii::t('cms', 'And use the following username when creating a new password.') ?> : <?= $model->username ?>
