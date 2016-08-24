<?php

namespace frontend\widgets;

use yii\base\Widget;

class BidderList extends Widget
{
    public $bid_list;
    
    public $stuff_id;
    public $id;
    

    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        BidderListAsset::register($view);

    }

    public function run()
    {
        if($this->bid_list === null || count($this->bid_list) === 0) {
            return;
        } 
        return $this->render('bidder-list',
            ['bid_list' => $this->bid_list, 'id' => $this->id, 'stuff_id' => $this->stuff_id]);
    }
}