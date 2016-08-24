<?php
namespace frontend\dao;
use frontend\vo\ProfileVoBuilder;
use frontend\vo\BidVoBuilder;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class BidDao {
    const GET_CURRENT_USER_BID = "SELECT bid.* , user.id, user.first_name, user.last_name, user.username, user.profile_pic 
            from bid, user, post where bid.stuff_id = :stuff_id and bid.proposer_id = user.id and user.id = :user_id ";
    
            
            
    public function getCurrentUserBid($current_user_id, $post_id) {
        $result =  \Yii::$app->db
        ->createCommand(self::GET_CURRENT_USER_BID)
        ->bindParam(':stuff_id', $post_id)
        ->bindParam(':user_id', $current_user_id)
        ->queryOne();
        
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
        return $bid->build();
    }
            
   
}

