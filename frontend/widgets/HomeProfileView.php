<?php

namespace frontend\widgets;

use yii\base\Widget;

class HomeProfileView extends Widget
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
        HomeProfileViewAsset::register($view);

    }

    public function run()
    {
        if(!\Yii::$app->user->isGuest) {

        return $this->render('home-profile-view',
            ['id' => $this->id, 'profile' => $this->profile]);
            
        }
    }
}