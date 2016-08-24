<?php

namespace frontend\widgets;

use yii\base\Widget;

class PostSection extends Widget
{
    public $id;
    
    public $post;
    
    public function init()
    {
        parent::init();

        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        PostSectionAsset::register($view);

    }

    public function run()
    {
        return $this->render('post-section',
            ['id' => $this->id, 'post' => $this->post]);
    }
}