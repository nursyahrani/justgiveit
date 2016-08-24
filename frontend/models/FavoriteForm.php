<?php
namespace frontend\models;
use yii\base\Model;
use Yii;
use common\models\Favorite;
/**
 * Signup form
 */
class FavoriteForm extends Model
{
    public $stuff_id;
    public $user_id;
    /*
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stuff_id', 'user_id'], 'required'],
            [['user_id', 'stuff_id'], 'integer']
        ];
    }
    
    public function requestFavorite() {
        if($this->validate() && !$this->checkExist()) {
            $favorite = new Favorite();
            $favorite->user_id = $this->user_id;
            $favorite->stuff_id = $this->stuff_id;
            return $favorite->save();
        }
        
        return true;
    }
    
    public function cancelFavorite() {
        if($this->validate() && $this->checkExist()) {
            $favorite = Favorite::find()->where(['stuff_id' => $this->stuff_id, 'user_id' => $this->user_id])->one();
            return $favorite->delete();
        }
        return true;
    }
    
    private function checkExist() {
        return Favorite::find()->where(['stuff_id' => $this->stuff_id, 'user_id' => $this->user_id])->one();
    }
}
