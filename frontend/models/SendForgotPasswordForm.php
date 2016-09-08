<?php
namespace frontend\models;

use common\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class SendForgotPasswordForm extends Model
{
    public $email;

    public $captcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email','captcha'], 'required'],
            ['captcha', 'captcha'],
            ['email', 'string', 'min' => 6],
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function send()
    {
    }
}
