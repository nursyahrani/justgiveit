<?php

namespace frontend\widgets;

use yii\base\Widget;

class CountrySearchItem extends Widget
{
    public $id;
    
    public $country_name;
    
    public $country_code;
    
    public function init()
    {
        parent::init();
    }
    
    public function run()
    {
        return $this->render('country-search-item',
            ['id' => $this->id, 'country_code' => $this->country_code, 'country_name' => $this->country_name]);
    }
}