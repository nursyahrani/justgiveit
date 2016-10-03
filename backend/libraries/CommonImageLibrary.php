<?php
namespace backend\libraries;

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
        $image_path  = 
                'common-img/banner1.jpg';
        $width = 1000;
        $height = 400;
            return Yii::getAlias('@web')  . '/image?path='  . "$image_path&width=" . $width . '&height=' . $height;   

    }
}