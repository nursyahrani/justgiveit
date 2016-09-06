<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
/**
 * Tag model
 *
 */
class CheckIp extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%check_ip}}';
    }
    


}
