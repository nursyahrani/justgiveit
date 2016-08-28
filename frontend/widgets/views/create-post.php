<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use common\libraries\CommonImageLibrary;
use yii\bootstrap\Html;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\bootstrap\Modal;
use common\widgets\AutoHeightTextArea;
?>

<div class='create-post' id='<?= $id ?>' data-id='<?= $id ?>'>
    <div class='create-post-form'>
        
        <div class='col-xs-12 col-md-4 col-lg-4 create-post-image'>
            <?= Html::img(CommonImageLibrary::getNoPhotoPic(), ['class' => 'create-post-image-view']) ?>
            <?= Html::label('Select Photo', $id . '-select-photo', ['class' => 'create-post-image-label']) ?>
            <?= Html::fileInput('Select Photo', null, ['class' => 'create-post-image-select-photo hide', 
                'id' => $id . '-select-photo']) ?>
            
            <div class="create-post-information-image-error site-input-error">

            </div>
        </div>
        <div class='col-xs-12 col-md-8 col-lg-8 create-post-information'>
            <?= Select2::widget([
                'id' => 'create-post-information-tags',
                'class' => 'create-post-information-tags',
                 'name' => 'tags',
                'maintainOrder' => true,
                'options' => ['placeholder' => 'Select Tags ...', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags' => true,
                    'ajax' => [
                        'url' => \yii\helpers\Url::to(['site/search-tag']),
                        'dataType' => 'json',
                           'data' => new JsExpression('function(params) { return {query:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(topic_name) { return topic_name.text; }'),
                    'templateSelection' => new JsExpression('function (topic_name) { return topic_name.text; }'),
                ],
            ]) ?>
            <div class="create-post-information-tags-error site-input-error">

            </div>
            <?= Html::textInput('create-post-information-title', null, 
                    ['class' => 'create-post-information-title site-input', 'placeholder' => 'Title', 'name' => 'title']) ?>
            <div class="create-post-information-title-error site-input-error">

            </div>
            <?= AutoHeightTextArea::widget(['id' => 'create-post-information-description', 
                'widget_class' => 'create-post-information-description site-input', 'placeholder' => 'Description']); ?>
            <div class="create-post-information-description-error site-input-error">

            </div>
            
            <div class="create-post-button">
                
                <?= Html::button('Create', ['class' => 'create-post-create-btn site-button site-blue-button']) ?>
                <?=                 \common\widgets\Loading::widget(['id' => $id .'-loading']) ?>
            </div>
        </div>
    </div>
    <?php Modal::begin([
        'id' => $id . '-modal',
        'header' => '<h4 align="center">Upload Photo</h4>'
    ]); ?>
        <?= \frontend\widgets\UploadPhoto::widget(['id' => $id . '-upload-photo-view']) ?>
    <?php Modal::end() ?>
</div>