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
    
    function __construct(HomeVoBuilder $builder) {
        $this->post_list = $builder->getPostList();
    }
    
    public function getPostList() {
        return new ArrayDataProvider([
            'allModels' => $this->post_list,
            'pagination' => ['pageSize' => 5]
        ]);
    }
    
    public static   function createBuilder() {
        return new PostVoBuilder();
    }

    public function getSideNavItems() {
        $items = ['Books', 'Lecture notes', 'Clothes', 'Food', 'Accessories', 'Gadgets', 'Mobile phones', 'Recycle stuffs'];
        $converted_items = array();
        foreach($items as $item) {
           $converted['label'] = $item;
           $converted['url'] = \Yii::$app->request->baseUrl . '/tag/' . $item;
           $converted_items[] = $converted;
        }
        
        return $converted_items;
    }
    
}