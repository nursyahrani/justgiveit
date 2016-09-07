<?php

namespace frontend\models;

use common\models\Post;
use yii\base\Model;
use common\libraries\UserLibrary;
use common\models\Bid;
/**
 * ContactForm is the model behind the contact form.
 */
class DeleteBidForm extends Model
{
    public $user_id;
    public $bid_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['user_id', 'bid_id'], 'required'],
            [['user_id', 'bid_id'], 'integer']
        ];
    }

    public function delete(){
        //save post
        if(!$this->validate()) {
            return false;
        }
        $bid = $this->getBid();
        if($bid && UserLibrary::isOwner($bid['proposer_id'], $this->user_id)) {
            $bid->bid_status = 0;
            $bid->update();
            return true;
        }
        
        return false;
    }
    
    private function getBid() {
        return Bid::find()->where(['bid_id' => $this->bid_id])->one();
    }
    
    

}
