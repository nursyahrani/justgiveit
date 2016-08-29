<?php
use common\widgets\SimpleSideNav;
use frontend\widgets\BannerWithSearch;
use frontend\widgets\HomeProfileView;
use frontend\widgets\PostList;
/* @var $this yii\web\View */
/* @var $home_vo frontend\vo\HomeVo **/
$post_list_provider = $home_vo->getPostList();
$this->title = 'Just Give it';
?>
<div class="site-index">
    <?=    BannerWithSearch::widget(['id' => 'banner-with-search', 'initial_location' => $home_vo->getCurrentUserLocation()]) ?>
    <div class='site-view'>
    
        <div class='col-md-9 col-xs-9 site-post-area'>
            <?=  PostList::widget(['id' => 'post-container', 'posts' => $home_vo->getPostList()]) ?>
        </div>
        <div class="col-md-3 col-xs-3 col-lg-3 hide-right-side">
            <?= HomeProfileView::widget(['id' => 'home-profile-view', 'profile' => $home_vo->getHomeProfileView()]) ?>
            <?= SimpleSideNav::widget(['id' => 'simple-side-nav-tags', 'items' => $home_vo->getSidenavItems(),
                    'title' => 'Navigation by tags']) ?>
            <?= SimpleSideNav::widget(['id' => 'simple-side-most-popular', 'items' => $home_vo->getMostPopularPost(),
             'title' => 'Popular Post']) ?>

        </div>
    </div>
    
</div>
