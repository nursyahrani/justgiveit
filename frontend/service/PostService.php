<?php
namespace frontend\service;

use frontend\vo\PostVoBuilder;
use frontend\dao\PostDao;
use common\libraries\UserLibrary;

class PostService {
    
    /**
     *
     * @var type frontend\dao\HomeDao
     */
    public $post_dao;
    
    public $home_dao;
    
    
    public $bid_dao;
    
    function __construct(PostDao $post_dao) {
        $this->post_dao = $post_dao;
        $this->home_dao = new \frontend\dao\HomeDao;
        $this->bid_dao = new \frontend\dao\BidDao;
    }
    
    
    public function getPostInfo($current_user_id, $id,  PostVoBuilder $builder ) {
        
        $builder = $this->post_dao->getPostInfo($current_user_id,$id, $builder);
        $suggested_post = $this->home_dao->getAllGiveStuffs($current_user_id, $builder->getTags()[0], 4);
        $builder->setSuggestedPost($suggested_post);
        if(UserLibrary::isOwner($builder->getPostCreatorId())) {
            
            $builder->setBidList($this->post_dao->getBidList($builder->getPostId()));   
        } else {
            $bid = $this->bid_dao->getCurrentUserBid($current_user_id,$builder->getPostId());
            $builder->setBidList(array($bid));
        }
        
        return $builder->build();
    }
    
}