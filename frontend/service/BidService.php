<?php
namespace frontend\service;

use frontend\dao\BidDao;

class BidService {
    
    /**
     *
     * @var type frontend\dao\HomeDao
     */
    public $bid_dao;
    
    function __construct() {
        $this->bid_dao = new BidDao();
    }
    
    public function getBidReplyInfo($bid_reply_id) {
        return $this->bid_dao->getBidReplyInfo($bid_reply_id);
    }
    
    public function getMoreReplies($bid_id, $last_time, $offset) {
        return $this->bid_dao->getMoreReplies($bid_id, $last_time,$offset);
    }
    
}