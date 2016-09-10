<?php
namespace frontend\dao;

use frontend\vo\TagVoBuilder;

class TagDao {
    
    const GET_TAG = "SELECT tag.tag_name, tag.tag_id, (starred_tag.tag_id is not null) as starred
                    FROM tag
                    left join starred_tag
                    on tag.tag_id = starred_tag.tag_id and starred_tag.user_id = :user_id
                    where tag.tag_name = :tag";
    
    const SEARCH_TAG = "SELECT tag.tag_name, tag.tag_id, (starred_tag.tag_id is not null) as starred
                        FROM tag
                        left join starred_tag
                        on tag.tag_id = starred_tag.tag_id and starred_tag.user_id = :user_id
                        where tag.tag_name LIKE :query
                        ";
    
    
    const GET_MOST_POPULAR_TAG = " SELECT most_popular_tag.*, (starred_tag.tag_id is not null) as starred from (
                                    select post_tag.tag_name, tag.tag_id, count(post_tag.tag_name) as total_posts
                                    from post_tag, tag
                                    where post_tag.tag_name = tag.tag_name 
                                    
                                    group by (post_tag.tag_name)
                                    order by (total_posts) desc
                                    limit 3) most_popular_tag
                                    left join starred_tag
                                    on most_popular_tag.tag_id = starred_tag.tag_id";
    
    const GET_STARRED_TAG = "SELECT tag.tag_id, tag.tag_name
                            from starred_tag, tag
                            where starred_tag.tag_id = tag.tag_id and starred_tag.user_id = :user_id";
    
    public function searchTag($query , $user_id) {
        $query = '%' . $query . '%';
        $results =  \Yii::$app->db
            ->createCommand(self::SEARCH_TAG)
            ->bindParam(':user_id', $user_id)
            ->bindParam(':query', $query)
            ->queryAll();
        $tag_list = array();
        foreach($results as $result) {
            $builder = new TagVoBuilder();
            $builder->setStarred($result['starred']);
            $builder->setTagId($result['tag_id']);
            $builder->setTagName($result['tag_name']);
            $tag_list[] = $builder->build();
        }
    
        return $tag_list;
    }
    
    public function getStarredTag($user_id) {
        $results =  \Yii::$app->db
            ->createCommand(self::GET_STARRED_TAG)
            ->bindParam(':user_id', $user_id)
            ->queryAll();
        $tag_list = array();
        foreach($results as $result) {
            $builder = new TagVoBuilder();
            $builder->setStarred(1);
            $builder->setTagId($result['tag_id']);
            $builder->setTagName($result['tag_name']);
            $tag_list[] = $builder->build();
        }
    
        return $tag_list;
    }
    
    public function getMostPopularTag($user_id) {
        $results =  \Yii::$app->db
            ->createCommand(self::GET_MOST_POPULAR_TAG)
            ->bindParam(':user_id', $user_id)
            ->queryAll();
        $tag_list = array();
        foreach($results as $result) {
            $builder = new TagVoBuilder();
            $builder->setStarred($result['starred']);
            $builder->setTagId($result['tag_id']);
            $builder->setTagName($result['tag_name']);
            $tag_list[] = $builder->build();
        }
    
        return $tag_list;
    }
    
    public function getTag($tag, $user_id) {
        $result =  \Yii::$app->db
            ->createCommand(self::GET_TAG)
            ->bindParam(':user_id', $user_id)
            ->bindParam(':tag', $tag)
            ->queryOne();
        $builder = new TagVoBuilder();
        $builder->setStarred($result['starred']);
        $builder->setTagId($result['tag_id']);
        $builder->setTagName($result['tag_name']);
        return $builder->build();
    }
}