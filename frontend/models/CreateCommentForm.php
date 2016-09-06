<?php
namespace frontend\models;

use common\models\User;
use common\models\Post;
use yii\base\Model;
use Yii;
use common\models\Bid;
/**
 * Signup form
 */
class CreateCommentForm extends Model
{
    public $post_id;
    public $user_id;
    public $message;
    /*
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'post_id', 'message'], 'required'],
            [['user_id', 'post_id'], 'integer'],
            ['message', 'string']
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function create()
    {
        if (!$this->validate()) {
        
            return false;
        }
        $model = new \common\models\PostComment();
        $model->post_id = $this->post_id;
        $model->user_id = $this->user_id;
        $model->message = $this->message;
        if(!$model->save()) {
            return false;
        }

        return $model->comment_id;
    }
    
}
