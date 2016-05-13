<?php
namespace frontend\models;

use common\models\User;
use common\models\UserEmailAuthentication;
use common\models\UserFacebookAuthentication;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $facebook_id;
    public $photo_path;
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

            ['first_name', 'required'],
            [['first_name', 'last_name'], 'string', 'min' => 1],

            ['facebook_id', 'unique', 'targetClass' => '\common\models\UserFacebookAuthentication', 'message' => 'Facebook Id has been registered'],

            ['password', 'string', 'min' => 6],

            ['photo_path', 'string'],

            [['email', 'password'], 'required', 'when' => function($model){
                return $model->facebook_id == '';
            }],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->generateUsername();
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            if($this->photo_path != null){
                $user->profile_pic = $this->photo_path;

            }
            $user->generateAuthKey();
            if($user->save()){

                if($this->email != null){
                    $user_email_auth = new UserEmailAuthentication();
                    $user_email_auth->user_id = $user->id;
                    $user_email_auth->email = $this->email;
                    $user_email_auth->setPassword($this->password);
                    if(!$user_email_auth->save()){
                        return false;
                    }
                }

                if($this->facebook_id != null){
                    $user_facebook_auth = new UserFacebookAuthentication();
                    $user_facebook_auth->user_id = $user->id;
                    $user_facebook_auth->facebook_id = $this->facebook_id;
                    if(!$user_facebook_auth->save()){
                        return false;
                    }
                }

                return $user;

            }


        }

        return null;
    }

    public function generateUsername(){

        $base_username = strtolower($this->first_name) . '.' . strtolower($this->last_name);
        $i = 0;
        while(true){

            if($i != 0){
                $update_username = $base_username . '.' . $i;
            }
            else{
                $update_username = $base_username;
            }

            if(User::find()->where(['username' => $update_username])->exists()){
                $i++;
            }
            else{
                //Yii::$app->end($update_username);
                return $update_username;
            }
        }

    }
}
