<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\modules\big\backend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use bigbrush\cms\models\User;
use bigbrush\cms\models\ResetPasswordForm;

/**
 * UserController
 */
class UserController extends Controller
{
    /**
     * Renders a list of users.
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $this->getModel(),
        ]);
    }

    public function actionTest($id)
    {
        $model = $this->getModel($id);
        return $this->render('email_reset_password_html', [
            'model' => $model,
        ]);
    }

    /**
     * Renders the edit view for a user.
     *
     * @param int $id the id of a User model.
     */
    public function actionEdit($id = 0)
    {
        $model = $this->getModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('cms', 'User saved.'));

            if ($model->reset_password && $model->resetPassword()) {
                $viewParams = [
                    'model' => $model,
                ];
                Yii::$app->session->setFlash('success', Yii::t('cms', 'Password was reset successfully.'));
                // compose email. Use the views render method so the theme is not rendered
                Yii::$app->mailer->compose()
                    ->setFrom('noreply@noreply.com')
                    ->setTo($model->email)
                    ->setSubject(Yii::t('cms', 'Your password has been reset at {site}', ['site' => Url::to('@web', true)]))
                    ->setTextBody($this->getView()->render('email_reset_password_text', $viewParams, $this))
                    ->setHtmlBody($this->getView()->render('email_reset_password_html', $viewParams, $this))
                    ->send();
            }

            if (Yii::$app->toolbar->stayAfterSave()) {
                return $this->redirect(['edit', 'id' => $model->id]);
            } else {
                return $this->redirect(['index']);
            }
        }
        return $this->render('edit', [
            'model' => $model
        ]);
    }

    /**
     * Renders a form where a user can reset their password.
     *
     * @param string $token a reset token for a user.
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('cms', 'New password was saved.'));
            Yii::$app->user->returnUrl = null; // so we dont redirect to this action after login
            return $this->redirect(['/']); // redirect to login page
        }

        return $this->render('reset_password', [
            'model' => $model,
        ]);
    }

    /**
     * Returns a User model.
     * If $id is provided, the model will be loaded from the database.
     *
     * @param int $id the id of a user.
     * @return User|null a User model. If id is provided and not found in the
     * database, null is returned.
     */
    public function getModel($id = 0)
    {
        $model = new User();
        if ($id) {
            $model = $model->findOne($id);
        }
        return $model;
    }
}
