<?php

namespace frontend\widgets;

use yii\base\Widget;

class CreatePost extends Widget
{
    public $id;
    

    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        CreatePostAsset::register($view);

    }   

    public function run()
    {
        return $this->render('create-post',['id' => $this->id]);
    }
}