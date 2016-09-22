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
    
    const GET_PROFILE_INFO = "SELECT with_total_favorite.*, count(post.poster_id) as total_stuffs from (
                                                SELECT with_total_bid.*, count(*    ) as total_favorites from 
                                            (SELECT user.*, user_email_authentication.email, 	                                                                         user_email_authentication.validated,
                                                    count(bid.proposer_id) as total_bids, city.city_name, city.country_code,
                                                    country.country_default_name as country_name 
                                             from user 
                                             left join bid on user.id = bid.proposer_id 
                                             left join user_email_authentication on                                                                                        user_email_authentication.user_id = user.id
                                             left join city on city.city_id = user.city_id
                                             left join country on country.country_code = city.country_code
                                             where user.username = :username
                                            group by(bid.proposer_id)) with_total_bid
                                        left join favorite 
                                        on favorite.user_id = with_total_bid.id
                                        group by(favorite.user_id)
                                        ) with_total_favorite
                                    left join post
                                    on with_total_favorite.id = post.poster_id
                                    group by(post.poster_id)";
    
    const GET_MINI_PROFILE_AND_CITY_INFO = "SELECT user.id, user.city_id, city.city_name, city.country_code, country.country_default_name as country_name
                                            from user
                                            left join city
                                            on city.city_id = user.city_id
                                            left join country
                                            on country.country_code = city.country_code
                                            where user.id = :user_id
                                        ";
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
                                    image.image_id = post.image_id and post.post_status  <> 0
                                LIMIT :limit OFFSET :offset
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
            from bid, user where user.username = :username LIMIT :limit OFFSET :offset";
    
    const GET_HOME_PROFILE_VIEW = "   SELECT with_total_favorite.*, count(post.poster_id) as total_stuffs from (
                                                SELECT with_total_bid.*, count(*    ) as total_favorites from 
                                            (SELECT user.*, user_email_authentication.email, 	                                                                         user_email_authentication.validated,
                                                    count(bid.proposer_id) as total_bids 
                                             from user 
                                             left join bid on user.id = bid.proposer_id 
                                             left join user_email_authentication on                                                                                        user_email_authentication.user_id = user.id
                                             where user.id = :user_id
                                            group by(bid.proposer_id)) with_total_bid
                                        left join favorite 
                                        on favorite.user_id = with_total_bid.id
                                        group by(favorite.user_id)
                                        ) with_total_favorite
                                    left join post
                                    on with_total_favorite.id = post.poster_id
                                    group by(post.poster_id)";
    
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
        $builder->setTotalBids($result['total_bids']);
        $builder->setTotalFavorites($result['total_favorites']);
        $builder->setTotalGives($result['total_stuffs']);
        $builder->setUsername($result['username']);
        $builder->setIntro($result['intro']);
        $builder->setUserCityId($result['city_id']);
        $builder->setUserCityName($result['city_name']);
        $builder->setUserCountryCode($result['country_code']);
        $builder->setUserCountryName($result['country_name']);
        return $builder;
    }
    
    public function getStuffList($current_user_id, $username, $limit) {
        $offset = 0;
        $results =  \Yii::$app->db
            ->createCommand(self::GET_STUFF_LIST)
            ->bindParam(':user_id', $current_user_id)
            ->bindParam(':username', $username)
            ->bindParam(':limit', $limit)
            ->bindParam(':offset', $offset)
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
        
        return $stuff_list;
    }
    
    public function getBidList($username, $limit) {
        $offset = 0;        
        $results = \Yii::$app->db
            ->createCommand(self::GET_BID_LIST)
            ->bindParam(':username', $username)
            ->bindParam(':limit', $limit)
            ->bindParam(':offset', $offset)
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
        $builder->setEmail($result['email']);
        $builder->setValidated($result['validated']);
        return $builder->build();
        
    }
    
   public function getMiniProfileAndCityInfo($user_id, ProfileVoBuilder $builder) {
       $result = \Yii::$app->db
            ->createCommand(self::GET_MINI_PROFILE_AND_CITY_INFO)
            ->bindParam(':user_id', $user_id)
            ->queryOne();
        
       if(!$result) { 
           return $builder;
       }

       $builder->setUserCountryCode($result['country_code']);
       $builder->setUserId($result['id']);
       $builder->setUserCityId($result['city_id']);
       $builder->setUserCityName($result['city_name']);
       $builder->setUserCountryName($result['country_name']);
       
       return $builder;
   }
}

