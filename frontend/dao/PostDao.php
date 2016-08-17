<?php
namespace frontend\dao;
use frontend\vo\BidVoBuilder;
use frontend\vo\PostVoBuilder;
class PostDao {
    const GET_POST_TAG = "select tag_name from post_tag where post_id = :post_id";
    
    const GET_POST_INFO = 
            "Select post_info.*, count(post_info.stuff_id) as total_bids  from(
             select post.*, user.id, user.username, user.profile_pic, user.first_name, user.last_name                    
             from post , user where post.stuff_id = :post_id
             and post.poster_id = user.id ) post_info
             left join bid on bid.stuff_id = post_info.stuff_id
             group by (post_info.stuff_id)";
    
    
    const GET_BID_LIST = "SELECT bid.* , user.id, user.first_name, user.last_name, user.username, user.profile_pic 
            from bid, user where bid.stuff_id = :stuff_id";
    
    public function getPostTag($post_id) {
        $results =  \Yii::$app->db
            ->createCommand(self::GET_POST_TAG)
            ->bindParam(':post_id', $post_id)
            ->queryAll();
        
        $simplify_results = array_column($results, 'tag_name');
        return $simplify_results;
 
    }
    
    public function getBidList($stuff_id) {
        $results = \Yii::$app->db
            ->createCommand(self::GET_BID_LIST)
            ->bindParam(':stuff_id', $stuff_id)
            ->queryAll();
        
        $bid_list = array();
        foreach($results as $result) {
            $bid = new BidVoBuilder();
            $bid->setCreatorFirstName($result['first_name']);
            $bid->setCreatorLastName($result['last_name']);
            $bid->setCreatorId($result['id']);
            $bid->setMessage($result['message']);
            $bid->setCreatorUsername($result['username']);
            $bid->setStuffId($result['stuff_id']);
            $bid->setCreatedAt($result['created_at']);
            $bid->setCreatorPhotoPath($result['profile_pic']);
            $bid_list[] = $bid->build();
        }
        
        return $bid_list;
    }
    
    public function getPostInfo($post_id, PostVoBuilder $builder) {
        $tags = $this->getPostTag($post_id);
        $result = \Yii::$app->db->createCommand(self::GET_POST_INFO)
                ->bindParam(':post_id', $post_id)
                ->queryOne();
        
        $builder->setDeadline($result['deadline']);
        $builder->setImage($result['photo_path']);
        $builder->setPostCreatorFirstName($result['first_name']);
        $builder->setPostCreatorLastName($result['last_name']);
        $builder->setTitle($result['title']);
        $builder->setDescription($result['description']);
        $builder->setPostCreatorId($result['stuff_id']);
        $builder->setPostCreatorUsername($result['username']);
        $builder->setPostCreatorPhotoPath($result['profile_pic']);
        $builder->setCreatedAt($result['created_at']);
        $builder->setTotalBids($result['total_bids']);
        $builder->setBidList($this->getBidList($post_id));
        return $builder;
    }
}