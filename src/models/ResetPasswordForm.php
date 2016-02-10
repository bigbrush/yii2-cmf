<?php
namespace bigbrush\cms\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $username;
    public $password;

    /**
     * @var bigbrush\cms\model\User $_user a user model.
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param  string $token
     * @param  array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException(Yii::t('cms', 'Password reset token cannot be blank.'));
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException(Yii::t('cms', 'Wrong password reset token.'));
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('cms', 'Username'),
            'password' => Yii::t('cms', 'Password'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'username'], 'required'],
            ['password', 'string', 'min' => 6],
            ['username', 'validateUsername'],
        ];
    }

    /**
     * Validates the username.
     *
     * @param string $attribute the attribute currently being validated
     * @param mixed $params the value of the "params" given in the rule
     */
    public function validateUsername($attribute, $params)
    {
        if ($this->username !== $this->_user->username) {
            $this->addError(Yii::t('cms', 'Wrong username.'));
        }
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        $user->state = User::STATE_ACTIVE;
        return $user->save(false);
    }
}
