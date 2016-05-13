<?php

namespace frontend\models;

use common\models\Post;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
/**
 * ContactForm is the model behind the contact form.
 */
class CreateStuffForm extends Model
{
    public $title;
    public $description;
    public $imageFile;
    public $poster_id;
    public $address;
    public $type;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['title', 'description'], 'required'],
            ['poster_id', 'integer'],
            [ 'address', 'string'],
            [['imageFile'], 'safe'],

            [['imageFile'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    public function create(){
        $image = UploadedFile::getInstance($this, 'imageFile');

        $post= new Post();
        $post->title = $this->title;
        $post->description = $this->description;
        $post->photo_path = 'img/' .Yii::$app->security->generateRandomString() .  '.' .  $image->extension;
        $post->address = $this->address;
        $post->type = "give";
        $post->poster_id = $this->poster_id;

        if($post->save()){
            $image->saveAs($post->photo_path);

            return true;
        }
    }

}
