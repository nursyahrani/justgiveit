<?php
namespace frontend\service;

use frontend\vo\PostVoBuilder;
use frontend\dao\PostDao;

class PostService {
    
    /**
     *
     * @var type frontend\dao\HomeDao
     */
    public $post_dao;
    
    function __construct(PostDao $post_dao) {
        $this->post_dao = $post_dao;
    }
    
    
    public function getPostInfo($current_user_id, $id, PostVoBuilder $builder ) {
        
        $builder = $this->post_dao->getPostInfo($id, $builder);
        
        return $builder->build();
    }
    
}