<?php

namespace frontend\widgets;

use yii\base\Widget;

class BidContainer extends Widget
{
    public $post;
    
    public $id;
    

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
        return $this->render('bid-container',
            ['post' => $this->post, 'id' => $this->id]);
    }
}