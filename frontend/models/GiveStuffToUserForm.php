<?php

namespace frontend\models;

use common\models\GiveStuffToUser;
use common\models\Post;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
/**
 * ContactForm is the model behind the contact form.
 */
class GiveStuffToUserForm extends Model
{
    public $user_id;
    public $stuff_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['user_id', 'stuff_id'], 'required'],
            ['stuff_id', 'integer'],
            ['user_id', 'integer','min' => 1]
           ];
    }

    public function create(){
        if($this->checkExist()){

            $give_stuff_to_user = new GiveStuffToUser();
            $give_stuff_to_user->user_id = $this->user_id;
            $give_stuff_to_user->stuff_id = $this->stuff_id;

            if($give_stuff_to_user->save()){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return true;
        }
    }

    private function checkExist(){
        return GiveStuffToUser::find()->where(['user' => $this->user_id])->andWhere(['stuff_id' => $this->stuff_id])->exists();
    }

}
