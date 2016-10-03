<?php
namespace frontend\dao;
use frontend\vo\BidReplyVoBuilder;
use frontend\vo\BidVoBuilder;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class NotificationDao {

    const COUNT_NEW_NOTIFICATION = "SELECT count(*)
                                from (SELECT notification.notification_id
                                      from notification, notification_receiver
                                      where notification_receiver.notification_id = notification.notification_id
                                            and notification_receiver.receiver_id = :user_id) notification_entity
                                left join(
                                    SELECT na.updated_at,na.actor_id, n.notification_id
                                    from notification n, notification_actor na
                                    where n.notification_id = na.notification_id and
                                          na.updated_at = (SELECT max(na1.updated_at)
                                                           from notification_actor na1
                                                           where n.notification_id = na1.notification_id
                                                           and na1.actor_id <> :user_id)
                                  ) last_actor
                                on notification_entity.notification_id = last_actor.notification_id
                                where last_actor.actor_id is not null and updated_at > 
                                    (SELECT notif_last_seen from user where id = :user_id)";
    
    
    const NOTIFICATION_LIST = "SELECT notification_entity.*,notification_actors.actors, 
                                last_actor.profile_pic, last_actor.updated_at, last_actor.actor_id,
                                notification_extra_value.extra_value
                                from (SELECT notification_type.url_template,
                                      		notification_verb.text_template,
                                            notification_verb.text_template_two_people,
                                            notification_verb.text_template_more_than_two_people, 
                                            notification_receiver.is_read,
                                             notification.notification_id, notification.notification_type_name, 
                                             notification.notification_verb_name, notification.url_key_value
                                      from notification_type, notification_verb, notification, notification_receiver
                                      where notification_type.notification_type_name = notification_verb.notification_type_name
                                            and notification_verb.notification_verb_name = notification.notification_verb_name
                                      		and notification_verb.notification_type_name = notification.notification_type_name
                                            and notification_receiver.notification_id = notification.notification_id
                                            and notification_receiver.receiver_id = :user_id) notification_entity
                                left join
                                    (SELECT n.notification_id,
                                           na.updated_at,
                                           group_concat(actor.first_name SEPARATOR '%,%') as actors
                                    FROM notification n, notification_actor na, user actor
                                    WHERE n.notification_id = na.notification_id
                                    and actor.id = na.actor_id and actor.id <> :user_id
                                    group by na.notification_id
                                    order by na.updated_at desc
                                    ) notification_actors
                                on notification_actors.notification_id = notification_entity.notification_id
                                left join(
                                    SELECT u.profile_pic, n.notification_id, na.updated_at,na.actor_id
                                    from notification n, notification_actor na, user u
                                    where n.notification_id = na.notification_id and
                                          na.actor_id = u.id and
                                          na.updated_at = (SELECT max(na1.updated_at)
                                                           from notification_actor na1
                                                           where n.notification_id = na1.notification_id
                                                           and na1.actor_id <> :user_id

                                                             )
                                  ) last_actor
                                on notification_entity.notification_id = last_actor.notification_id
                                left join notification_extra_value
                                on notification_extra_value.notification_type_name = notification_entity.notification_type_name
                                and notification_extra_value.url_key_value = notification_entity.url_key_value
                                where last_actor.actor_id is not null
                                order by last_actor.updated_at desc";

    
    public function getNotificationList($user_id) {
        
        $results =  \Yii::$app->db
            ->createCommand(self::NOTIFICATION_LIST)
            ->bindValues([':user_id' => $user_id])
            ->queryAll();
        
        $notification_list = array();
        foreach($results as $result) {
            $builder = new \frontend\vo\NotificationVoBuilder;
            $builder->setActorId($result['actor_id']);
            $builder->setUrlTemplate($result['url_template']);
            $builder->setTextTemplate($result['text_template']);
            $builder->setTextTemplateTwoPeople($result['text_template_two_people']);
            $builder->setTextTemplateMoreThanTwoPeople( $result['text_template_more_than_two_people']);
            $builder->setIsRead($result['is_read']);
            $builder->setNotificationId($result['notification_id']);
            $builder->setNotificationTypeName($result['notification_type_name']);
            $builder->setNotificationVerbName($result['notification_verb_name']);
            $builder->setUrlKeyValue($result['url_key_value']);
            $builder->setActors($result['actors']);
            $builder->setProfilePic($result['profile_pic']);
            $builder->setUpdatedAt($result['updated_at']);
            $builder->setExtraValue($result['extra_value']);
            
            $notification_list[] = $builder->build();
        }
        
        return $notification_list;
    }
    
    function getCountNotification($user_id) {
        // DAO
        $result =  \Yii::$app->db
            ->createCommand(self::COUNT_NEW_NOTIFICATION)
            ->bindValues([':user_id' => $user_id])
            ->queryScalar();

        return (int)$result;
    }
}

