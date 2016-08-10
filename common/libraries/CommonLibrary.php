<?php

namespace common\libraries;
use Yii;
class CommonLibrary {
    public static function buildImageLibrary($image_path) {
        if($image_path === null) {
            $image_path = 'default.png';
        }
        return Yii::$app->request->baseUrl  . '/frontend/web/'  . $image_path;   
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
}