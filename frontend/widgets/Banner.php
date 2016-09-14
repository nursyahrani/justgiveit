<?php

namespace frontend\widgets;

use yii\base\Widget;
use Yii;
class Banner extends Widget
{
    public $id;
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        BannerAsset::register($view);

    }

    public function run()
    {
        if(Yii::$app->user->isGuest) {
            return $this->render('banner',
                ['id' => $this->id]);
        } else {
            return '';
        }
    }
}