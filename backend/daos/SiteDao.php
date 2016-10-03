<?php
namespace backend\daos;

class SiteDao {
    
    const MOST_POPULAR_TAG = 
            "select post_tag.tag_name, count(post_tag.tag_name) as amount from
            post inner join post_tag
            where post.stuff_id = post_tag.post_id
            group by(post_tag.tag_name) desc
            limit 6";
    
    const REGISTERED_USER_BY_COUNTRY = 
            "select country.country_default_name as name, count(country.country_default_name) as amount 
            from user 
            inner join city 
            on user.city_id = city.city_id 
            inner join country 
            on country.country_code = city.country_code 
            group by (country.country_default_name) 
            limit 6"
        ;
    const ITEMS_BY_COUNTRY =
            "select country.country_default_name as name, count(country.country_default_name) as amount 
            from post 
            inner join city 
            on post.pick_up_location_id = city.city_id 
            inner join country 
            on country.country_code = city.country_code 
            group by (country.country_default_name) 
            limit 6
            ";
    
    const ITEMS_BY_DAY = 
            "select DATEDIFF(FROM_UNIXTIME(:time), FROM_UNIXTIME(post.created_at)) as days,
            count( DATEDIFF(FROM_UNIXTIME(:time), FROM_UNIXTIME(post.created_at))) as amount
            from post
            where DATEDIFF(FROM_UNIXTIME(:time), FROM_UNIXTIME(post.created_at)) < 14
            group by(days)
            order by days desc
                ";
    
    public function getMostPopularTags() {
        $results =  \Yii::$app->db
                    ->createCommand(self::MOST_POPULAR_TAG)
                    ->queryAll();
        $convert = [];
        $convert[] = ['Items', 'Amount'];
        foreach($results as $result) {
            $convert[] = [$result['tag_name'], intval($result['amount'])];
        }
        return $convert;
    }
    
    public function getItemsByCountry() {
        $results =  \Yii::$app->db
                    ->createCommand(self::ITEMS_BY_COUNTRY)
                    ->queryAll();
        $convert = [];
        $convert[] = ['Country', 'Amount'];
        foreach($results as $result) {
            $convert[] = [$result['name'], intval($result['amount'])];
        }
        return $convert;
    }
    
    public function getItemsByDay($limit = 14) {
        $time = time();
        
        $results =  \Yii::$app->db
                    ->createCommand(self::ITEMS_BY_DAY)
                    ->bindParam(':time', $time)
                    ->bindParam(':limit', $limit)
                    ->queryAll();   
        
        $convert = [];
        $convert[] = ['Items', 'Days ago'];
        
        foreach($results as $result) {
       
            $convert[] = [$result['days'], intval($result['amount'])];
            
        }
        return $convert;
    }
    
    public function getRegisteredUserByCountry() {
        $results =  \Yii::$app->db
                    ->createCommand(self::REGISTERED_USER_BY_COUNTRY)
                    ->queryAll();
        $convert = [];
        $convert[] = ['Country', 'Amount'];
        foreach($results as $result) {
            $convert[] = [$result['name'], intval($result['amount'])];
        }
        return $convert;
        
    }
}