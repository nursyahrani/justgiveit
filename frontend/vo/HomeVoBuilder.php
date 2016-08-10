<?php
namespace frontend\vo;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HomeVoBuilder implements Builder {
    
    private $post_list;
    
    
    public function build() {
        return new HomeVo($this);
    }
    
    function getPostList() {
        return $this->post_list;
    }


    function setPostList($post_list) {
        $this->post_list = $post_list;
    }

    
}