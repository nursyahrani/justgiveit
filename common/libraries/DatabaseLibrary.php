<?php
namespace common\libraries;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 class DatabaseLibrary {
     
    public static function stringedItems($stringified_array) {
        $first = true;
        $list = explode(',', $stringified_array);
        $stringed_items = '';
        foreach($list as $item) {

            if($first) {
                $stringed_items .= "'" . $item  . "'";
                $first = false;
            } else {
                $stringed_items .= "," . "'" . $item . "'";
            }
        }
        return $stringed_items;
    }
 }