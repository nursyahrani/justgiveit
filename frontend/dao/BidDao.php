<?php
namespace frontend\dao;
use frontend\vo\BidReplyVoBuilder;
use frontend\vo\BidVoBuilder;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class BidDao {
    const GET_CURRENT_USER_BID = "SELECT bid.* , user.id, user.first_name, user.last_name, user.username, user.profile_pic 
            from bid, user, post where bid.stuff_id = :stuff_id and bid.proposer_id = user.id and user.id = :user_id ";
    
    const GET_ONE_BID_REPLY_COMMENT =  
            "SELECT bid_reply.*, user.id, user.first_name, user.last_name, user.username,
            user.profile_pic
            from bid_reply, user
            where bid_reply.bid_id = :bid_id and bid_reply.user_id = user.id
            order by bid_reply.created_at desc
            limit 1";
            
    const GET_BID_REPLY_INFO = 
            "SELECT bid_reply.*, user.id, user.first_name, user.last_name, user.username,
            user.profile_pic
            from bid_reply, user
            where bid_reply.bid_reply_id = :bid_reply_id and bid_reply.user_id = user.id
            order by bid_reply.created_at desc
            limit 1";
    public function getCurrentUserBid($current_user_id, $post_id) {
        $result =  \Yii::$app->db
        ->createCommand(self::GET_CURRENT_USER_BID)
        ->bindParam(':stuff_id', $post_id)
        ->bindParam(':user_id', $current_user_id)
        ->queryOne();
        
        if($result === false) {
            return null;
        }
        
        $bid = new BidVoBuilder();
        $bid->setBidId($result['bid_id']);
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
        $bid->setChosenBidReply($this->getOneBidReply($result['bid_id']));
        return $bid->build();
    }
            
    public function getOneBidReply($bid_id) {
        $result =  \Yii::$app->db
        ->createCommand(self::GET_ONE_BID_REPLY_COMMENT)
        ->bindParam(':bid_id', $bid_id)
        ->queryOne();
        
        if($result === false) {
            return null;
        }
        
        $bid = new BidReplyVoBuilder();
        $bid->setBidId($result['bid_id']);
        $bid->setCreatorFirstName($result['first_name']);
        $bid->setCreatorLastName($result['last_name']);
        $bid->setCreatorId($result['id']);
        $bid->setBidReplyId($result['bid_reply_id']);
        $bid->setMessage($result['message']);
        $bid->setCreatorUsername($result['username']);
        $bid->setCreatedAt($result['created_at']);
        $bid->setCreatorPhotoPath($result['profile_pic']);
        
        return $bid->build();
    }
    
    public function getBidReplyInfo($bid_reply_id) {
        $result =  \Yii::$app->db
        ->createCommand(self::GET_BID_REPLY_INFO)
        ->bindParam(':bid_reply_id', $bid_reply_id)
        ->queryOne();
        if($result === false) {
            return null;
        }
        
        $bid = new BidReplyVoBuilder();
        $bid->setBidId($result['bid_id']);
        $bid->setCreatorFirstName($result['first_name']);
        $bid->setCreatorLastName($result['last_name']);
        $bid->setCreatorId($result['id']);
        $bid->setBidReplyId($result['bid_reply_id']);
        $bid->setMessage($result['message']);
        $bid->setCreatorUsername($result['username']);
        $bid->setCreatedAt($result['created_at']);
        $bid->setCreatorPhotoPath($result['profile_pic']);
        
        return $bid->build();
    }
}

