<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use common\models\UserEmailAuthentication;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;
    
    public $captcha;

    /**
     * @inheritdoc
      */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['captcha', 'captcha'],
            ['captcha', 'required'],
            ['email', 'exist',
                'targetClass' => '\common\models\UserEmailAuthentication',
                'message' => 'There is no user with such email.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        if(!$this->validate()) {
            return false;
        }
        /* @var $user User */
        $user_email = UserEmailAuthentication::findOne([
            'email' => $this->email,
        ]);

        
        if ($user_email) {
        
            if (!\common\models\UserEmailAuthentication::isPasswordResetTokenValid($user_email->password_reset_token)) {
                $user_email->generatePasswordResetToken();
            }

            if ($user_email->save()) {
                $user = User::findOne(['id' => $user_email->user_id]);
                return \Yii::$app->mailer->compose(['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user, 'user_email' => $user_email])
                    ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                    ->setTo($this->email)
                    ->setSubject('Password reset for ' . \Yii::$app->name)
                    ->send();
            }
        }

        return false;
    }
}
