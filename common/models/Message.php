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
 * @property integer $sender_id
 * @property integer $receiver_id
 * @property string $message
 * @property integer $message_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Message extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
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

    public static function getAllMessages($receiver_id){
        $sql = "
      SELECT *
      from message , user
      where message.receiver_id = :receiver_id and message.sender_id = user.id";

        return \Yii::$app->db
            ->createCommand($sql)
            ->bindValue(':receiver_id' , $receiver_id)
            ->queryAll();
    }

    public static function getAllSentMessge($sender_id){
        $sql = "
      SELECT *
      from message , user
      where message.sender_id = :sender_id and message.sender_id = user.id";

        return \Yii::$app->db
            ->createCommand($sql)
            ->bindValue(':sender_id' , $sender_id)
            ->queryAll();
    }
}
