<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;
/**
 * ContactForm is the model behind the contact form.
 */
class UpdateUserNameForm extends Model
{
    public $user_id;
    public $first_name;
    public $last_name;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['user_id', 'integer'],
            [['first_name', 'last_name'], 'string'],
            [['user_id','first_name'], 'required']
        ];
    }

    public function update(){
        if(!$this->validate()) {
            return false;
        }
        
        $user = User::find()->where(['id' => $this->user_id])->one();
        
        if(!$user) {
            return false;
        }
        
        if($user->last_name === $this->last_name && 
            $user->first_name === $this->first_name) {
            return true;
        }
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        return $user->update();
    }
    
    
}
