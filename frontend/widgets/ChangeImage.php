<?php

namespace frontend\widgets;

use yii\base\Widget;

class ChangeImage extends Widget
{
    public $id;
    
    public $initial_image;
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        ChangeImageAsset::register($view);

    }   

    public function run()
    {
        return $this->render('change-image',['id' => $this->id
                , 'initial_image' => $this->initial_image]);
    }
}