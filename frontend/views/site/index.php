<?php
use common\widgets\SimpleSideNav;
use frontend\widgets\BannerWithSearch;
use frontend\widgets\TagNavigation;
use yii\helpers\Html;
use frontend\widgets\Banner;
use frontend\widgets\HomeProfileView;
use frontend\widgets\SearchBar;
use frontend\widgets\PostList;
/* @var $this yii\web\View */
/* @var $home_vo frontend\vo\HomeVo **/
$post_list_provider = $home_vo->getPostList();
$this->title = 'Just Give it';
?>
<div class="site-index">
    <div class="site-post-area-header">
        <?= Html::button('<span class="glyphicon glyphicon-open"></span>', 
                ['class' => 'btn btn-default site-post-area-open-left-side-dynamic site-post-area-open-left-side']) ?>
        <?= SearchBar::widget(['id' => 'site-search-bar', 'initial_location' => $home_vo->getCurrentUserLocation()]) ?>
    </div>

    <div class='site-view'>
 
        <div class="site-left-side-wrapper hide-right-side ">
            <div class="site-left-side ">
                <div class="site-left-side-header">
                    <?= Html::button('<span class="glyphicon glyphicon-remove"></span>', ['class' => 'site-left-side-remove']) ?>
                </div>
                <?= \frontend\widgets\EmailRegistration::widget(['id' => 'email-registration', 'profile' => $home_vo->getHomeProfileView()]) ?>
                <?= TagNavigation::widget(['id' => 'tag-navigation', 
                    'most_popular_tags' => $home_vo->getMostPopularTags(), 
                    'starred_tags' => $home_vo->getStarredTagList()]) ?>

            </div>
        </div>
        <div class='site-post-area site-post-area-padding'>
            <?=  Banner::widget(['id' => 'banner']) ?>
            <?=  PostList::widget(['id' => 'post-container', 
                                    'posts' => $home_vo->getPostList(), 
                                    'current_location' => $home_vo->getCurrentUserLocation()['id']]) ?>
        </div>
    </div>
    
</div>
