<?php
namespace common\widgets;
use yii\base\Widget;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SimpleSideNav extends Widget
{
    
    public $id;
    public $items;
    
    public $title;
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }
    
    public function registerAssets() {
        $view = $this->getView();
        SimpleSideNavAsset::register($view);
    }

    public function run()
    {
        return $this->render('simple-side-nav', 
                ['id' => $this->id, 
                'title' => $this->title,
                'items' => $this->items ]);
    }
    
}
