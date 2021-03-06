<?php

namespace frontend\widgets;

use yii\base\Widget;

class SearchBar extends Widget
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
        SearchBarAsset::register($view);

    }

    public function run()
    {
        return $this->render('search-bar',
            ['id' => $this->id, 'initial_location' => $this->initial_location]);
    }
}