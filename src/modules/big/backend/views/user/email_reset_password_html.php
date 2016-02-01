<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div style="text-align:center;width:100%">

    <table width="600" cellpadding="10" cellspacing="0" style="background-color:#ffffff;text-align:left;margin:auto;" align="center">    
        <tr>
            <th colspan="2"><?= Yii::t('cms', 'Hi {name},', ['name' => $model->name]) ?></th>
        </tr>
        <tr>
            <td colspan="2"><?= Yii::t('cms', 'Please visit the url below to reset your password') ?></td>
        </tr>
        <tr>
            <td width="25%"><?= Yii::t('cms', 'Reset url') ?></td>
            <td><?= Html::a(Yii::t('cms', 'Click here to reset your password'), Url::to(['reset-password', 'token' => $model->password_reset_token], true)) ?></td>
        </tr>
        <tr>
            <td colspan="2"><?= Yii::t('cms', 'And use the following username when creating a new password.') ?></td>
        </tr>
        <tr>
            <td width="25%"><?= Yii::t('cms', 'Username') ?></td>
            <td><?= $model->username ?></td>
        </tr>
    </table>
    
</div>
