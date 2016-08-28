<?php

namespace frontend\widgets;

use yii\base\Widget;

class PostCard extends Widget
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
        PostCardAsset::register($view);

    }

    public function run()
    {
        return $this->render('post-card',
            ['id' => $this->id, 'post_vo' => $this->post_vo]);
    }
}