<?php

namespace frontend\models;

use common\models\Post;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\PostTag;
use common\models\Tag;
/**
 * ContactForm is the model behind the contact form.
 */
class EditStuffInformationForm extends Model
{
    public $title;
    public $description;
    public $user_id;
    public $tags;
    public $quantity;
    public $stuff_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['title', 'description', 'tags','user_id', 'stuff_id', 'quantity'], 'required'],
            [['user_id', 'stuff_id'], 'integer'],
            [['title', 'description'], 'string'],
            ['quantity', 'integer', 'min' => 1],
            ['tags', 'each', 'rule' => ['string']],
        ];
    }

    public function update(){
        //save post
        if(!$this->validate()) {
            return false;
        }
        
        if(($post = $this->getPost()) !== null) {
            $post->title = $this->title;
            $post->description = $this->description;
            $post->quantity = $this->quantity;
            $post->update();
        }
        
        $this->deleteAllTags($this->stuff_id);
        
        foreach($this->tags as $tag) {
            if(!$this->checkExist($tag)) {
               $tag_model = new Tag();
               $tag_model->tag_name = $tag;
               $tag_model->tag_description = '';
               if(!$tag_model->save()) {
                   return false;
               }
            }
            
            
            $post_tag = new PostTag();
            $post_tag->post_id = $post->stuff_id;
            $post_tag->tag_name = $tag;
            if(!$post_tag->save()) {
                
                return false;
            }   
        }   
        
        return true;
    }
    
    private function deleteAllTags($post_id) {
        return PostTag::deleteAll(['post_id' => $post_id]);
    }
    private function getPost() {
        return Post::find()->where(['stuff_id' => $this->stuff_id])->one();
    }
    private function checkExist($tag) {
        return Tag::find()->where(['tag_name' => $tag])->exists();
    }

}
