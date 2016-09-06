<?php
namespace frontend\service;

use frontend\vo\PostVoBuilder;
use frontend\dao\PostCommentDao;
use common\libraries\UserLibrary;

class PostCommentService {
    
    /**
     *
     * @var type frontend\dao\HomeDao
     */
    public $post_comment_dao;
    
    
    function __construct() {
        $this->post_comment_dao = new PostCommentDao();
    }
    
    function getCommentInfo($comment_id) {
        return $this->post_comment_dao->getPostCommentInfo($comment_id);
    }
    
    
    
}