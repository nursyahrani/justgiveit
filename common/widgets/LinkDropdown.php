<?php
namespace common\widgets;
use yii\base\Widget;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LinkDropdown extends Widget
{
    public $label;      
    
    public $items;
    
    public $button_class;
    
    public $id;
        
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }
    
    public function registerAssets() {
        $view = $this->getView();
        LinkDropdownAsset::register($view);
            
    }

    public function run()
    {
        return $this->render('link-dropdown', 
                ['items' => $this->items, 
                 'id' => $this->id,
                'button_class' => $this->button_class,
                 'label' => $this->label
                ]);
    }
}
