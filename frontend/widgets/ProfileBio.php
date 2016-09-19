<?php
namespace frontend\widgets;
use yii\bootstrap\Widget;

class ProfileBio extends Widget
{
    public $id;
    
    public $intro;
    
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if($this->intro === null || $this->intro === '') {
            $this->intro = '';
        }
        return $this->render('profile-bio',
            ['id' => $this->id, 'intro' => $this->intro]);
    }
}