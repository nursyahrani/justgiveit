<?php
namespace frontend\models;
use yii\base\Model;
use Yii;
use common\models\Image;
use common\models\Bid;
/**
 * Signup form
 */
class UploadImageForm extends Model
{
    public $file;
    
    public $user_id;
    /*
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['file', 'required'],
            ['user_id', 'required'],
            ['user_id', 'integer'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg']
        ];
    }
    
    public function save() {
        if(!$this->validate()) {
            return null;
        }
        $image = new Image();
        $image->user_id = $this->user_id;
        $basename = $this->file['name'];
        $ext = pathinfo($basename, PATHINFO_EXTENSION);
        if(!file_exists('img/' . $this->user_id)) {
            mkdir('img/' . $this->user_id, 0755,true );
        }
        $image->image_path = 'img/' . $this->user_id . '/' . 
                Yii::$app->security->generateRandomString() .  '.' .  $ext;
        while(file_exists($image->image_path)) {
            $image->image_path = 'img/' . $this->user_id . '/' . 
                    Yii::$app->security->generateRandomString() .  '.' .  $ext;
        }
        if(!$image->save()) {
            return null;
        }
        $success = move_uploaded_file($this->file['tmp_name'], $image->image_path);
        if(!$success) {
            return null;
        }
        return $image->image_id;
        
    }
    
        
}
