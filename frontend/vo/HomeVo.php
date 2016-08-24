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
    
    
    function __construct(HomeVoBuilder $builder) {
        $this->post_list = $builder->getPostList();
        $this->most_popular_post = $builder->getMostPopularPost();
        $this->home_profile_view = $builder->getHomeProfileView();
    }
    
    public function getPostList() {
        return new ArrayDataProvider([
            'allModels' => $this->post_list,
            'pagination' => false
        ]);
    }
    
    public function getHomeProfileView() {
        return $this->home_profile_view;
    }
    
    public static   function createBuilder() {
        return new PostVoBuilder();
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
    
}