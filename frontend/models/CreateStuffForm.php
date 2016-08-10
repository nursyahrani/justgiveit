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
    public $imageFile;
    public $poster_id;
    
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
            [['imageFile'], 'safe'],
            ['tags', 'each', 'rule' => ['string']],
            [['imageFile'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    public function create(){
        $image = UploadedFile::getInstance($this, 'imageFile');

        $post= new Post();
        $post->title = $this->title;
        $post->description = $this->description;
        $post->photo_path = 'img/' .Yii::$app->security->generateRandomString() .  '.' .  $image->extension;
        $post->poster_id = $this->poster_id;
        $post->deadline = time() + (7 * 24 *3600);
        if(!$post->save()){
            return null;
        }
        $image->saveAs($post->photo_path);
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
    
    private function checkExist($tag) {
        return Tag::find()->where(['tag_name' => $tag])->exists();
    }

}
