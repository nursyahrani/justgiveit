<?php

namespace frontend\models;

use common\models\Post;
use Yii;
use yii\base\Model;
use common\libraries\UserLibrary;
use yii\web\UploadedFile;
use common\models\PostTag;
use common\models\Tag;
/**
 * ContactForm is the model behind the contact form.
 */
class EditPostImageForm extends Model
{
    public $stuff_id;
    public $image_id;
    public $user_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['user_id', 'image_id', 'stuff_id'], 'integer'],
            [['user_id', 'image_id', 'stuff_id'], 'required'],
            
        ];
    }

    public function edit(){
        if(!$this->validate()) {
            return null;
        }
        
        $post= Post::find()->where(['stuff_id' => $this->stuff_id])->one();
        if($post === null) {
            return null;
        }
        
        if(!UserLibrary::isOwner($post->poster_id, $this->user_id)) {
            
            return null;
        }
        
        $post->image_id = $this->image_id;
        if(!$post->update()) {
            return false;
        }
        
        return true;
    }
    

}
