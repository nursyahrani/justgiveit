<?php
namespace frontend\models;

use common\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class CancelStarredTagForm extends Model
{
    public $tag_name;
    
    public $user_id;
    
    public function rules()
    {
        return [
            [['tag_name', 'user_id'], 'required'],
            ['tag_name', 'string'],
            ['user_id', 'integer'],
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function create()
    {
        if($this->validate()) {
            return false;
        }
        $tag_id = \common\models\Tag::find()->where(['tag_name' => $this->tag_name])->one()['tag_id'];
        $starred_tag = \common\models\StarredTag::find()->where(['tag_id' => $tag_id, 'user_id' => $this->user_id])->one();
        return $starred_tag->delete();
    }
}
