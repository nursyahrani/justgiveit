<?php
    use yii\widgets\ListView;
    use yii\helpers\Html;
    use kartik\tabs\TabsX;
    /** @var $message_received_provider \yii\data\ArrayDataProvider */
    /** @var $message_sent_provider \yii\data\ArrayDataProvider */
    /** @var $created_stuff_provider \yii\data\ArrayDataProvider */
    /** @var $user array */
    use frontend\widgets\BidContainer;
    use frontend\widgets\HomePostList;
?>
<div class="profile-index">
    <div class="profile-header" style="margin-top: 12px">
        <div class="col-md-3">
            <?= Html::img($profile->getProfilePic()) ?>
        </div>
        <div class="col-md-3">
            <div class="row">
                <h2><?= $profile->getFullName() ?></h2>
            </div>
        </div>
    </div>

    <div class="profile-data">
        
        <div class="col-md-2">
            <?=        \common\widgets\SimpleSideNav::widget(['id' => 'simple-side-nav-profile',
                'items' => $profile->getSimpleSidenav(), 'title' => 'Navigation']) ?>
        </div>
        <div class="col-md-10">
            <?php if($profile->getGiveList() !== null) { 
                foreach($profile->getGiveList() as $stuff) {
                    echo '<div class="col-lg-6 col-md-12 col-xs-12">';
                    echo HomePostList::widget(['id' => 'profile-post-' . $stuff->getPostId(), 'post_vo' => $stuff]);
                    echo '</div>';
                }
             }
             ?>
        </div>
    </div>
</div>

