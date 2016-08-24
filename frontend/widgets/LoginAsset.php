<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\widgets;

use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web' ;
    public $css = [
        'frontend/web/css/login.css'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}