<?php

namespace frontend\vo;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\data\ArrayDataProvider;

class HomeVo implements Vo {
    
    private $post_list;
    
    private $most_popular_post;
    
    private $home_profile_view;
    
    private $count_new_notification;
    
    private $current_location;
    
    private $starred_tag_list;
    
    private $most_popular_tags;
    
    function __construct(HomeVoBuilder $builder) {
        $this->post_list = $builder->getPostList();
        $this->most_popular_post = $builder->getMostPopularPost();
        $this->home_profile_view = $builder->getHomeProfileView();
        $this->current_location = $builder->getCurrentUserLocation();
        $this->count_new_notification = $builder->getCountNewNotification();
        $this->starred_tag_list = $builder->getStarredTagList();
        $this->most_popular_tag = $builder->getMostPopularTag();
    }
    
    public function getStarredTagList() {
        return $this->starred_tag_list;
    }
    
    public function getMostPopularTags() {
        return $this->most_popular_tag;
    }


    public function getPostList() {
        return $this->post_list;
    }
    
    public function getHomeProfileView() {
        return $this->home_profile_view;
    }
    
    public static   function createBuilder() {
        return new PostVoBuilder();
    }
    
    public function getCountNewNotification() {
        return $this->count_new_notification;
    }

    public function getSideNavItems() {
        $items = ['Book', 'Lecture note', 'Clothes', 'Food', 'Accessories', 'Gadget', 'Mobile phone', 'Recycle stuff'];
        $converted_items = array();
        foreach($items as $item) {
           $converted['label'] = $item;
           $converted['url'] = \Yii::$app->request->baseUrl . '/tag/' . $item;
           $converted_items[] = $converted;
        }
        
        return $converted_items;
    }
    
    public function getMostPopularPost() {
        $items = array();
        foreach($this->most_popular_post as $post) {
            $new_item['label'] = $post->getTitle();
            $new_item['url'] = $post->getPostLink();
            $items[] = $new_item;
        }
        
        return $items;
    }
    
    public function getCurrentUserLocation() {
        return $this->current_location;
    }
}