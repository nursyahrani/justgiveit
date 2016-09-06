<?php

namespace frontend\widgets;

use yii\base\Widget;

class EditPost extends Widget
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
        EditPostAsset::register($view);

    }   

    public function run()
    {
        return $this->render('edit-post',['id' => $this->id, 'post' => $this->post]);
    }
}