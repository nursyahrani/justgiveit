<?php
namespace frontend\widgets;

use yii\base\Widget;
class ProfilePostList extends Widget {
    public $id;
    
    public $post_list;
    
    public $columns;
    
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('profile-post-list',
            ['id' => $this->id, 'post_list' => $this->post_list, 'columns' => $this->columns]);
    }
}