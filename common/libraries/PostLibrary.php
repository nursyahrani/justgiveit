<?php
namespace common\libraries;

use Yii;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class PostLibrary {
    public static function buildPostLink($id, $title) {
        return Yii::$app->request->baseUrl . '/post/' . $id . '/' . $title;
    }
    
    public static function buildUserLink($username) {
        return Yii::$app->request->baseUrl . '/user/' . $username;
    }
}