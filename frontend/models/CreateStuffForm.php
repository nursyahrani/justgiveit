<?php

namespace frontend\models;

use common\models\Post;
use Yii;
use yii\base\Model;
use common\models\User;
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
    public $location;
    public $poster_id;
    public $quantity;
    public $type;
    public $tags;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['title', 'description', 'tags','type', 'location'], 'required'],
            ['poster_id', 'integer'],
            [['image_id', 'location'], 'integer'],
            ['type', 'integer'],
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
        $post->type = $this->type;
        $post->poster_id = $this->poster_id;
        $post->quantity = $this->quantity;
        $post->pick_up_location_id = $this->location;
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
        
        //check whether user location is empty;
        $this->updateUserLocation();
        
        return $post->stuff_id;
    }
    
    public function updateUserLocation() {
        $user = User::find()->where(['id' => $this->poster_id])->one();
        if($user->city_id === null) {
            $user->city_id = $this->location;
            $user->update();
        }
    }
    
    private function checkExist($tag) {
        return Tag::find()->where(['tag_name' => $tag])->exists();
    }

}
