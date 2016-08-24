<?php

namespace frontend\widgets;

use yii\base\Widget;

class Login extends Widget
{
    public $id;
    
    public function init()
    {
        parent::init();

        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        LoginAsset::register($view);

    }

    public function run()
    {
        return $this->render('login',
            ['id' => $this->id]);
    }
}