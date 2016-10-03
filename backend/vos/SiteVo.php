<?php

namespace backend\vos;

use Yii;

class SiteVo implements Vo {
    
    private $popular_tags;
    
    private $items_by_country;
    
    private $items_by_day;
    
    private $registered_user_by_country;
    
    public function __construct(SiteVoBuilder $builder) {
        $this->popular_tags = $builder->getPopularTags();
        $this->items_by_country = $builder->getItemsByCountry();
        $this->registered_user_by_country = $builder->getRegisteredUserByCountry();
        $this->items_by_day = $builder->getItemsByDay();    
    }
    
    public function getRegisteredUserByCountry() {
        return $this->registered_user_by_country;
    }
    
    
    public function getPopularTags() {
        return $this->popular_tags;
    }
    
    public function getItemsByCountry() {
        return $this->items_by_country;
    }
    
    public function getItemsByDay() {
        return $this->items_by_day;
    }
    
    public static function createBuilder() {
        return new SiteVoBuilder();
    }
    
}