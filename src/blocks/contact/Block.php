<?php
/**
 * @link http://www.bigbrush-agency.com/
 * @copyright Copyright (c) 2015 Big Brush Agency ApS
 * @license http://www.bigbrush-agency.com/license/
 */

namespace bigbrush\cms\blocks\contact;

use Yii;
use yii\helpers\Url;
use yii\helpers\Json;
use bigbrush\cms\blocks\contact\components\ModelBehavior;
use bigbrush\cms\blocks\contact\models\ContactForm;

/**
 * Block
 *
 * @property bigbrush\big\models\Block $model
 */
class Block extends \bigbrush\big\core\Block
{
    const SESSION_VAR_FORM_POSTED = '__contact_block_posted';


    /**
     * Initializes this block by attaching a behavior to [[model]].
     */
    public function init()
    {
        $this->model->attachBehavior('contactBehavior', ['class' => ModelBehavior::className(), 'owner' => $this->model]);
    }

    /**
     * Runs this block.
     *
     * @return string the content of this block.
     */
    public function run()
    {
        $session = Yii::$app->getSession();
        $model = new ContactForm();
        $model->requiredFields = $this->model->getRequiredFields();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            if ($this->sendEmail($model)) {
                if (empty($this->model->redirectTo)) {
                    $session->setFlash('success', $this->model->successMessage);
                    Yii::$app->getResponse()->redirect(Yii::$app->request->referrer);
                } else {
                    $url = Yii::$app->big->urlManager->parseInternalUrl($this->model->redirectTo);
                    Yii::$app->getResponse()->redirect(Yii::$app->getUrlManager()->createUrl($url));
                }
                return;
            } else {
                $session->setFlash('error', Yii::t('cms', 'Email not sent - please try again.'));
            }
        }
        return $this->render('index', [
            'block' => $this,
            'model' => $model,
        ]);
    }

    /**
     * Edits the block.
     *
     * @param Block $model the model for this block.
     * @param yii\bootstrap\ActiveForm $form the form used to edit this block.
     * @return string html form ready to be rendered.
     */
    public function edit($model, $form)
    {
        return $this->render('edit', [
            'model' => $model,
            'form' => $form,
        ]);
    }

    /**
     * This method gets called right before a block model is saved. The model is validated at this point.
     * In this method any Block specific logic should run. For example saving a block specific model.
     *
     * @param bigbrush\big\models\Block the model being saved.
     * @return boolean whether the current save procedure should proceed. If any block.
     * specific logic fails false should be returned - i.e. return $blockSpecificModel->save();
     */
    public function save($model)
    {
        $model->updateOwner();
        return true;
    }

    /**
     * Sends an email.
     *
     * @param ContactForm $model a validated contact model.
     * @return boolean true if email was sent and false if not.
     */
    public function sendEmail($model)
    {
        $site = Url::to('@web', true);
        $htmlBody = $this->render('_email_html', [
            'model' => $model,
            'site' => $site,
        ]);
        $textBody = $this->render('_email_text', [
            'model' => $model,
            'site' => $site,
        ]);

        $params = Json::decode($this->model->content);
        $fromEmail = empty($params['receiver']) ? 'noreply@noreply.com' : $params['receiver'];
        return Yii::$app->mailer->compose()
            ->setFrom($fromEmail)
            ->setTo($this->model->receiver)
            ->setSubject(Yii::t('cms', 'Contact from {site}', ['site' => $site]))
            ->setTextBody($textBody)
            ->setHtmlBody($htmlBody)
            ->send();
    }
}
