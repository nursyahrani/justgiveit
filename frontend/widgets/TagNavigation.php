<?php

namespace frontend\widgets;

use yii\base\Widget;

class TagNavigation extends Widget
{
    public $id;
    
    public $most_popular_tags = [];
    
    public $starred_tags = [];
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        TagNavigationAsset::register($view);

    }

    public function run()
    {
        return $this->render('tag-navigation',
            ['id' => $this->id,
            'most_popular_tags' => $this->most_popular_tags,
            'starred_tags' => $this->starred_tags]);
    }
}