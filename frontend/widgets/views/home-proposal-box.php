<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use common\widgets\AutoHeightTextArea;
    
    $image_photo_path = $post_vo->getImage();
    $post_title = $post_vo->getTitle();
    $post_description = $post_vo->getDescription();
    $post_id = $post_vo->getPostId();
    $post_link = $post_vo->getPostLink();
?>
<div id='<?= $id ?>' class="home-proposal-box-container" 
     data-stuff-id="<?= $post_id ?>" data-post-link="<?= $post_link ?>" data-id='<?= $id ?>'>
    
    <div class="home-proposal-box-details">
        <?= Html::img($image_photo_path,['class'=> 'home-proposal-box-image']) ?>
        <div class="home-proposal-box-details-title-description">
            <div class="home-proposal-box-details-title">
                <?= $post_title ?>
            </div>
            <div class="home-proposal-box-details-description">
                <?= $post_description ?>
            </div>
            <div class="home-proposal-box-text-area-container">

                <?= AutoHeightTextArea::widget(['widget_class' => 'home-proposal-box-text-area',
                    'placeholder' => 'Write proposal here..','rows' => 3
                    ])   ?>
                <div class="home-proposal-box-send-button-area">
                    <?= Html::button('<span class="glyphicon glyphicon-send"></span> Send Proposal', ['class' => 'btn btn-default'
                    . ' home-proposal-box-send-button', 
                        'disabled' => true]) ?>
                    <span class="home-proposal-box-loading-area hide">
                        <?= common\widgets\Loading::widget() ?>
                    </span>
                </div>

            </div>
        </div>
    </div>

</div>