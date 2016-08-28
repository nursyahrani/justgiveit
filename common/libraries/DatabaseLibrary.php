<?php
namespace common\libraries;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 class DatabaseLibrary {
     
    public static function checkEligibility($stringified_array) {
        $valid = true;
        $list = explode(',', $stringified_array);
        foreach($list as $item) {

            if(!is_numeric($item)) {

                $valid = false;
            }
        }
        return $valid;
    }
 }