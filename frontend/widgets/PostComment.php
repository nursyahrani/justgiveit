<?php

namespace frontend\widgets;

use yii\base\Widget;

class PostComment extends Widget
{
    public $id;
    
    public $post_comment;
    
    public function init()
    {
        parent::init();
    }

   
    public function run()
    {
        return $this->render('post-comment',
            ['id' => $this->id, 'post_comment' => $this->post_comment]);
    }
}