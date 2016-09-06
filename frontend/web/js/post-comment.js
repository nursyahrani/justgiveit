//dynamic loaded
var PostComment = function($root) {
    this.$root = $root;
    this.id = $root.data('id');
    this.comment_id = $root.data('comment_id');
    this.user_link = $root.data('user_link');
    this.full_name = $root.data('full_name');
    this.reply_class = null;
    this.edit_class = null;
    this.delete_class = null;
    
    this.delete_event_ = null;
    this.reply_event_ = null;
    this.init();
    this.initEvents();
    this.initWidgetEvents();
};

PostComment.prototype.init = function() {
    this.reply_class = 'post-comment-reply';
    this.edit_class = 'post-comment-edit';
    this.delete_class  = 'post-comment-delete';
};

PostComment.prototype.initEvents = function() {
    $(document).on('click', "#" + this.id, function(e) {
        if(e.target && $(e.target).hasClass(this.delete_class)) {
            krajeeDialog.confirm('Are you sure you want to delete this comment?', function(out){
                if(out) {
                    this.deleteComment();
                }
            }.bind(this));
        } 
        else if(e.target && $(e.target).hasClass(this.reply_class)) {
            this.triggerReplyEvent({user_link:this.user_link, full_name: this.full_name});
        }
    }.bind(this));
};

PostComment.prototype.initWidgetEvents = function() {
    this.delete_event_ = new CustomEvent(this.EVENTS.POST_COMMENT_DELETE_EVENT);
    this.reply_event_ = new CustomEvent(this.EVENTS.POST_COMMENT_REPLY_EVENT);
};

PostComment.prototype.deleteComment = function() {
    $.ajax({
       url: $("#base-url").val() + '/post-comment/delete',
       type: 'post',
       context: this,
       data: {comment_id: this.comment_id},
       success: function(data) {
           var parsed = JSON.parse(data);
           if(parsed['status'] === 1) {
                $("#" + this.id).remove();
            }
       }
    });
};

PostComment.prototype.EVENTS = {
    POST_COMMENT_DELETE_EVENT : 'post-comment-delete-event',
    POST_COMMENT_REPLY_EVENT : 'post-comment-reply-event'
};
PostComment.prototype.triggerDeleteEvent  = function(comment_id) {
    return this.$root.trigger(this.EVENTS.POST_COMMENT_DELETE_EVENT, [comment_id])
}

PostComment.prototype.triggerReplyEvent = function(data) {
    return $("#" + this.id).trigger(this.EVENTS.POST_COMMENT_REPLY_EVENT, [data]);
}