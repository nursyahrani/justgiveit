<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\bootstrap\Html;
?>

<div id ="<?= $id ?>" class="search-bar">
    <div class="search-bar-holder">
        <i class="glyphicon glyphicon-map-marker search-bar-icon"></i>
        <?=  Html::textInput('search-bar', null, ['class' =>'search-bar-input search-bar-input-city',
            'placeholder' => 'Search Country/City']) ?>
    </div>
    <div class="search-bar-holder search-bar-holder-stuff">
        <i class="glyphicon glyphicon-search search-bar-icon"></i>
        <?=  Html::textInput('search-bar', null, ['class' =>'search-bar-input search-bar-input-search',
            'placeholder' => 'Search Stuff']) ?>
        
    </div>
</div>