<?php

namespace frontend\widgets;

use yii\base\Widget;

class ImageViewEditor extends Widget
{
    public $id;
    
    public $post;
    
    public $active;
    public function init()
    {
        parent::init();

        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        ImageViewEditorAsset::register($view);

    }

    public function run()
    {
        return $this->render('image-view-editor',
            ['id' => $this->id, 'post' => $this->post, 'active' => $this->active]);
    }
}