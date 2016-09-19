<?php
namespace frontend\vo;

use Yii;

class TagVoBuilder implements Builder {

    private $tag_name;
    
    private $tag_id;
    
    private $starred;
    
    private $checked;
    
    public function build() {
        return new TagVo($this);
    }
    
    public function isChecked() {
        return $this->checked;
    }
    
    public function setChecked($checked) {
        $this->checked = $checked;
    }
    
    public function getTagName() {
        return $this->tag_name;
    }
    
    public function getTagId() {
        return $this->tag_id;
    }
    
    public function isStarred() {
        return $this->starred;
    }
    
    public function setTagName($tag_name) {
        $this->tag_name = $tag_name;
    }
    
    public function setTagId($tag_id) {
        $this->tag_id = $tag_id;
    }
    
    public function setStarred($starred) {
        $this->starred = $starred;
    }
}