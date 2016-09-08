<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\UserEmailAuthentication;
/**
 * ContactForm is the model behind the contact form.
 */
class CreateValidationCode extends Model
{ 
    
    public $email;
    public $user_id;
    
    public function rules()
    {
        return [
            [['email', 'user_id'], 'required'],
            ['email', 'string'],
            ['user_id', 'integer']
        ];
    }

    public function create(){
        
        if(!$this->validate()) {
            return null;
        }
        $user_email = $this->getUserEmailAuth();
        $user_email->validation_code = Yii::$app->security->generateRandomString() . '_' . time();
        $user_email->update();
        $user = \common\models\User::find()->where(['id' => $this->user_id])->one();
        return \Yii::$app->mailer->compose(['html' => 'emailValidation-html', 'text' => 'emailValidation-text'], ['user' => $user, 'user_email' => $user_email])
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' Admin'])
            ->setTo($this->email)
            ->setSubject('Email Validation: ' . \Yii::$app->name)
            ->send();


    }
    
    private function getUserEmailAuth() {
        
        return UserEmailAuthentication::find()->where(['email' => $this->email])->one();
    }
    
    

}
