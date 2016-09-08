<?php
namespace frontend\models;

use common\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class ValidateValidationEmailForm extends Model
{
    
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_user = \common\models\UserEmailAuthentication::find()->where(['validation_code' => $token])->one();
        if (!$this->_user) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        $this->_user->validated  = 1;
        $this->_user->validation_code = null;
        $this->_user->update();
        parent::__construct($config);
    }
    
    public function getEmail() {
        return $this->_user->email;
    }

}
