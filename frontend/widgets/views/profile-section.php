<?php
use frontend\widgets\ImageViewEditor;
use yii\helpers\Html;
use yii\web\JsExpression;
use kartik\select2\Select2;
?>

<div id="<?= $id ?>" class="profile-section" data-id="<?= $id ?>">
    <div class="profile-section-image">
        <?=  ImageViewEditor::widget(['id' => $id . '-image-view',
                                    'image_path' => $profile->getProfilePic(), 'active' => true,
                                    'modal_title' => $profile->getFullName()]) ?>
    </div>
    <div class="profile-section-information">
        <div class="profile-section-information-name-area">
            <span class="profile-section-information-name"> <?= $profile->getFullName() ?> </span> 
            <?php if($profile->isOwner()) { ?>
                <sup>
                    <?= Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['class' => 'profile-section-name-edit']) ?>
                </sup>
            <?php } ?>
        </div>
        <div class="profile-section-information-edit-name-area hide">
            <div class="profile-section-information-edit-first-name">
                <?= Html::textInput('first_name', $profile->getFirstName(), ['class' => 'site-input profile-section-first-name']) ?>
                <div class="profile-section-first-name-error site-input-error">
                </div>
            </div>
            <div class="profile-section-information-edit-last-name">
                <?= Html::textInput('last_name', $profile->getLastName(), ['class' => 'site-input profile-section-last-name']) ?>
            </div>
            <?= Html::button('Update', ['class' => 'btn btn-sm btn-primary profile-section-information-edit-name-edit']) ?>
            <?= Html::button('Cancel', ['class' => 'btn btn-sm btn-danger profile-section-information-edit-name-cancel']) ?> 
        </div>
        <div class="profile-section-information-location-area">
            <i><span class="profile-section-information-location"> <?= $profile->getLocationText() ?> </span></i>
            <?php if($profile->isOwner()) { ?>
                <sup>
                    <?= Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['class' => 'profile-section-location-edit']) ?>
                </sup>
            <?php } ?>
        </div>
        <div class="profile-section-information-edit-location-area hide">
            <div class="profile-section-information-edit-location-field-area">
                <?= Select2::widget([
                    'id' => 'profile-section-information-edit-location-field',
                    'class' => 'profile-section-information-edit-location',
                    'name' => 'location',
                    'maintainOrder' => true,
                    'options' => ['placeholder' => 'Select City ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => true,
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
                <div class="profile-section-information-location-area-error site-input-error">
                    
                </div>
            </div>       
            <?= Html::button('Update', ['class' => 'btn btn-sm btn-primary profile-section-information-edit-location-edit']) ?>
            <?= Html::button('Cancel', ['class' => 'btn btn-sm btn-danger profile-section-information-edit-location-cancel']) ?> 
        </div>
        
        
    </div>
</div>