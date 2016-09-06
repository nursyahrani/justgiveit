<?php
namespace frontend\dao;

class PostCommentDao {
    const POST_COMMENT_INFO = "SELECT  * from user inner join post_comment on user.id = post_comment.user_id
             where post_comment.comment_id = :comment_id";
    
    const POST_COMMENT_LIST = "select * from user inner join post_comment on user.id = post_comment.user_id and post_comment.post_id = :post_id";
    
    
    public function getPostCommentInfo($comment_id) {
        $result =  \Yii::$app->db
            ->createCommand(self::POST_COMMENT_INFO)
            ->bindParam(':comment_id', $comment_id)
            ->queryOne();
        
        if($result === false) {
            return null;
        }
        
        $post_comment = new \frontend\vo\PostCommentVoBuilder();
        $post_comment->setCreatorFirstName($result['first_name']);
        $post_comment->setCreatorLastName($result['last_name']);
        $post_comment->setCreatorId($result['id']);
        $post_comment->setMessage($result['message']);
        $post_comment->setCreatorUsername($result['username']);
        $post_comment->setCreatedAt($result['created_at']);
        $post_comment->setCreatorPhotoPath($result['profile_pic']);
        $post_comment->setCommentId($result['comment_id']);
        return $post_comment->build();

    }
    
    public function getPostCommentList($post_id) {
        $results =  \Yii::$app->db
            ->createCommand(self::POST_COMMENT_LIST)
            ->bindParam(':post_id', $post_id)
            ->queryAll();
        
        if($results === false) {
            return null;
        }
        $post_comments = [];
        foreach($results as $result) {
            $post_comment = new \frontend\vo\PostCommentVoBuilder();
            $post_comment->setCreatorFirstName($result['first_name']);
            $post_comment->setCreatorLastName($result['last_name']);
            $post_comment->setCreatorId($result['id']);
            $post_comment->setMessage($result['message']);
            $post_comment->setCreatorUsername($result['username']);
            $post_comment->setCreatedAt($result['created_at']);
            $post_comment->setCreatorPhotoPath($result['profile_pic']);
            $post_comment->setCommentId($result['comment_id']);
            $post_comments[] = $post_comment->build();
        }
        
        return $post_comments;
        
    }
}   