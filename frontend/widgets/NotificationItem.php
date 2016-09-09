<?php

namespace frontend\widgets;

use yii\base\Widget;

class NotificationItem extends Widget
{
    public $id;
    
    public $notification;
    
    public function init()
    {
        parent::init();

        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        NotificationItemAsset::register($view);

    }

    public function run()
    {
        return $this->render('notification-item',
            ['id' => $this->id, 'notification' => $this->notification]);
    }
}