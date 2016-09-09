<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/notification-item.css',
        'css/post-comment.css',
        'css/create-post.css',
        'css/post-delete.css',
        'css/post.css',
        'css/site.css',
    ];
    public $js = [
        'frontend/web/js/common-library.js',
        'frontend/web/js/quantity-widget.js',
        'frontend/web/js/shipping-preference-checkbox.js',
        'frontend/web/js/loading.js',
        'frontend/web/js/link-dropdown.js',
        'frontend/web/js/auto-height-text-area.js',
        'frontend/web/js/button-with-tooltip.js',
        'frontend/web/js/change-image.js',
        'frontend/web/js/image-view-editor.js',
        'frontend/web/js/home-proposal-box.js',
        'frontend/web/js/search-bar.js',
        'frontend/web/js/banner-with-search.js',
        'frontend/web/js/post-card.js',
        'frontend/web/js/suggested-post.js',
        'frontend/web/js/bid-reply-container.js',
        'frontend/web/js/bid.js',
        'frontend/web/js/login.js',
        'frontend/web/js/bid-container.js',
        'frontend/web/js/bidder-list.js',
        'frontend/web/js/edit-post.js',
        'frontend/web/js/post-section.js',
        'frontend/web/js/post-comment.js',
        'frontend/web/js/post-comment-container.js',
        'frontend/web/js/post-list.js',
        'frontend/web/js/post.js',
        'frontend/web/js/create-post.js',
        'frontend/web/js/tag-navigation.js',
        'frontend/web/js/email-registration.js',
        'frontend/web/js/site.js',
        'frontend/web/js/notification-list.js',
        'frontend/web/js/script.js'  
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
