<?php
namespace frontend\service;
use frontend\dao\TagDao;

class TagService {
    /**
     *
     * @var type frontend\dao\HomeDao
     */
    public $tag_dao;
    
    function __construct() {
        $this->tag_dao = new TagDao;
    }
    public function searchTag($query, $user_id) {
        return $this->tag_dao->searchTag($query, $user_id);
    }
    
    public function getTag($tag, $user_id) {
        return $this->tag_dao->getTag($tag, $user_id);
    }
}