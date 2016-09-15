<?php
namespace common\widgets;
use yii\base\Widget;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Loading extends Widget
{
    
    public $id;
    
    public $widget_class = '';
    
    public $align = '';
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }
    
    public function registerAssets() {
        $view = $this->getView();
        LoadingAsset::register($view);
    }

    public function run()
    {
        return $this->render('loading', ['id' => $this->id, 'align' => $this->align, 'widget_class' => $this->widget_class]);
    }
    
}
