<?php
namespace common\widgets;
use yii\base\Widget;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AlertBox extends Widget
{
    public $id;
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }
    
    public function registerAssets() {
        $view = $this->getView();
        
        AlertBoxAsset::register($view);
            
    }

    public function run()
    {
        return $this->render('alert-box', ['id' => $this->id]);
    }
    
}
