<?php
namespace common\libraries;

use Yii;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class CommonImageLibrary {
    
    
    public static function getNoPhotoPic() {
           return Yii::$app->request->baseUrl . '/frontend/web/common-img/' . 'no-photo.png';
    }

    
    public static function getBanner() {
        return Yii::$app->request->baseUrl . '/frontend/web/common-img/banner1.jpg';
    }
}