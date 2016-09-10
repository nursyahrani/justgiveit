<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\bootstrap\Html;
use kartik\select2\Select2;
use yii\web\JsExpression;
?>

<div id ="<?= $id ?>" class="search-bar" data-id="<?= $id ?>">
    
    <div class="search-bar-holder search-bar-holder-stuff">
        <?=  Html::textInput('search-bar', null, ['class' =>'search-bar-input search-bar-input-search',
            'placeholder' => 'Search Stuff']) ?>
    </div>
</div>