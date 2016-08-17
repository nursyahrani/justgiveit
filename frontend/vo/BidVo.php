<?php

namespace frontend\vo;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\data\ArrayDataProvider;
use common\libraries\CommonLibrary;
use common\libraries\UserLibrary;
class BidVo implements Vo {

    private $creator_username;
    private $creator_first_name;
    private $creator_last_name;
    private $creator_photo_path;
    private $creator_id;
    private $stuff_id;
    private $message;
    private $created_at;

    function __construct(BidVoBuilder $builder) {
        $this->creator_username = $builder->getCreatorUsername();
        $this->creator_first_name = $builder->getCreatorFirstName();
        $this->creator_last_name = $builder->getCreatorLastName();
        $this->creator_id = $builder->getCreatorId();
        $this->stuff_id = $builder->getStuffId();
        $this->message = $builder->getMessage();
        $this->created_at = $builder->getCreatedAt();
        $this->creator_photo_path = $builder->getCreatorPhotoPath();
    }

    public static function createBuilder() {
        return new PostVoBuilder();
    }
    
    public function getCreatedAt() {
        return CommonLibrary::getTimeText($this->created_at);
    }
    
    public function getCreatorUserLink() {
        return UserLibrary::buildUserLink($this->creator_username);
    }

    public function getCreatorFullName() {
        return $this->creator_first_name . ' ' . $this->creator_last_name;
    }
    
    public function getCreatorPhotoPath() {
        return UserLibrary::buildPhotoPath($this->creator_photo_path);
    }


    public function getCreatorId() {
        return $this->creator_id;
    }

    public function getStuffId() {
        return $this->stuff_id;
    }

    public function getMessage() {
        return $this->message;
    }



}
