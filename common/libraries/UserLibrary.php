<?php
namespace common\libraries;

use Yii;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class UserLibrary {
    public static function buildPhotoPath($photo_path) {
        return Yii::$app->request->baseUrl . '/frontend/web/photos/' . $photo_path;
    }
    
    public static function buildUserLink($username) {
        return Yii::$app->request->baseUrl . '/user/' . $username;
    }
    
    public static function isOwner($creator_id) {
        if(!Yii::$app->user->isGuest) {

            return Yii::$app->user->getId() ===  (int)$creator_id;   
        }
        
        
        return false;
    }
}