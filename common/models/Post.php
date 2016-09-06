<?php
namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class Post extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_CLOSED = 11;
    
    const GIVE_STUFF = 'give';
    const ASK_STUFF = 'ask';
    const DONATION_MONEY = 'donate';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    public static function getAllGiveStuffs(){
        $give = self::GIVE_STUFF;
        $sql = "SELECT *  from post,user where type = 'give' and post.poster_id = user.id";

        return \Yii::$app->db
            ->createCommand($sql)
            ->queryAll();
    }

    public static function getAllAskStuffs(){
        $ask = self::ASK_STUFF;
        $sql = "SELECT * from post where type =
        '$ask'" ;

        return \Yii::$app->db
            ->createCommand($sql)
            ->queryAll();
    }

    public static function getStuffCreatedBy($user_id){
        $sql  = "SELECT  * from user, post where post.poster_id = :poster_id and user.id = post.poster_id";
        return \Yii::$app->db
            ->createCommand($sql)
            ->bindValue(':poster_id', $user_id)
            ->queryAll();
    }

}
