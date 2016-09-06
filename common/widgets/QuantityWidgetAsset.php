<?php

namespace common\widgets;

use yii\web\AssetBundle;

class QuantityWidgetAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web' ;
    public $css = [
        'frontend/web/css/quantity-widget.css'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
