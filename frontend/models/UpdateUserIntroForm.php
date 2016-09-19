<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;
/**
 * ContactForm is the model behind the contact form.
 */
class UpdateUserIntroForm extends Model
{
    public $user_id;
    public $intro;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['user_id', 'integer'],
            ['intro', 'string', 'length' => [1, 100]],
            [['intro','user_id'], 'required']
        ];
    }

    public function update(){
        if(!$this->validate()) {
            return false;
        }
        
        $user = User::find()->where(['id' => $this->user_id])->one();
        if($user->intro === $this->intro) {
            return true;
        }
        $user->intro = $this->intro;
        return $user->update();
    }
    
    
}
