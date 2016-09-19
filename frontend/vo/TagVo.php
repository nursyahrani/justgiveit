<?php

namespace frontend\vo;


class TagVo implements Vo {

    private $tag_name;
    
    private $tag_id;
    
    private $starred;
    
    private $checked;
            
    function __construct(TagVoBuilder $builder) {
        $this->tag_id = $builder->getTagId();
        $this->tag_name = $builder->getTagName();
        $this->starred = $builder->isStarred();
        $this->checked = $builder->isChecked();
    }

    public static function createBuilder() {
        return new TagVoBuilder();
    }

    public function isStarred() {
        return $this->starred;
    }
    
    public function getTagId() {
        return $this->tag_id;
    }
    
    public function getTagName() {
        return $this->tag_name;
    }
    
    public function isChecked() {
        return $this->checked;
    }
}
