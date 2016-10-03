<?php
use scotthuangzl\googlechart\GoogleChart;
/* @var $this yii\web\View */

$this->title = 'Admin Justgivit';
//\Yii::$app->end(var_dump($home->getPopularTags()));
?>
<div class="site-index">
    <div class="site-header">
        Data Analytics
    </div>
    <div class="site-all-statistics">
        <?= GoogleChart::widget(array('visualization' => 'PieChart',
                'data' => $home->getPopularTags(),
                'options' => array('title' => 'Most Popular Items'))); ?>
    </div>
    <div class="site-past-days">
        
        <?= GoogleChart::widget(array('visualization' => 'PieChart',
                'data' => $home->getItemsByCountry(),
                'options' => array('title' => 'Items by Country'))); ?>
    </div>
    
        <?= GoogleChart::widget(array('visualization' => 'PieChart',
                'data' => $home->getRegisteredUserByCountry(),
                'options' => array('title' => 'Registered User by Country'))); ?>
    
        <?= GoogleChart::widget(array('visualization' => 'LineChart',
                'data' => $home->getItemsByDay(),
                'options' => array('title' => 'Items by Country'))); ?>
</div>
