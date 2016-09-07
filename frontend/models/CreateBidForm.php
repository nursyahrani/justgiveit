<?php
namespace frontend\models;

use common\models\User;
use common\models\Post;
use yii\base\Model;
use Yii;
use common\models\Bid;
/**
 * Signup form
 */
class CreateBidForm extends Model
{
    public $stuff_id;
    public $proposer_id;
    public $message;
    public $quantity;
    /*
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proposer_id', 'stuff_id', 'quantity', 'message'], 'required'],
            [['proposer_id', 'stuff_id'], 'integer'],
            ['message', 'string'],
            ['quantity', 'integer', 'min' => 1]
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function bid()
    {
        if ($this->validate() && !$this->isOwner() && $this->isQuantityValid()) {
            if($this->checkExist()) {
                return $this->updateBid();
            } else {
                return $this->createBid();
            }
        }

        return false;
    }
    
    private function checkExist() {
        return Bid::find()->where(['proposer_id' => $this->proposer_id, 'stuff_id' => $this->stuff_id])->exists();
    }
    
    private function isOwner() {
        return \common\models\Post::find()->where(['stuff_id' => $this->stuff_id])->one()['poster_id'] === $this->proposer_id;
    }
    
    private function isQuantityValid() {
        return intval(Post::find()->where(['stuff_id' => $this->stuff_id])->one()['quantity']) >= $this->quantity;
    }
    
    private function createBid() {
        $bid = new Bid();
        $bid->proposer_id = $this->proposer_id;
        $bid->stuff_id = $this->stuff_id;
        $bid->message = $this->message;
        $bid->quantity = $this->quantity;
        if($bid->save()){
            return true;
        }

    }
    
    private function updateBid() {
        $bid = Bid::find()->where(['proposer_id' => $this->proposer_id, 'stuff_id' => $this->stuff_id])->one();
        
        if($bid->message !== $this->message || $bid->quantity !== $this->quantity) {
            $bid->message = $this->message;
            $bid->quantity = $this->quantity;
            $bid->bid_status = '10';
            return $bid->update();
        }
        
        return true;
    }
}
