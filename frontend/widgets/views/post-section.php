<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use common\libraries\CommonLibrary;
use yii\helpers\Html;
use kartik\select2\Select2;
use common\widgets\ButtonWithTooltip;
use common\widgets\AutoHeightTextArea;
use yii\web\JsExpression;

?>
<div id="<?= $id ?>" data-stuff_id ="<?= $post->getPostId() ?>" class="post-section">
    <div class="post-section-view">
        <div class="post-section-tags">
            <?php foreach($post->getPostTags() as $tag) { ?>
                <?= Html::a($tag, CommonLibrary::buildTagLibrary($tag)) ?>
            <?php } ?>
        </div>
        <div class="post-section-title">
            <?= $post->getTitle() ?>            
        </div>
        <div class="post-section-description">
            <?= $post->getDescription() ?>
        </div>
        <div class="post-section-view-button">
            <?php if($post->isOwner()) { ?>
                <?= ButtonWithTooltip::widget(['id' => 'post-section-view-edit-button', 
                    'tooltip_text' => 'Edit',
                    'text' => '<span class="glyphicon glyphicon-pencil"></span>',
                    'button_class' => 'button-like-link post-section-view-edit-button '
                ]) ?>
            <?php } ?>
        </div>

    </div>
    <div class="post-section-edit post-section-hide">
        
        <?= Select2::widget([
                'id' => 'post-section-edit-tags',
                'class' => 'post-section-edit-tags',
                'name' => 'tags',
                'value' => $post->getPostTags(),
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
        <div class="post-section-edit-tags-error post-section-error">
            
        </div>
        <?= Html::textInput('post-section-edit-title', $post->getTitle(), 
                ['class' => 'post-section-edit-title', 'placeholder' => 'Title', 'name' => 'title']) ?>
        <div class="post-section-edit-title-error post-section-error">
            
        </div>
        <?= AutoHeightTextArea::widget(['id' => 'post-section-edit-description', 
            'widget_class' => 'post-section-edit-description', 'placeholder' => 'Description',
            'value' => $post->getDescription()]); ?>
        <div class="post-section-error post-section-edit-description-error">
            
        </div>
        
        <div class="post-section-edit-button" align="right">
            <?= Html::button('Edit', ['class' => 'post-section-button post-section-edit-edit-button']) ?>
            <?= Html::button('Cancel', ['class' => 'post-section-button post-section-edit-cancel-button']) ?>
        </div>
    </div>
</div>