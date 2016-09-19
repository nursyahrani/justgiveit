<?php

namespace frontend\widgets;

use yii\base\Widget;

class PostList extends Widget
{
    public $id;
    
    public $posts;
    
    public $current_location = '';
    
    public function init()
    {
        parent::init();

    }

    
    public function run()
    {
        return $this->render('post-list',
            ['id' => $this->id, 'posts' => $this->posts,
                'current_location' => $this->current_location]);
    }
}