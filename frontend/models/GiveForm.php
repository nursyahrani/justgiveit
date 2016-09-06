<?php
namespace frontend\models;
use yii\base\Model;
use Yii;
use common\models\Post;
use common\models\Bid;
/**
 * Signup form
 */
class GiveForm extends Model
{
    public $bid_id;
    public $post_owner_id;
    
    public $bid_dao;
    
    public function __construct() {
        $this->bid_dao = new \frontend\dao\BidDao;
    }
    /*
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bid_id', 'post_owner_id'], 'required'],
            [['bid_id', 'post_owner_id'], 'integer']
        ];
    }
    
    public function give() {
        
        if($this->validate() && $this->checkExist() && $this->isOwner()) {
            $bid = Bid::find()->where(['bid_id' => $this->bid_id])->one();
            $bid->obtain = 1;
            return $bid->update();
        }
        
        return false;
    }
    
    public function cancelGive() {
        if($this->validate() && $this->checkExist() && $this->isOwner()) {
            $bid = Bid::find()->where(['bid_id' => $this->bid_id])->one();
            $bid->obtain = 0;
            return $bid->update();
        }
        return false;
    }
    
    private function isOwner() {
        return $this->bid_dao->getPostOwner($this->bid_id) === $this->post_owner_id;
    
    }
    
    private function checkExist() {
        return Bid::find()->where(['bid_id' => $this->bid_id])->exists();
    }
}
