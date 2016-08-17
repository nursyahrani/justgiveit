<?php
namespace common\widgets;
use yii\base\Widget;
use common\libraries\CommonLibrary;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ButtonWithTooltip extends Widget
{
    
    public $id;
    
    public $button_class;
    
    public $text;
    
    public $tooltip_text;
    
    public $button_options;
    
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }
    
    public function registerAssets() {
        $view = $this->getView();
        ButtonWithTooltipAsset::register($view);
            
    }

    public function run()
    {
        return $this->render('button-with-tooltip', 
                ['button_class' => $this->button_class, 
                'id' => $this->id, 'text' => $this->text,
                'tooltip_text' => $this->tooltip_text, 
                    'button_options' => $this->button_options]);
    }
    
}
