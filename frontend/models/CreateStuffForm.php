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
class CreateStuffForm extends Model
{
    public $title;
    public $description;
    public $image_id;
    public $poster_id;
    public $quantity;
    
    public $tags;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['title', 'description', 'tags'], 'required'],
            ['poster_id', 'integer'],
            [['image_id'], 'integer'],
            ['quantity', 'integer', 'min' => 1],
            ['tags', 'each', 'rule' => ['string']],
        ];
    }

    public function create(){
        if(!$this->validate()) {
            return null;
        }
        
        $post= new Post();
        $post->title = $this->title;
        $post->description = $this->description;
        $post->image_id = $this->image_id;
        $post->poster_id = $this->poster_id;
        $post->quantity = $this->quantity;
        $post->deadline = time() + (7 * 24 *3600);
        if(!$post->save()){
            return null;
        }
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
        return $post->stuff_id;
    }
    
    public function update() {
        
    }
    
    private function checkExist($tag) {
        return Tag::find()->where(['tag_name' => $tag])->exists();
    }

}
