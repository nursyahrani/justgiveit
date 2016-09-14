<?php

namespace frontend\widgets;

use yii\base\Widget;

class ConfirmationModal extends Widget
{
    public $id;
    
    public $text;
    
    public $title;
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        ConfirmationModalAsset::register($view);

    }   

    public function run()
    {
        return $this->render('confirmation-modal',
                ['id' => $this->id, 'text' => $this->text, 'title' => $this->title]);
    }
}