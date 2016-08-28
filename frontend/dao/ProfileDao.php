<?php
namespace frontend\dao;
use frontend\vo\ProfileVoBuilder;
use frontend\vo\BidVoBuilder;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ProfileDao {
    
    const GET_PROFILE_INFO = "SELECT user.* from user where user.username = :username";
    
    const GET_STUFF_LIST = "SELECT stuff_with_bid_info.*,
                                count(for_total_favorites.user_id) as total_favorites,
                                (has_favorited.user_id is not null) as has_favorited
                        from (    
                            SELECT stuff_info.*,
                                   count(bid1.proposer_id) as total_bids ,
                                   (bid2.proposer_id is not null) as has_bid
                                   
                            FROM (
                                SELECT post.*, user.id, user.first_name, user.last_name,
                                    user.profile_pic, user.username  , image.image_path as photo_path
                                from post,user, image
                                where post.poster_id = user.id and user.username = :username and
                                    image.image_id = post.image_id
                                ) stuff_info
                                
                            LEFT JOIN bid bid1
                            on stuff_info.stuff_id = bid1.stuff_id
                            LEFT JOIN bid bid2
                            on stuff_info.stuff_id = bid2.stuff_id and bid2.proposer_id = :user_id
                            group by (stuff_info.stuff_id)) stuff_with_bid_info
                        LEFT join favorite for_total_favorites
                        on stuff_with_bid_info.stuff_id = for_total_favorites.stuff_id
                        LEFT join favorite has_favorited
                        on stuff_with_bid_info.stuff_id = has_favorited.stuff_id and
                            has_favorited.user_id = :user_id
                        group by (stuff_with_bid_info.stuff_id)  ";
    
    const GET_BID_LIST = "SELECT bid.* , user.id, user.first_name, user.last_name, user.username, user.profile_pic 
            from bid, user where user.username = :username";
    
    const GET_HOME_PROFILE_VIEW = "   SELECT with_total_favorite.*, count(with_total_favorite.id) as total_stuffs from (
                                                SELECT with_total_bid.*, count(with_total_bid.id) as total_favorites from 
                                            (SELECT user.*, count(user.id) as total_bids from user left join bid on user.id = bid.proposer_id 
                                             where user.id = :user_id
                                            group by(user.id)) with_total_bid
                                        left join favorite 
                                        on favorite.user_id = with_total_bid.id
                                        group by(with_total_bid.id)
                                        ) with_total_favorite
                                    left join post
                                    on with_total_favorite.id = post.poster_id
                                    group by(with_total_favorite.id)";
    private $post_dao;
    
    public function __construct() {
        $this->post_dao = new PostDao();
    }
    
    public function getProfileInfo($username, \frontend\vo\ProfileVoBuilder $builder) {
        $result =  \Yii::$app->db
            ->createCommand(self::GET_PROFILE_INFO)
            ->bindParam(':username', $username)
            ->queryOne();
        
        $builder->setLastName($result['last_name']);
        $builder->setFirstName($result['first_name']);
        $builder->setProfilePic($result['profile_pic']);
        $builder->setUserId( $result['id']);
        $builder->setUsername($result['username']);
        return $builder;
    }
    
    public function getStuffList($current_user_id, $username, ProfileVoBuilder $builder ) {
        $results =  \Yii::$app->db
            ->createCommand(self::GET_STUFF_LIST)
                ->bindParam(':user_id', $current_user_id)
            ->bindParam(':username', $username)
            ->queryAll();
        $stuff_list = array();
        foreach($results as $result) {
            $post_builder = new \frontend\vo\PostVoBuilder();
            $post_builder->setPostId($result['stuff_id']);
            $post_builder->setDescription($result['description']);
            $post_builder->setTitle($result['title']);
            $post_builder->setImage($result['photo_path']);
            $post_builder->setCreatedAt($result['created_at']);
            $post_builder->setPostCreatorId($result['poster_id']);
            $post_builder->setPostCreatorFirstName($result['first_name']);
            $post_builder->setPostCreatorLastName($result['last_name']);
            $post_builder->setPostCreatorUsername($result['username']);
            $post_builder->setPostCreatorPhotoPath($result['profile_pic']);
               $post_builder->setTotalBids($result['total_bids']);
            $post_builder->setHasBid($result['has_bid']);
            $post_builder->setTotalFavorites($result['total_favorites']);
            $post_builder->setHasFavorited($result['has_favorited']);
            $post_tags = $this->post_dao->getPostTag($result['stuff_id']);
            $post_builder->setTags($post_tags);
         
            $stuff_list[] = $post_builder->build();
        }
        
        $builder->setGiveList($stuff_list);
        return $builder;
    }
    
    public function getBidList($username, \frontend\vo\ProfileVoBuilder $builder) {
        $results = \Yii::$app->db
            ->createCommand(self::GET_BID_LIST)
            ->bindParam(':username', $username)
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
        $builder->setBidList($bid_list);
        
        return $builder;
    
    }
    
    public function getHomeProfileView($user_id) {
        $result = \Yii::$app->db
            ->createCommand(self::GET_HOME_PROFILE_VIEW)
            ->bindParam(':user_id', $user_id)
            ->queryOne();
        
        $builder = new ProfileVoBuilder();
        $builder->setFirstName($result['first_name']);
        $builder->setLastName($result['last_name']);
        $builder->setProfilePic($result['profile_pic']);
        $builder->setUsername($result['username']);
        $builder->setTotalBids($result['total_bids']);
        $builder->setTotalGives($result['total_stuffs']);
        $builder->setTotalFavorites($result['total_favorites']);
        
        return $builder->build();
        
    }
    
   
}

