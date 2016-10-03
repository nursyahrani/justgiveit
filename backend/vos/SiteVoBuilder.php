<?php
namespace backend\vos;

class SiteVoBuilder implements Builder {
    
    private $popular_tags;
    
    private $items_by_country;
    
    private $items_by_day;
    
    private $registered_user_by_country;
    
    public function getRegisteredUserByCountry() {
        return $this->registered_user_by_country;
    }
    
    public function setRegisteredUserByCountry($registered_user) {
        $this->registered_user_by_country = $registered_user;
    }
    
    public function getPopularTags() {
        return $this->popular_tags;
    }
    
    
    
    public function setPopularTags($popular_tags) {
        $this->popular_tags = $popular_tags;
    }
    
    public function getItemsByCountry() {
        return $this->items_by_country;
    }
    
    public function setItemsByCountry($items_by_country) {
        $this->items_by_country = $items_by_country;
    }
    
    public function getItemsByDay() {
        return $this->items_by_day;
    }
    
    public function setItemsByDay($items_by_day) {
        $this->items_by_day = $items_by_day;
    }
    
    public function build() {
        return new SiteVo($this);
    }
}