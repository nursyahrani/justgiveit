<?php

namespace frontend\widgets;

use yii\base\Widget;

class PostList extends Widget
{
    public $id;
    
    public $posts;
    
    public function init()
    {
        parent::init();

        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        PostListAsset::register($view);

    }

    public function run()
    {
        return $this->render('post-list',
            ['id' => $this->id, 'posts' => $this->posts]);
    }
}