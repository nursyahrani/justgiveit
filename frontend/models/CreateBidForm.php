<?php
namespace frontend\models;

use common\models\User;
use common\models\UserEmailAuthentication;
use common\models\UserFacebookAuthentication;
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
    /*
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proposer_id', 'stuff_id', 'message'], 'required'],
            [['proposer_id', 'stuff_id'], 'integer'],
            ['message', 'string']
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function bid()
    {
        if ($this->validate()) {
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
    
    private function createBid() {
        $bid = new Bid();
        $bid->proposer_id = $this->proposer_id;
        $bid->stuff_id = $this->stuff_id;
        $bid->message = $this->message;
        if($bid->save()){
            return true;
        }

    }
    
    private function updateBid() {
        $bid = Bid::find()->where(['proposer_id' => $this->proposer_id, 'stuff_id' => $this->stuff_id])->one();
        if($bid->message === $this->message) {
            $bid->message = $this->message;
            return $bid->update();
        }
        
        return true;
    }
}
