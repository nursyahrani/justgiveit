<?php

namespace frontend\widgets;

use yii\base\Widget;

class HomePostList extends Widget
{
    public $post_vo;
    
    public $id;

    public function init()
    {
        parent::init();

        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        HomePostListAsset::register($view);

    }

    public function run()
    {
        return $this->render('home-post-list',
            ['id' => $this->id, 'post_vo' => $this->post_vo]);
    }
}