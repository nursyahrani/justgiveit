<?php

namespace frontend\widgets;

use yii\base\Widget;

class UploadPhoto extends Widget
{
    public $id;
    
    public $initial_path;
    
    public function init()
    {
        parent::init();

        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        UploadPhotoAsset::register($view);

    }

    public function run()
    {
        return $this->render('upload-photo',
            ['id' => $this->id]);
    }
}