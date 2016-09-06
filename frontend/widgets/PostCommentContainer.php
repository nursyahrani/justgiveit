<?php

namespace frontend\widgets;

use yii\base\Widget;

class PostCommentContainer extends Widget
{
    public $id;
    
    public $post_comments;
    
    public $post_id;
    
    public function init()
    {
        parent::init();

        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        PostCommentContainerAsset::register($view);

    }

    public function run()
    {
        return $this->render('post-comment-container',
            ['id' => $this->id , 'post_id' => $this->post_id, 'post_comments' => $this->post_comments]);
    }
}