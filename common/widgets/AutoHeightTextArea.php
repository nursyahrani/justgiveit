<?php
namespace common\widgets;
use yii\base\Widget;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AutoHeightTextArea extends Widget
{
    
    public $widget_class;
    
    public $placeholder;
    
    public $rows; 
    
    public $options;
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }
    
    public function registerAssets() {
        $view = $this->getView();
        
        AutoHeightTextAreaAsset::register($view);
            
    }

    public function run()
    {
        
        if($this->rows === null ) {
            $this->rows = 1;
        }
        
        return $this->render('auto-height-text-area', 
                ['widget_class' => $this->widget_class, 
                'placeholder' => $this->placeholder,
                    'rows' => $this->rows
                 ]);
    }
    
}
