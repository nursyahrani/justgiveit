<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\UserEmailAuthentication;
/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
            ['email','email'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !UserEmailAuthentication::validatePassword($this->email,$this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
            
            else if(key(\Yii::$app->authManager->getRolesByUser($user->id)) !== 'admin'){
                $this->addError($attribute, 'You are not authorized');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::find()->select('user.*')->innerJoin('user_email_authentication', 'user.id = user_email_authentication.user_id')
                ->where(['user_email_authentication.email' => $this->email])->one();
        }

        return $this->_user;
    }
}
