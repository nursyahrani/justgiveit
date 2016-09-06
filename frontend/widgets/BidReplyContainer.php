<?php

namespace frontend\widgets;

use yii\base\Widget;

class BidReplyContainer extends Widget
{
    public $chosen_bid_reply;
    
    public $total_replies ;
    
    public $last_created_at;
    
    public $bid_id;
    
    public $id;
    

    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        BidReplyContainerAsset::register($view);

    }

    public function run()
    {
        if(isset($this->chosen_bid_reply)) {
            $first_created_at = $this->chosen_bid_reply->getCreatedAtTimestamp();
        } else {
            $first_created_at = 0;
        }
        return $this->render('bid-reply-container',
            ['chosen_bid_reply' => $this->chosen_bid_reply, 
            'id' => $this->id,
            'bid_id' => $this->bid_id,
            'offset' => count($this->chosen_bid_reply),
            'total_more_replies' => $this->total_replies - count($this->chosen_bid_reply),
            'first_created_at' => $first_created_at]);
    }
}