<?php

namespace frontend\models;

use common\models\Post;
use yii\base\Model;
use common\libraries\UserLibrary;
/**
 * ContactForm is the model behind the contact form.
 */
class DeleteStuffForm extends Model
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
            [['user_id', 'stuff_id'], 'integer']
        ];
    }

    public function delete(){
        //save post
        if(!$this->validate()) {
            return false;
        }
        
        $post = $this->getPost();
        
        if($post && UserLibrary::isOwner($post['poster_id'])) {
            $post->post_status = 0;
            $post->update();
            return true;
        }
        
        return false;
    }
    
    private function getPost() {
        return Post::find()->where(['stuff_id' => $this->stuff_id])->one();
    }
    
    

}
