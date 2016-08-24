<?php

namespace frontend\widgets;

use yii\base\Widget;

class SuggestedPost extends Widget
{
    public $id;
    
    public $post_list;
    
    public function init()
    {
        parent::init();

        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        SuggestedPostAsset::register($view);

    }

    public function run()
    {
        return $this->render('suggested-post',
            ['id' => $this->id, 'post_list' => $this->post_list]);
    }
}