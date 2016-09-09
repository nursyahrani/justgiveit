<?php

use yii\db\Migration;
use common\models\NotificationType;
use common\models\NotificationVerb;
class m160908_101626_create_notification_data_in_database extends Migration
{
    public function up()
    {   
        /**
         * 1. Post
         * 2. Bid
         * 3. Comment
         */
        $notification_type = new NotificationType();
        $notification_type->notification_type_name = "post";
        $notification_type->url_template = "post/%1$%/%2$%";
        if($notification_type->save()) {
            
        }
        $notification_type = new NotificationType();
        $notification_type->notification_type_name = "bid";
        $notification_type->url_template = "post/%1$%/%2$%#bids";
        if($notification_type->save()) {
            
        }
        
        $notification_type = new NotificationType();
        $notification_type->notification_type_name = "comment";
        $notification_type->url_template = "post/%1$%/%2$%#comments";
        if($notification_type->save()) {
            
        }
        
        /**
         * 1. Send thanks to you, post_thanks/post
         * 2. approve your proposal, bid_approve/bid
         * 3. replied on a proposal you follow, bid_reply/bid
         * 4. Send a proposal, bid_proposal/bid
         * 5. commented on a comment you follow, comment/comment
         */
        
        //1.
        $notification_verb = new NotificationVerb();
        $notification_verb->notification_verb_name = "post_thanks";
        $notification_verb->notification_type_name = "post";
        $notification_verb->text_template = "%1$% sent thanks to you for your post";
        $notification_verb->text_template_two_people = "%1$% and %2$% sent thanks to you for your post";
        $notification_verb->text_template_more_than_two_people = "%1$%, %2$% and %3$% others sent thanks to you for your post";
        if($notification_verb->save()) {
            
        }
        
        //2.
        $notification_verb = new NotificationVerb();
        $notification_verb->notification_verb_name = "bid_approve";
        $notification_verb->notification_type_name = "bid";
        $notification_verb->text_template = "%1$% approved your proposal";
        $notification_verb->text_template_two_people = null;
        $notification_verb->text_template_more_than_two_people = null;
        if($notification_verb->save()) {
            
        }
        
        //3
        $notification_verb = new NotificationVerb();
        $notification_verb->notification_verb_name = "bid_reply";
        $notification_verb->notification_type_name = "bid";
        $notification_verb->text_template = "%1$% replied on a proposal you follow";
        $notification_verb->text_template_two_people = "%1$% and %2$% replied on a proposal you follow";
        $notification_verb->text_template_more_than_two_people = "%1$%, %2$% and %3$% others replied on a proposal you follow";
        if($notification_verb->save()) {
            
        }
        
        //4
        $notification_verb = new NotificationVerb();
        $notification_verb->notification_verb_name = "bid_proposal";
        $notification_verb->notification_type_name = "bid";
        $notification_verb->text_template = "%1$% sent a proposal to you for your post";
        $notification_verb->text_template_two_people = "%1$% and %2$% sent a proposal to you for your post";
        $notification_verb->text_template_more_than_two_people = "%1$%, %2$% and %3$% others sent a proposal to you for your post";
        if($notification_verb->save()) {
            
        }
        
        //5
        $notification_verb = new NotificationVerb();
        $notification_verb->notification_verb_name = "comment";
        $notification_verb->notification_type_name = "comment";
        $notification_verb->text_template = "%1$% commented on a post you follow";
        $notification_verb->text_template_two_people = "%1$% and %2$% commented on a post you follow";
        $notification_verb->text_template_more_than_two_people = "%1$%, %2$% and %3$% others commented on a post you follow";
        if($notification_verb->save()) {
            
        }
        
        
        
    }

    public function down()
    {
        echo "m160908_101626_create_notification_data_in_database cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
