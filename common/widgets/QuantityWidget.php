<?php
namespace common\widgets;
use yii\base\Widget;

class QuantityWidget extends Widget
{
    
    public $id;
    
    public $max_value;
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }
    
    public function registerAssets() {
        $view = $this->getView();
        QuantityWidgetAsset::register($view);
    }

    public function run()
    {
        return $this->render('quantity', ['id' => $this->id, 'max_value' => $this->max_value]);
    }
    
}
