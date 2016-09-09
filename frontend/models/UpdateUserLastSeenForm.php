<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;
/**
 * ContactForm is the model behind the contact form.
 */
class UpdateUserLastSeenForm extends Model
{
    public $user_id;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['user_id'], 'required']
        ];
    }

    public function update(){
        if(!$this->validate()) {
            return false;
        }
        
        $user = User::find()->where(['id' => $this->user_id])->one();
        $user->notif_last_seen = time();
        return $user->update();
    }
    
    
}
