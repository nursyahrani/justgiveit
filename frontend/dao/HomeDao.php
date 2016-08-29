<?php
namespace frontend\dao;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use frontend\vo\HomeVoBuilder;
use frontend\vo\PostVoBuilder;
use common\libraries\DatabaseLibrary;
use common\models\Tag;
use frontend\dao\PostDao;

class HomeDao {
    
    const GET_ALL_STUFFS = "
                        SELECT stuff_with_bid_info.*,
                                count(for_total_favorites.user_id) as total_favorites,
                                (has_favorited.user_id is not null) as has_favorited
                        from (    
                            SELECT stuff_info.*,
                                   count(bid1.proposer_id) as total_bids ,
                                   (bid2.proposer_id is not null) as has_bid
                            FROM (
                                SELECT post.*, user.id, user.first_name, user.last_name,
                                    user.profile_pic, user.username  , image.image_path as photo_path
                                from post,user,image, city, post_tag
                                where post.poster_id = user.id and image.image_id = post.image_id
                                    and post.stuff_id not in ( :retrieved_post_ids) and user.city_id = city.city_id
                                    and  post_tag.post_id = post.stuff_id and (city.city_id LIKE :location or
                                    city.country_code LIKE :location) and (post_tag.tag_name LIKE :query  or
                                    post.title LIKE :query)
                                group by (post.stuff_id)
                                order by post.created_at desc
                                limit :limit) stuff_info
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
                        group by (stuff_with_bid_info.stuff_id)
                        order by stuff_with_bid_info.created_at desc
                        ";
    
    const GET_ALL_STUFFS_WITH_TAG = "
          SELECT stuff_with_bid_info.*,
                                count(for_total_favorites.user_id) as total_favorites,
                                (has_favorited.user_id is not null) as has_favorited
                        from (    
                            SELECT stuff_info.*,
                                   count(bid1.proposer_id) as total_bids ,
                                   (bid2.proposer_id is not null) as has_bid
                                   
                            FROM (
                                SELECT post.*, user.id, user.first_name, user.last_name,
                                    user.profile_pic, user.username , image.image_path as photo_path 
                                from post,user , post_tag, image
                                where post.poster_id = user.id  and image.image_id = post.image_id
            and post_tag.post_id = post.stuff_id and post_tag.tag_name = :tag_name
            limit :limit) stuff_info
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
                        group by (stuff_with_bid_info.stuff_id)  
" ;
    
    const GET_MOST_POPULAR_STUFF = "SELECT post.stuff_id, post.title, count(post.stuff_id) as total_bids
            from post left join bid 
            on post.stuff_id = bid.stuff_id
            group by(post.stuff_id)
            order by(total_bids) desc
            limit 10";
    
    const SEARCH_CITY = "SELECT CONCAT(city_name, country.country_default_name) as  text, 
            CONCAT(city_id) as id
            from country, city
            where country.country_code = city.country_code and 
                 (country.country_default_name LIKE :country or
                 city.city_name LIKE :city )
            limit :limit";
    
    const SEARCH_COUNTRY_ONLY = "SELECT country_code as id , country_default_name as text
            from country 
            where country.country_default_name LIKE :country
            limit :limit";
    
    const GET_CURRENT_USER_LOCATION_TEXT_FOR_SEARCH = 
            "SELECT country.country_code as id, country.country_default_name as text
            from user, city, country
            where user.id = :user_id and city.city_id = user.city_id 
            and city.country_code = country.country_code ";
    
    private $post_dao;
    
    public function __construct() {
        $this->post_dao = new PostDao();
    }
    
    public function getCurrentUserLocationTextForSearch($user_id) {
        $result =  \Yii::$app->db
        ->createCommand(self::GET_CURRENT_USER_LOCATION_TEXT_FOR_SEARCH)
                ->bindParam(':user_id', $user_id)
        ->queryOne();
        
       if($result === null) {
            $result = array();
            $result['id'] = 'SG';
            $result['text'] = 'Singapore';
        }
        return $result;
    }
    
    public function getMostPopularStuff() {
        $results =  \Yii::$app->db
        ->createCommand(self::GET_MOST_POPULAR_STUFF)
        ->queryAll();
        $post_vos = array();
        foreach($results as $item) {
            $post_builder = new PostVoBuilder();
            $post_builder->setTitle($item['title']);
            $post_builder->setPostId($item['stuff_id']);
            $post_vos[] = $post_builder->build();
        }
        
        return $post_vos;
        
    }
    
    private function buildPost($results) {
        $post_list = array();
        foreach($results as $result) {
            $post_builder = new PostVoBuilder();
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
            $post_builder->setDeadline($result['deadline']);
            $post_builder->setTotalBids($result['total_bids']);
            $post_builder->setHasBid($result['has_bid']);
            $post_builder->setTotalFavorites($result['total_favorites']);
            $post_builder->setHasFavorited($result['has_favorited']);
            $post_tags = $this->post_dao->getPostTag($result['stuff_id']);
            $post_builder->setTags($post_tags);
            $post_list[] = $post_builder->build();
        };
        return $post_list;
    
    }
   
    public function getAllGiveStuffs($current_user_id , $retrieved_post_ids, $search_query, $location, $limit = 5){
        $location = "%" . $location . "%";
        $search_query = "%" . $search_query . "%";
        
        if(DatabaseLibrary::checkEligibility($retrieved_post_ids)) {
            $query = str_replace(':retrieved_post_ids', $retrieved_post_ids, self::GET_ALL_STUFFS);

        } else {
            $query = str_replace(':retrieved_post_ids', '0', self::GET_ALL_STUFFS);
        }
        $results =  \Yii::$app->db
            ->createCommand($query)
            ->bindParam(':user_id', $current_user_id)
            ->bindParam(':limit', $limit)
            ->bindParam(':location', $location)
            ->bindParam(':query', $search_query)
            ->queryAll();
        
        
        return $this->buildPost($results);
    }
    
    public function getAllGiveStuffsWithTag($current_user_id, $retrieved_post_ids, $tag, $limit = 5) {
        if(DatabaseLibrary::checkEligibility($retrieved_post_ids)) {
            $query = str_replace(':retrieved_post_ids', $retrieved_post_ids, self::GET_ALL_STUFFS_WITH_TAG);

        } else {
            $query = str_replace(':retrieved_post_ids', '', self::GET_ALL_STUFFS_WITH_TAG);
        }
        $results =  \Yii::$app->db
            ->createCommand($query)
            ->bindParam(':user_id', $current_user_id)
            ->bindParam(':limit', $limit)
            ->bindParam(':tag', $tag)
            ->queryAll();
        
        
        return $this->buildPost($results);
    }
    
    public function searchIssue($query) {
        $results = Tag::find()->select(['tag_name'])->where(['like','tag_name', $query])->all();
        $data = array();
        foreach($results as $result) {
            $datum['id'] = $result['tag_name'];
            $datum['text'] = $result['tag_name'];
            $data[] = $datum;
        }
        
        return $data;
    }
    
    public function searchCountryCity($pre, $post = NULL) {
        $pre = '%' . $pre . '%';
       
        if($post === null) {
            $post = '%%';
            $country_limit = 2;
            $results_country =  \Yii::$app->db
                ->createCommand(self::SEARCH_COUNTRY_ONLY)
                ->bindParam(':country', $pre)
                ->bindParam(':limit', $country_limit)
                ->queryAll();
            $city_limit = 5 - count($results_country);
            $results_city =  \Yii::$app->db
                ->createCommand(self::SEARCH_CITY)
                ->bindParam(':city', $pre)
                ->bindParam(':country', $post )
                ->bindParam(':limit', $city_limit)
                ->queryAll();
            $results = array_merge($results_country, $results_city);
            
            


        } else {
            $post = '%' . $post. '%';
            $results_city =  \Yii::$app->db
                ->createCommand(self::SEARCH_CITY)
                ->bindParam(':city', $pre)
                ->bindParam(':country', $post)
                ->bindParam(':limit', 5)
                ->queryAll();
        }
        $data = array();
        foreach($results as $result) {
            $datum['id'] = $result['id'];
            $datum['text'] = $result['text'];
            $data[] = $datum;
        }
        
        return $data;
    }
}

