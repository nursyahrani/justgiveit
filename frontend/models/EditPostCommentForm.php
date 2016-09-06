<?php

namespace frontend\models;

use common\models\Post;
use yii\base\Model;
use common\libraries\UserLibrary;
use common\models\PostComment;
/**
 * ContactForm is the model behind the contact form.
 */
class EditPostCommentForm extends Model
{
    public $user_id;
    public $comment_id;
    public $message;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['user_id', 'comment_id', 'message'], 'required'],
            [['user_id', 'comment_id'], 'integer'],
            ['message', 'string']
        ];
    }

    public function edit(){
        //save post
        if(!$this->validate()) {
            return false;
        }
        $post_comment = $this->getPostComment();
        if($post_comment && UserLibrary::isOwner($post_comment['user_id'], $this->user_id)) {
            $post_comment->message = $this->message;
            $post_comment->update();
            return true;
        }
        
        return false;
    }
    
    private function getPostComment() {
        return PostComment::find()->where(['comment_id' => $this->comment_id])->one();
    }
    
    

}
