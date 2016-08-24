<?php
namespace frontend\dao;
use frontend\vo\BidVoBuilder;
use frontend\vo\PostVoBuilder;
class PostDao {
    const GET_POST_TAG = "select tag_name from post_tag where post_id = :post_id";
    
    const GET_POST_INFO = " 
            SELECT stuff_with_bid_info.*, (for_has_favorited.user_id is not null) as has_favorited,
            count(for_total_favorites.stuff_id) as total_favorites
            FROM (
                Select post_info.*, 
                        count(for_total_bids.stuff_id) as total_bids,
                        (for_has_bid.proposer_id is not null) as has_bid
                 from(
                    select post.*, user.id as user_id, user.username, user.profile_pic, user.first_name, user.last_name                    
                    from post , user where post.stuff_id = :post_id
                 and post.poster_id = user.id ) post_info
                 left join bid for_total_bids
                 on for_total_bids.stuff_id = post_info.stuff_id
                 left join bid for_has_bid
                 on for_has_bid.stuff_id = post_info.stuff_id and post_info.user_id = :user_id
                 group by (post_info.stuff_id)) stuff_with_bid_info
            LEFT JOIN favorite for_total_favorites
            on for_total_favorites.stuff_id = stuff_with_bid_info.stuff_id
            LEFT JOIN favorite for_has_favorited
            on for_has_favorited.stuff_id = stuff_with_bid_info.stuff_id and stuff_with_bid_info.user_id = :user_id
            group by (stuff_with_bid_info.stuff_id)";
    
    const GET_BID_LIST = "SELECT bid.* , user.id, user.first_name, user.last_name, user.username, user.profile_pic 
            from bid, user where bid.stuff_id = :stuff_id and bid.proposer_id = user.id";
    
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
            $bid->setHasConfimed($result['confirm']);
            $bid->setHasObtained($result['obtain']);
            $bid->setCreatorPhotoPath($result['profile_pic']);
            $bid_list[] = $bid->build();
        }
        return $bid_list;
    }
    
    public function getPostInfo($current_user_id, $post_id, PostVoBuilder $builder) {
        $tags = $this->getPostTag($post_id);
        $result = \Yii::$app->db->createCommand(self::GET_POST_INFO)
                ->bindParam(':post_id', $post_id)
                ->bindParam(':user_id', $current_user_id)
                ->queryOne();
        
        $builder->setDeadline($result['deadline']);
        $builder->setImage($result['photo_path']);
        $builder->setPostCreatorFirstName($result['first_name']);
        $builder->setPostCreatorLastName($result['last_name']);
        $builder->setPostCreatorId($result['user_id']);
        $builder->setTitle($result['title']);
        $builder->setDescription($result['description']);
        $builder->setPostId($result['stuff_id']);
        $builder->setPostCreatorUsername($result['username']);
        $builder->setPostCreatorPhotoPath($result['profile_pic']);
        $builder->setTags($this->getPostTag($result['stuff_id']));
        $builder->setCreatedAt($result['created_at']);
        $builder->setTotalBids($result['total_bids']);
        $builder->setHasBid($result['has_bid']);
        $builder->setTotalFavorites($result['total_favorites']);
        $builder->setHasFavorited($result['has_favorited']);
        $builder->setPostId($result['stuff_id']);
        return $builder;
    }
}   