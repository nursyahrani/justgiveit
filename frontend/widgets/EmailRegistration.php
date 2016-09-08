<?php

namespace frontend\widgets;

use yii\base\Widget;

class EmailRegistration extends Widget
{
    public $id;
    
    public $profile;
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        EmailRegistrationAsset::register($view);

    }   

    public function run()
    {
        if(!\Yii::$app->user->isGuest) {

            return $this->render('email-registration',['id' => $this->id, 'profile' => $this->profile]);
        }
    }
}