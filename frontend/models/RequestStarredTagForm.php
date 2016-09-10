<?php
namespace frontend\models;

use common\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class RequestStarredTagForm extends Model
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
        if(!$this->validate()) {
            return false;
        }
        $tag_id = \common\models\Tag::find()->where(['tag_name' => $this->tag_name])->one()['tag_id'];
        $starred_tag = new \common\models\StarredTag;
        $starred_tag->tag_id = $tag_id;
        $starred_tag->user_id = $this->user_id;

        return $starred_tag->save();
    }
}
