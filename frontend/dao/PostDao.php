<?php
namespace frontend\dao;
use frontend\vo\BidVoBuilder;
use frontend\vo\PostVoBuilder;
class PostDao {
    const GET_POST_TAG = "select tag_name from post_tag where post_id = :post_id";
    
    const GET_POST_INFO = " 
        SELECT stuff_with_bid_favorites.*, count(for_total_comments.post_id) as total_comments
        FROM(
            SELECT stuff_with_bid_info.*, (for_has_favorited.user_id is not null) as has_favorited,
            count(for_total_favorites.stuff_id) as total_favorites
            FROM (
                Select post_info.*, 
                        count(for_total_bids.stuff_id) as total_bids,
                        (for_has_bid.proposer_id is not null) as has_bid
                 from(
                    select post.*, image.image_path as photo_path,
                    user.id as user_id, user.username, user.profile_pic, user.first_name, user.last_name                    
                    
                    from post , user, image 
                    where post.stuff_id = :post_id and image.image_id = post.image_id
                    
                 and post.poster_id = user.id ) post_info
                 left join bid for_total_bids
                 on for_total_bids.stuff_id = post_info.stuff_id
                 left join bid for_has_bid
                 on for_has_bid.stuff_id = post_info.stuff_id and for_has_bid.proposer_id = :user_id
                 group by (post_info.stuff_id)) stuff_with_bid_info
            LEFT JOIN favorite for_total_favorites
            on for_total_favorites.stuff_id = stuff_with_bid_info.stuff_id
            LEFT JOIN favorite for_has_favorited
            on for_has_favorited.stuff_id = stuff_with_bid_info.stuff_id and for_has_favorited.user_id = :user_id
            group by (stuff_with_bid_info.stuff_id)
            ) stuff_with_bid_favorites
        LEFT JOIN post_comment for_total_comments
        on stuff_with_bid_favorites.stuff_id = for_total_comments.post_id
        group by(stuff_with_bid_favorites.stuff_id)";
    
    const GET_BID_LIST = "SELECT bid_info.*, count(bid_reply.bid_id) as total_replies from(
                        SELECT bid.* , user.id, user.first_name, user.last_name, 			user.username, user.profile_pic
                       from bid, user
                       where bid.stuff_id = :stuff_id and bid.proposer_id = user.id) bid_info
                       left join bid_reply
                       on bid_info.bid_id = bid_reply.bid_id
                       group by(bid_info.bid_id)";
    
    
    private $bid_dao;
    private $post_comment_dao;
    
    public function __construct() {
        $this->bid_dao = new BidDao;
        $this->post_comment_dao = new PostCommentDao();
    }
    
    public function getPostTag($post_id) {
        $results =  \Yii::$app->db
            ->createCommand(self::GET_POST_TAG)
            ->bindParam(':post_id', $post_id)
            ->queryAll();
        
        $simplify_results = array_column($results, 'tag_name');
        return $simplify_results;
 
    }
    
    public function getBidList($stuff_id) {
        $results = \Yii::$app->db
            ->createCommand(self::GET_BID_LIST)
            ->bindParam(':stuff_id', $stuff_id)
            ->queryAll();
        
        $bid_list = array();
        foreach($results as $result) {
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
            $bid->setChosenBidReply($this->bid_dao->getOneBidReply($result['bid_id']));
            $bid->setCreatorPhotoPath($result['profile_pic']);
            $bid->setQuantity($result['quantity']);
            $bid->setTotalReplies($result['total_replies']);
            $bid_list[] = $bid->build();
        }
        return $bid_list;
    }
    
    public function getPostInfo($current_user_id, $post_id, PostVoBuilder $builder) {
        $tags = $this->getPostTag($post_id);
        $result = \Yii::$app->db->createCommand(self::GET_POST_INFO)
                ->bindParam(':post_id', $post_id)
                ->bindParam(':user_id', $current_user_id)
                ->queryOne();
        
        $builder->setDeadline($result['deadline']);
        $builder->setImage($result['photo_path']);
        $builder->setPostCreatorFirstName($result['first_name']);
        $builder->setPostCreatorLastName($result['last_name']);
        $builder->setPostCreatorId($result['user_id']);
        $builder->setTitle($result['title']);
        $builder->setDescription($result['description']);
        $builder->setPostId($result['stuff_id']);
        $builder->setPostCreatorUsername($result['username']);
        $builder->setPostCreatorPhotoPath($result['profile_pic']);
        $builder->setTags($this->getPostTag($result['stuff_id']));
        $builder->setCreatedAt($result['created_at']);
        $builder->setTotalBids($result['total_bids']);
        $builder->setHasBid($result['has_bid']);
        $builder->setTotalFavorites($result['total_favorites']);
        $builder->setHasFavorited($result['has_favorited']);
        $builder->setPostId($result['stuff_id']);
        $builder->setQuantity($result['quantity']);
        $builder->setPostStatus($result['post_status']);
        $builder->setTotalComments($result['total_comments']);
        $builder->setPostComments($this->post_comment_dao->getPostCommentList($result['stuff_id']));
        return $builder;
    }
}   