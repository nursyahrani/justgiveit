<?php

namespace frontend\models;

use yii\base\Model;
use common\models\City;
use common\models\Country;
/**
 * ContactForm is the model behind the contact form.
 */
class AddNewCityForm extends Model
{
    public $city;
    public $country_code;
    public $country;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['city', 'country_code', 'country'], 'required'],
            
            [['city', 'country_code', 'country'], 'string']
        ];
    }

    public function getId(){
        if(!$this->validate()) {
            return false;
        }
        if(!Country::find()->where(['country_code' => $this->country_code])->exists()) {
            $country = new Country();
            $country->country_code = $this->country_code;
            $country->country_default_name = $this->country;
            if(!$country->save()) {
                return false;
            }
        }
        $city = City::find()->where(['country_code' => $this->country_code, 
                'city_name' => $this->city])->one();
        if($city === null) {
            $city = new City();
            $city->country_code = $this->country_code;
            $city->city_name = $this->city;
            if(!$city->save()) {
                return false;
            }
        }
        return $city->city_id;
    }
    
    
}
