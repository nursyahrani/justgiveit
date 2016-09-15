<?php

namespace common\libraries;
use Yii;
class CommonLibrary {
    public static function buildImageLibrary($image_path, $width = 500, $height = 500) {
        if($image_path === null) {
            $image_path = 'default.png';
        }
        return Yii::getAlias('@web')  . '/image?path='  . "$image_path&width=" . $width . '&height=' . $height;   
    }
    
    public static function buildTagLibrary($tag) {
        return Yii::$app->request->baseUrl . '/tag/' . $tag;
    }
    
    public static function getTextFromTimeDifference($deadline) {
        
        $etime = $deadline - time();

        if ($etime < 1)
        {
            return '0 seconds';
        }

        $a = array( 365 * 24 * 60 * 60  =>  'year',
            30 * 24 * 60 * 60  =>  'month',
            24 * 60 * 60  =>  'day',
            60 * 60  =>  'hour',
            60  =>  'minute',
            1  =>  'second'
        );
        $a_plural = array( 'year'   => 'years',
            'month'  => 'months',
            'day'    => 'days',
            'hour'   => 'hours',
            'minute' => 'minutes',
            'second' => 'seconds'
        );

        foreach ($a as $secs => $str)
        {
            $d = $etime / $secs;
            if ($d >= 1)
            {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' remaining';
            }
        }

    }
    
    public static function getTimeText($unix_timestamp) {
        $etime = time() - $unix_timestamp;

        if ($etime < 1)
        {
            return '0 seconds';
        }

        $a = array( 365 * 24 * 60 * 60  =>  'year',
            30 * 24 * 60 * 60  =>  'month',
            24 * 60 * 60  =>  'day',
            60 * 60  =>  'hour',
            60  =>  'minute',
            1  =>  'second'
        );
        $a_plural = array( 'year'   => 'years',
            'month'  => 'months',
            'day'    => 'days',
            'hour'   => 'hours',
            'minute' => 'minutes',
            'second' => 'seconds'
        );

        foreach ($a as $secs => $str)
        {
            $d = $etime / $secs;
            if ($d >= 1)
            {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
            }
        }

    }
    
    public static function stringifyWidgetOption($options) {
          $stringify_options = '';
        foreach ($options as $key   => $value) {
            $stringify_options .= $key . '=' . $value . ' ';
        }
        
        return $stringify_options;
        
    }
    
    
    public static function loadingResourceUrl() {
        return Yii::$app->request->baseUrl . '/frontend/web/common-img/loading.gif';
    }
    
    public static function cutText($text, $length = 50) {
        return substr($text, 0, $length);
    }
    
    public static function replaceTemplate($template, $args) {
        foreach($args  as $index => $arg) {
            $template = str_replace("%" .($index + 1) . "$%", $arg, $template);
        }
        
        return $template;
    }
}