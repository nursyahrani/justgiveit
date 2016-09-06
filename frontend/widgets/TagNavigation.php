<?php

namespace frontend\widgets;

use yii\base\Widget;

class TagNavigation extends Widget
{
    public $id;
    
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
            ['id' => $this->id]);
    }
}