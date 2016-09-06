<?php

namespace frontend\widgets;

use yii\base\Widget;

class BannerWithSearch extends Widget
{
    public $id;
    
    public $initial_location;
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        BannerWithSearchAsset::register($view);

    }

    public function run()
    {
        return $this->render('banner-with-search',
            ['id' => $this->id, 'initial_location' => $this->initial_location]);
    }
}