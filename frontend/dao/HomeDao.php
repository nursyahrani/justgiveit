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
                        Select post_info.*, 
                                city.city_id, 
                                city.city_name, 
                                country.country_code, 
                                country.country_default_name as country_name, 
                                (starred.user_id is not null) as parameter
                        from  ( 
                            SELECT post.*, user.id, user.first_name, user.last_name,
                                user.profile_pic, user.username  , image.image_path as photo_path
                            from post,user,image, post_tag
                            where post.poster_id = user.id and image.image_id = post.image_id
                                and post.stuff_id not in ( :retrieved_post_ids) 
                                and  post_tag.post_id = post.stuff_id 
                                and( \":tags\" = \"''\" or post_tag.tag_name in ( :tags ) ) 
                                and (post_tag.tag_name LIKE :query  or
                                post.title LIKE :query) and post.post_status = 10
                            group by (post.stuff_id)
                            order by post.created_at desc
                            limit :limit
                        ) post_info
                        left join city
                        on post_info.pick_up_location_id = city.city_id
                        left join country
                        on country.country_code = city.country_code
                        left join post_tag
                        on post_tag.post_id = post_info.stuff_id
                        left join (Select user_id , tag.tag_name 
                                   from starred_tag, tag 
                                   where starred_tag.tag_id = tag.tag_id) starred
                        on starred.user_id =  :user_id and starred.tag_name =  post_tag.tag_name
                        where (\":countries\" = \"''\" or country.country_code in (:countries))  
                        group by (post_info.stuff_id)
                        order by parameter desc
                    ";
    
    
    const GET_MOST_POPULAR_STUFF = "SELECT post.stuff_id, post.title, count(post.stuff_id) as total_bids
            from post left join bid 
            on post.stuff_id = bid.stuff_id
            group by(post.stuff_id)
            order by(total_bids) desc
            limit 10";
    
    const SEARCH_CITY = "SELECT CONCAT(city_name, ' , ', country.country_default_name) as  text, 
            CONCAT(city_id) as id
            from country, city
            where country.country_code = city.country_code and 
                 (city.city_name LIKE :city or
                 country.country_default_name LIKE :city)
            limit :limit ";
    
    const SEARCH_COUNTRY_ONLY = "SELECT country.country_default_name as country_name, 
            country.country_code
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
            $post_builder->setType($result['type']);
            $post_builder->setCityId($result['city_id']);
            $post_builder->setCityName($result['city_name']);
            $post_builder->setCountryCode($result['country_code']);
            $post_builder->setCountryName($result['country_name']);
            $post_tags = $this->post_dao->getPostTag($result['stuff_id']);
            $post_builder->setTags($post_tags);
            $post_list[] = $post_builder->build();
        };
        return $post_list;
    
    }
   
    public function getAllGiveStuffs($current_user_id , $retrieved_post_ids, $search_query, $location, $tags, $countries,$limit = 15){
        $location = "%" . $location . "%";
        $search_query = "%" . $search_query . "%";
        $query = str_replace(':retrieved_post_ids', DatabaseLibrary::stringedItems($retrieved_post_ids), self::GET_ALL_STUFFS);
        $query = str_replace(':tags', DatabaseLibrary::stringedItems($tags), $query);
        $query = str_replace(':countries', DatabaseLibrary::stringedItems($countries), $query);
        $results =  \Yii::$app->db
            ->createCommand($query)
            ->bindParam(':user_id', $current_user_id)
            ->bindParam(':limit', $limit)
            ->bindParam(':query', $search_query)
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
    
    public function searchCountry($pre) {
        $pre = '%' . $pre . '%';
        $country_limit = 5;
        $results =  \Yii::$app->db
            ->createCommand(self::SEARCH_COUNTRY_ONLY)
            ->bindParam(':country', $pre)
            ->bindParam(':limit', $country_limit)
            ->queryAll();
        return $results;
    }
    
    public function searchCity($pre, $post = '-') {
        $city_limit = 5;
        $pre = '%' . $pre . '%';
        $results =  \Yii::$app->db
                ->createCommand(self::SEARCH_CITY)
                ->bindParam(':city', $pre)
                ->bindParam(':limit', $city_limit)
                ->queryAll();
        
        $data = array();
        foreach($results as $result) {
            $datum['id'] = $result['id'];
            $datum['text'] = $result['text'];
            $data[] = $datum;
        }
        return $data;
    }
}

