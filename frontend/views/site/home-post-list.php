<?php
    use yii\helpers\Html;
    use kartik\dialog\Dialog;
    use yii\bootstrap\Modal;
    use common\libraries\CommonLibrary;
    /** @var $post_vo PostVo */
    $image_photo_path = $post_vo->getImage();
    $post_title = $post_vo->getTitle();
    $post_description = $post_vo->getDescription();
    $creator_full_name = $post_vo->getPostCreatorFullName();
    $creator_user_link = $post_vo->getPostCreatorUserLink();
    $creator_photo_path = $post_vo->getPostCreatorPhotoPath();
    $creator_user_id =  $post_vo->getPostCreatorId();
    $post_id = $post_vo->getPostId();
    $post_tags = $post_vo->getPostTags();
    $post_deadline = $post_vo->getDeadline();
?>

<?= Dialog::widget() ?>


<div class="home-post-list-container" >
    <div class="home-post-header">
        <div class="home-post-tag">
            <?php foreach($post_tags as $tag) { ?>
                <?= Html::a('#' . $tag, CommonLibrary::buildTagLibrary($tag)) ?>
            <?php } ?>
        </div>
        <div class="home-post-menu">
            
        </div>
    </div>
    <img class="home-post-list-img" src="<?= $image_photo_path ?>">
    <div class="home-post-view">
        <div class="home-post-list-name">
            <?= $post_title ?>
        </div>
        <div class="home-post-list-description">
            <?= $post_description ?>
        </div>
    </div>
    <div class="home-post-list-giver">
        <?= Html::img($creator_photo_path, ['class' => 'home-post-list-user-photo']) ?> 
        <?= Html::a( $creator_full_name , $creator_user_link) ?>
    </div>    
    <div class="home-post-list-button" align="left">
        <?= Html::button('Bid', 
                ['class' => 'btn btn-primary home-post-list-bid inline', 'align' => 'center',
                'id' => 'home-post-list-bid-' . $post_id,
                'data-id' => $post_id]) ?>
            
            <div class="home-post-list-time-remaining">
                    <?= $post_deadline ?>

            </div>
    </div>

</div>
<?php
Modal::begin([
    'id' => 'send-message-modal-' . $post_id,
    'size' => Modal::SIZE_LARGE
]);
    $send_message_form = new \frontend\models\SendMessageForm();
    $send_message_form->sender_id = Yii::$app->user->getId();
    $send_message_form->receiver_id = $creator_user_id;
    echo $this->render('home-message-box', ['send_message_form' => $send_message_form,
        'full_name' => $creator_full_name
    ]);
Modal::end();
?>
