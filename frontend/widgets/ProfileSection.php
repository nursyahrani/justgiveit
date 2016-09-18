<?php
namespace frontend\widgets;
use yii\bootstrap\Widget;
class ProfileSection extends Widget
{
    public $id;
    
    public $profile;
    
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('profile-section',
            ['id' => $this->id, 'profile' => $this->profile]);
    }
}