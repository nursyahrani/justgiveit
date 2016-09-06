<?php

namespace frontend\widgets;

use yii\base\Widget;

class ShippingPreference extends Widget
{
    public $id;
    
    public function init()
    {
        parent::init();

        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        ShippingPreferenceAsset::register($view);

    }

    public function run()
    {
        return $this->render('shipping-preference-checkbox',
            ['id' => $this->id]);
    }
}