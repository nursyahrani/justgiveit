<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;
/**
 * ContactForm is the model behind the contact form.
 */
class UpdateUserCityForm extends Model
{
    public $user_id;
    public $city_id;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id', 'user_id'], 'integer'],
            [['city_id','user_id'], 'required']
        ];
    }

    public function update(){
        if(!$this->validate()) {
            return false;
        }
        
        $user = User::find()->where(['id' => $this->user_id])->one();
        if($user->city_id === $this->city_id) {
            return true;
        }
        $user->city_id = $this->city_id;
        return $user->update();
    }
    
    
}
