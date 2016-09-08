<?php
namespace frontend\models;

use common\models\User;
use common\models\UserEmailAuthentication;
use common\models\UserFacebookAuthentication;
use yii\base\Model;
use Yii;
use common\models\City;
use common\models\Country;

/**
 * Signup form
 */
class RegisterLoginUserEmailForm extends Model
{
    public $email;
    public $password;
    public $user_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [


            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\UserEmailAuthentication', 'message' => 'This email address has already been taken.'],
            ['email', 'required'],
            
            ['user_id', 'integer'],
            ['user_id', 'required'],
            ['password', 'string', 'min' => 6],

        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function create()
    {
        if ($this->validate()) {
            $user_email = $this->getUserEmailAuth();
            if(!$user_email) {
                $user_email = new UserEmailAuthentication();
                $user_email->setPassword($this->password);
                $user_email->user_id = $this->user_id;
                $user_email->email = $this->email;
                if($user_email->save()) {
                    return true;
                }
            } else {
                $user_email->setPassword($this->password);
                $user_email->user_id = $this->user_id;
                $user_email->email = $this->email;
                if($user_email->update()) {
                    return true;
                }
            }
        }

        return false;
    }

    private function getUserEmailAuth() {
        return UserEmailAuthentication::find()->where(['user_id' => $this->user_id])->one();
    }
}
