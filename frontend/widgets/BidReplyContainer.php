<?php

namespace frontend\widgets;

use yii\base\Widget;

class BidReplyContainer extends Widget
{
    public $chosen_bid_reply;
    
    public $total_bid ;
    
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
        return $this->render('bid-reply-container',
            ['chosen_bid_reply' => $this->chosen_bid_reply, 
            'id' => $this->id,
            'bid_id' => $this->bid_id,
            'total_bid' => $this->total_bid]);
    }
}