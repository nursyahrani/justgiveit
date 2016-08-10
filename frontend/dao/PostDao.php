<?php
namespace frontend\dao;

class PostDao {
    const GET_POST_TAG = "select tag_name from post_tag where post_id = :post_id";
    
    public function getPostTag($post_id) {
        $results =  \Yii::$app->db
            ->createCommand(self::GET_POST_TAG)
                ->bindParam(':post_id', $post_id)
            ->queryAll();
        
        $simplify_results = array_column($results, 'tag_name');
        return $simplify_results;
 
    }
}