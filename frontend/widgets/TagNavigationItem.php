<?php

namespace frontend\widgets;

use yii\base\Widget;

class TagNavigationItem extends Widget
{
    public $id;
    
    public $tag;
    
    public $tick = false;
    
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        TagNavigationItemAsset::register($view);

    }

    public function run()
    {
//        \Yii::$app->end($this->tick . ' ');
      return $this->render('tag-navigation-item',
            ['id' => $this->id,
            'tag' => $this->tag, 
             'tick' => boolval($this->tick)]);
    }
}