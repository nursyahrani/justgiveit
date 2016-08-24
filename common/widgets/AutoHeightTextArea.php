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
    
    public $id;
    
    public $widget_class = ''; 
    
    public $placeholder = '';
    
    public $rows = 1; 
    
    public $value = '';
    
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
        
        return $this->render('auto-height-text-area', 
                ['id' => $this->id,
                'widget_class' => $this->widget_class, 
                'placeholder' => $this->placeholder,
                    'rows' => $this->rows,
                    'value' => $this->value
                 ]);
    }
    
}
