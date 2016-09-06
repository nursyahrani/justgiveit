<?php

namespace frontend\widgets;

use yii\base\Widget;

class BidContainer extends Widget
{
    public $bid_list;
    
    public $id;
    
    public $post_owner;
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        BidContainerAsset::register($view);

    }

    public function run()
    {
        if($this->bid_list === null || count($this->bid_list) === 0) {
            return 'No Result Found';
        }
        return $this->render('bid-container',
            ['bid_list' => $this->bid_list, 'id' => $this->id, 'post_owner' => $this->post_owner]);
    }
}