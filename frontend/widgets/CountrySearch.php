<?php

namespace frontend\widgets;

use yii\base\Widget;

class CountrySearch extends Widget
{
    public $id;
    
    public $profile;
    
    public function init()
    {
        parent::init();
    }


    public function run()
    {
        return $this->render('country-search',
            ['id' => $this->id, 'profile' => $this->profile]);
    }
}