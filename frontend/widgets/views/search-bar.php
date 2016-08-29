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
    <div class="search-bar-city">
        <?= Select2::widget([
                'id' => $id . '-city',
                'class' => 'post-list-city',
                'name' => 'city',
                'value' => $initial_location['id'],
                'initValueText' => $initial_location['text'],
                'options' => ['placeholder' => 'Search City ...'],
                'pluginOptions' => [
                    'ajax' => [
                        'url' => \yii\helpers\Url::to(['site/search-city']),
                        'dataType' => 'json',
                           'data' => new JsExpression('function(params) { return {query:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(topic_name) { return topic_name.text; }'),
                    'templateSelection' => new JsExpression('function (topic_name) { return topic_name.text; }'),
                ],
            ]) ?>
    </div>
    <?= Html::button('<span class="glyphicon glyphicon-search"></span>', ['class' => 'btn btn-primary search-bar-button']) ?>
</div>