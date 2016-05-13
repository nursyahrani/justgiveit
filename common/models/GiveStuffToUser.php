<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $stuff_id
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class GiveStuffToUser extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%give_stuff_to_user}}';
    }



}
