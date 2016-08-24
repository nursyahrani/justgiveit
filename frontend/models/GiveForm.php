<?php
namespace frontend\models;
use yii\base\Model;
use Yii;
use common\models\Bid;
/**
 * Signup form
 */
class GiveForm extends Model
{
    public $stuff_id;
    public $proposer_id;
    public $current_user_id;
    /*
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stuff_id', 'proposer_id'], 'required'],
            [['proposer_id', 'stuff_id'], 'integer']
        ];
    }
    
    public function give() {
        
        if($this->validate() && $this->checkExist() && $this->isOwner()) {
            $bid = Bid::find()->where(['stuff_id' => $this->stuff_id, 'proposer_id' => $this->proposer_id])->one();
            $bid->obtain = 1;
            return $bid->update();
        }
        
        return false;
    }
    
    public function cancelGive() {
        if($this->validate() && $this->checkExist() && $this->isOwner()) {
            $bid = Bid::find()->where(['stuff_id' => $this->stuff_id, 'proposer_id' => $this->proposer_id])->one();
            $bid->obtain = 0;
            
            return $bid->update();
        }
        return false;
    }
    
    private function isOwner() {
        return \common\models\Post::find()->where(['stuff_id' => $this->stuff_id])->one()['poster_id'] === $this->current_user_id;
    
    }
    
    private function checkExist() {
        return Bid::find()->where(['stuff_id' => $this->stuff_id, 'proposer_id' => $this->proposer_id])->exists();
    }
}
