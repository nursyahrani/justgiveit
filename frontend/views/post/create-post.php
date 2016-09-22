<?php 
use yii\helpers\Html;
use common\models\Post;
use yii\web\JsExpression;
use common\widgets\AutoHeightTextArea;
use yii\bootstrap\Modal;
use frontend\widgets\UploadPhoto;
use kartik\select2\Select2;
use common\libraries\CommonImageLibrary;
?>

<div class="create-post-index">
    <div class="create-post-header">
        Post Stuff
    </div>
    <div class='create-post-form'>
        <?=  Html::beginForm() ?>
        
        <div class='create-post-image'>
            <?= Html::img(CommonImageLibrary::getNoPhotoPic(), ['class' => 'create-post-image-view']) ?>
            <?= Html::label('Select Photo',  'create-post-select-photo', ['class' => 'create-post-image-label']) ?>
            <?= Html::fileInput('Select Photo', null, ['class' => 'create-post-image-select-photo hide', 
                'id' => 'create-post-select-photo']) ?>

            <div class="create-post-information-image-error site-input-error">

            </div>
        </div>
        <div class='create-post-information'>
            <div class="create-post-information-subheader">
                Stuff Details
            </div>
            <div class="create-post-information-area">
                <div class="create-post-information-label">
                    Give/Request this Stuff
                </div>
                <div class="create-post-information-field">
                    <div class="create-post-type">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default  ">
                              <input type="radio" name="type" value="<?= Post::GIVE_STUFF ?>"> Give this Stuff
                            </label>
                            <label class="btn btn-default">
                              <input type="radio" name="type" value="<?= Post::REQUEST_STUFF ?>"> Request this Stuff
                            </label>
                        </div>  
                    </div>
                    <div class="create-post-type-error site-input-error">
                        
                    </div>
                </div>
            </div>
            <div class="create-post-information-area">
                
                <div class="create-post-information-label">
                    Stuff Category
                </div>
                <div class="create-post-information-field">
                    <?= Select2::widget([
                        'id' => 'create-post-information-tags',
                        'class' => 'create-post-information-tags',
                        'name' => 'tags',
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
                    <div class="create-post-information-tags-error site-input-error">

                    </div>
                </div>
            </div>
            <div class="create-post-information-area">
                <div class="create-post-information-label">
                    Stuff Name  
                </div>
                <div class="create-post-information-field">
                    <?= Html::textInput('create-post-information-title', null, 
                            ['class' => 'create-post-information-title site-input', 'placeholder' => 'Stuff Name', 'name' => 'title']) ?>
                    <div class="create-post-information-title-error site-input-error">

                    </div>
                </div>
                
            </div>
            <div class="create-post-information-area">
                <div class="create-post-information-label">
                    Stuff Details
                </div>
                <div class="create-post-information-field">
                    <?= AutoHeightTextArea::widget(['id' => 'create-post-information-description', 
                        'widget_class' => 'create-post-information-description site-input', 'placeholder' => 'Description']); ?>
                    <div class="create-post-information-description-error site-input-error">

                    </div>
                </div>
            </div>
            <div class="create-post-information-area">
                <div class="create-post-information-label">
                    Quantity
                </div>
                <div class="create-post-information-field">
                    <?= Html::input('number', 'quantity', 0, ['class' => 'create-post-information-quantity site-input']) ?>
                    <div class="create-post-information-quantity-error site-input-error">
                        
                    </div>
                </div>
            </div>
            <div class="create-post-information-area">
                <div class="create-post-information-label">
                    Pick up Location
                </div>
                <div class="create-post-information-field">
                    <?= Select2::widget([
                        'id' => 'create-post-information-pick-up-field',
                        'class' => 'create-post-information-pick-up-field',
                        'name' => 'location',
                        'value' => $profile->getUserCityId(),
                        'data' => [$profile->getUserCityId() => $profile->getLocationText()],
                        'maintainOrder' => true,
                        'options' => ['placeholder' => 'Select City ...'],
                        'pluginOptions' => [
                            'ajax' => [
                                'url' => \yii\helpers\Url::to(['site/search-city']),
                                'dataType' => 'json',
                                   'data' => new JsExpression('function(params) { return {query:params.term}; }')
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(topic_name) { return topic_name.text; }'),
                            'templateSelection' => new JsExpression('function (topic_name) { return topic_name.text; }'),
                        ]
                    ]) ?>
                    <div class="create-post-information-pick-up-location-error site-input-error">
                        
                    </div>
                </div>
            </div>
            <div class="create-post-button">

                <?= Html::button('Create', ['class' => 'create-post-create site-button site-blue-button']) ?>
                <?=                 \common\widgets\Loading::widget(['id' => 'create-post-loading']) ?>
            </div>
        </div>
        <?= Html::endForm() ?>
    </div>
    <?php Modal::begin([
    'id' =>  'create-post-modal',
    'header' => '<h4 align="center">Upload Photo</h4>'
    ]); ?>
        <?= \frontend\widgets\UploadPhoto::widget(['id' => 'create-post-upload-photo-view']) ?>
    <?php Modal::end() ?>

</div>