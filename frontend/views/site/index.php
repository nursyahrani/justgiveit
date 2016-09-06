<?php
use common\widgets\SimpleSideNav;
use frontend\widgets\BannerWithSearch;
use frontend\widgets\TagNavigation;
use frontend\widgets\HomeProfileView;
use frontend\widgets\SearchBar;
use frontend\widgets\PostList;
/* @var $this yii\web\View */
/* @var $home_vo frontend\vo\HomeVo **/
$post_list_provider = $home_vo->getPostList();
$this->title = 'Just Give it';
?>
<div class="site-index">
    <div class='site-view'>
        <div class="site-left-side hide-right-side">
            <?= HomeProfileView::widget(['id' => 'home-profile-view', 'profile' => $home_vo->getHomeProfileView()]) ?>
            <?= TagNavigation::widget(['id' => 'tag-navigation']) ?>
        </div>
        <div class='site-post-area'>
            <?= SearchBar::widget(['id' => 'site-search-bar', 'initial_location' => $home_vo->getCurrentUserLocation()]) ?>
            <?=  PostList::widget(['id' => 'post-container', 
                                    'posts' => $home_vo->getPostList(), 
                                    'current_location' => $home_vo->getCurrentUserLocation()['id']]) ?>
        </div>
    </div>
    
</div>
