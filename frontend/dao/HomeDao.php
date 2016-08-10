<?php
namespace frontend\dao;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use frontend\vo\HomeVoBuilder;
use frontend\vo\PostVoBuilder;
use common\models\Tag;
use frontend\dao\PostDao;

class HomeDao {
    
    const GET_ALL_STUFFS = "SELECT *  from post,user where post.poster_id = user.id";
    
    const GET_ALL_STUFFS_WITH_TAG = "SELECT *  from post,user, post_tag 
           where  post.poster_id = user.id
            and post_tag.post_id = post.stuff_id and post_tag.tag_name = :tag_name" ;
    private $post_dao;
    
    public function __construct() {
        $this->post_dao = new PostDao();
    }
    
    
   
    public function getAllGiveStuffs(HomeVoBuilder $builder, $tag = null){
                
        if($tag === null) {
            $results =  \Yii::$app->db
            ->createCommand(self::GET_ALL_STUFFS)
            ->queryAll();
        } else {
            $results =  \Yii::$app->db
            ->createCommand(self::GET_ALL_STUFFS_WITH_TAG)
            ->bindParam(':tag_name', $tag)
            ->queryAll();
        }
        
        $post_list = array();
        foreach($results as $result) {
            $post_builder = new PostVoBuilder();
            $post_builder->setPostId($result['stuff_id']);
            $post_builder->setDescription($result['description']);
            $post_builder->setTitle($result['title']);
            $post_builder->setImage($result['photo_path']);
            $post_builder->setPostCreatorId($result['poster_id']);
            $post_builder->setPostCreatorFirstName($result['first_name']);
            $post_builder->setPostCreatorLastName($result['last_name']);
            $post_builder->setPostCreatorUsername($result['username']);
            $post_builder->setPostCreatorPhotoPath($result['profile_pic']);
            $post_builder->setDeadline($result['deadline']);
            $post_tags = $this->post_dao->getPostTag($result['stuff_id']);
            $post_builder->setTags($post_tags);
            $post_list[] = $post_builder->build();
        }
        $builder->setPostList($post_list);
        return $builder;
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
}

