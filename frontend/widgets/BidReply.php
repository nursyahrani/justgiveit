<?php

namespace frontend\widgets;

use yii\base\Widget;

class BidReply extends Widget
{
    public $bid_reply;
    
    public $id;
    

    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        BidReplyAsset::register($view);

    }

    public function run()
    {
        return $this->render('bid-reply',
            ['bid_reply' => $this->bid_reply, 'id' => $this->id]);
    }
}