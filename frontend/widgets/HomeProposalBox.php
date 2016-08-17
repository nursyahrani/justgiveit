<?php

namespace frontend\widgets;

use yii\base\Widget;

class HomeProposalBox extends Widget
{
    public $post_vo;
    
    public function init()
    {
        parent::init();

        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        HomeProposalBoxAsset::register($view);

    }

    public function run()
    {
        return $this->render('home-proposal-box',
            ['post_vo' => $this->post_vo]);
    }
}