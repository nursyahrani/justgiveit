<?php

namespace frontend\widgets;

use yii\base\Widget;

class Bid extends Widget
{
    public $bid;
    
    public $id;
    
    public $post_owner;
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        BidAsset::register($view);

    }

    public function run()
    {
        return $this->render('bid',
            ['id' => $this->id,
                'bid' => $this->bid, 'post_owner' => $this->post_owner]);
    }
}