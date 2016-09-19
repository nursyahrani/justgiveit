<?php

namespace frontend\widgets;

use yii\base\Widget;

class PostSection extends Widget
{
    public $id;
    
    public $post;
    
    public function init()
    {
        parent::init();
    }


    public function run()
    {
        return $this->render('post-section',
            ['id' => $this->id, 'post' => $this->post]);
    }
}