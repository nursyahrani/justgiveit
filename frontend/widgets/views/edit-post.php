<?php
use yii\helpers\Html;
use yii\web\JsExpression;
use common\widgets\AutoHeightTextArea;
use kartik\select2\Select2;

?>


<div id="<?= $id ?>" class="edit-post" data-id="<?= $id ?>" data-stuff_id ="<?= $post->getPostId() ?>">
    
    <div class='edit-post-form'>
        <?=  Html::beginForm() ?>
        
        <div class='edit-post-information'>
            <div class="edit-post-information-subheader">
                Edit Stuff Details
            </div>
            <div class="edit-post-information-area">
                <div class="edit-post-information-label">
                    Stuff Category
                </div>
                <div class="edit-post-information-field">
                    <?= Select2::widget([
                        'id' =>  $id . '-tags',
                        'class' => 'edit-post-tags',
                        'name' => 'tags',
                        'value' => $post->getPostTags(),
                        'maintainOrder' => true,
                        'options' => ['placeholder' => 'Select Category ...', 'multiple' => true],
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
                    <div class="edit-post-tags-error site-input-error">

                    </div>
                </div>
            </div>
            <div class="edit-post-information-area">
                <div class="edit-post-information-label">
                    Stuff Name  
                </div>
                <div class="edit-post-information-field">
                    <?= Html::textInput('edit-post-information-title', $post->getTitle(), 
                            ['class' => 'edit-post-title site-input', 'placeholder' => 'Stuff Name', 'name' => 'title']) ?>
                    <div class="edit-post-title-error site-input-error">

                    </div>
                </div>
                
            </div>
            <div class="edit-post-information-area">
                <div class="edit-post-information-label">
                    Stuff Details
                </div>
                <div class="edit-post-information-field">
                    <?= AutoHeightTextArea::widget(['id' => $id . '-information-description', 
                        'widget_class' => 'edit-post-description site-input', 'placeholder' => 'Description', 'value' => $post->getDescription()]); ?>
                    <div class="edit-post-description-error site-input-error">

                    </div>
                </div>
            </div>
            <div class="edit-post-information-area">
                <div class="edit-post-information-label">
                    Quantity
                </div>
                <div class="edit-post-information-field">
                    <?= Html::input('number', 'quantity', $post->getQuantity(), ['class' => 'edit-post-quantity site-input']) ?>
                    <div class="edit-post-quantity-error site-input-error">
                        
                    </div>
                </div>
            </div>

            
            <div class="edit-post-button">

                <?= Html::button('Edit', ['class' => 'edit-post-edit site-button site-blue-button']) ?>

                <?= Html::button('Cancel', ['class' => 'edit-post-cancel site-button site-red-button']) ?>
            </div>

        </div>
        <?= Html::endForm() ?>
    </div>
</div>