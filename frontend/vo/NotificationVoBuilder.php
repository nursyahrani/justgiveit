<?php
namespace frontend\vo;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NotificationVoBuilder implements Builder {
    
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
    public function build() {
        return new NotificationVo($this);
    }
    
    
    function getUrlTemplate() {
        return $this->url_template;
    }

    function getTextTemplate() {
        return $this->text_template;
    }

    function getTextTemplateTwoPeople() {
        return $this->text_template_two_people;
    }

    function getTextTemplateMoreThanTwoPeople() {
        return $this->text_template_more_than_two_people;
    }

    function isRead() {
        return $this->is_read;
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

    function getProfilePic() {
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

    function setUrlTemplate($url_template) {
        $this->url_template = $url_template;
    }

    function setTextTemplate($text_template) {
        $this->text_template = $text_template;
    }

    function setTextTemplateTwoPeople($text_template_two_people) {
        $this->text_template_two_people = $text_template_two_people;
    }

    function setTextTemplateMoreThanTwoPeople($text_template_more_than_two_people) {
        $this->text_template_more_than_two_people = $text_template_more_than_two_people;
    }

    function setIsRead($is_read) {
        $this->is_read = $is_read;
    }

    function setNotificationId($notification_id) {
        $this->notification_id = $notification_id;
    }

    function setNotificationTypeName($notification_type_name) {
        $this->notification_type_name = $notification_type_name;
    }

    function setNotificationVerbName($notification_verb_name) {
        $this->notification_verb_name = $notification_verb_name;
    }

    function setUrlKeyValue($url_key_value) {
        $this->url_key_value = $url_key_value;
    }

    function setActors($actors) {
        $this->actors = $actors;
    }

    function setProfilePic($profile_pic) {
        $this->profile_pic = $profile_pic;
    }

    function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }

    function setActorId($actor_id) {
        $this->actor_id = $actor_id;
    }

    function setExtraValue($extra_value) {
        $this->extra_value = $extra_value;
    }


    
}