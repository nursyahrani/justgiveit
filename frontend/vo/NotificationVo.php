<?php

namespace frontend\vo;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use common\libraries\CommonLibrary;
use yii\data\ArrayDataProvider;

class NotificationVo implements Vo {
    
    
    private $url_template;
    
    private $text_template;
    
    private $text_template_two_people;
    
    private $text_template_more_than_two_people;
    
    private $is_read;
    
    private $notification_id;
    
    private $notification_type_name;
    
    private $notification_verb_name;
    
    private $url_key_value;
    
    private $actors;
    
    private $profile_pic;
    
    private $updated_at;
    
    private $actor_id;
    
    private $extra_value;
    
    function getUrl() {
        return CommonLibrary::replaceTemplate($this->url_template, [$this->url_key_value, $this->extra_value]);
    }
    
    function getText() {
        $actor_list = explode("%,%", $this->actors);
        
        if(count($actor_list) === 1) {
            return CommonLibrary::replaceTemplate($this->text_template,[$actor_list[0]]);
        }
        else if(count($actor_list) === 2) {
            return CommonLibrary::replaceTemplate($this->text_template_two_people, [$actor_list[0], $actor_list[1]]);
        } else {
            return CommonLibrary::replaceTemplate($this->text_template_more_than_two_people, [$actor_list[0], $actor_list[1], count($actor_list) - 2]);
        }
    }
    
    function getTime() {
        return CommonLibrary::getTimeText($this->updated_at);
    }
    
    function isRead() {
        return $this->is_read;
    }
    
    function getPhoto() {
        return \common\libraries\UserLibrary::buildPhotoPath($this->profile_pic);
    }

    function getNotificationId() {
        return $this->notification_id;
    }

    function getNotificationTypeName() {
        return $this->notification_type_name;
    }

    function getNotificationVerbName() {
        return $this->notification_verb_name;
    }

    function getUrlKeyValue() {
        return $this->url_key_value;
    }

    function getActors() {
        return $this->actors;
    }

    function getProfile_pic() {
        return $this->profile_pic;
    }

    function getUpdatedAt() {
        return $this->updated_at;
    }

    function getActorId() {
        return $this->actor_id;
    }

    function getExtraValue() {
        return $this->extra_value;
    }

        
    
    function __construct(NotificationVoBuilder $builder) {
        $this->actor_id = $builder->getActorId();
        $this->actors = $builder->getActors();
        $this->extra_value = $builder->getExtraValue();
        $this->is_read = $builder->isRead();
        $this->notification_id = $builder->getNotificationId();
        $this->notification_type_name = $builder->getNotificationTypeName();
        $this->notification_verb_name = $builder->getNotificationVerbName();
        $this->profile_pic = $builder->getProfilePic();
        $this->text_template = $builder->getTextTemplate();
        $this->text_template_more_than_two_people = $builder->getTextTemplateMoreThanTwoPeople();
        $this->text_template_two_people = $builder->getTextTemplateTwoPeople();
        $this->updated_at = $builder->getUpdatedAt();
        $this->url_key_value = $builder->getUrlKeyValue();
        $this->url_template = $builder->getUrlTemplate();
    }
    
    public static   function createBuilder() {
        return new NotificationVoBuilder();
    }

}