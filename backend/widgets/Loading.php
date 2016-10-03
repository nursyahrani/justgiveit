<?php
namespace backend\widgets;
use yii\base\Widget;

class Loading extends Widget
{
    
    public $id;
    
    public $widget_class = '';
    
    public $align = '';
    
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('loading', ['id' => $this->id, 'align' => $this->align, 'widget_class' => $this->widget_class]);
    }
    
}
