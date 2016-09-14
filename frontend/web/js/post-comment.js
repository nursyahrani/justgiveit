//dynamic loaded
var PostComment = function($root) {
    this.$root = $root;
    this.id = $root.data('id');
    this.comment_id = $root.data('comment_id');
    this.user_link = $root.data('user_link');
    this.full_name = $root.data('full_name');
    this.reply_class = null;
    this.edit_class = null;
    this.send_edit_class = null;
    this.cancel_edit_class = null;
    this.delete_class = null;
    this.edit_area_class = null;
    this.edit_text_area_class = null;
    this.view_area_class = null;
    this.delete_event_ = null;
    this.reply_event_ = null;
    
    
    this.init();
    this.initEvents();
    this.initWidgetEvents();
};

PostComment.prototype.init = function() {
    this.reply_class = 'post-comment-reply';
    this.edit_class = 'post-comment-edit';
    this.send_edit_class = 'post-comment-message-edit-button';
    this.cancel_edit_class = 'post-comment-message-cancel-button';
    this.delete_class  = 'post-comment-delete';
    this.edit_text_area_class = 'post-comment-message-edit-text';
    this.edit_area_class = 'post-comment-message-edit';
    this.view_area_class = 'post-comment-message';
};

PostComment.prototype.initEvents = function() {
    $(document).on('click', "#" + this.id, function(e) {
        if(e.target && $(e.target).hasClass(this.delete_class)) {
            ConfirmationModal.show('Are you sure you want to delete this comment?', function(out){
                if(out) {
                    this.deleteComment();
                }
            }.bind(this));
        } 
        else if(e.target && $(e.target).hasClass(this.reply_class)) {
            this.triggerReplyEvent({user_link:this.user_link, full_name: this.full_name});
        }
        else if(e.target && $(e.target).hasClass(this.edit_class)) {
            $("#" + this.id).find("." + this.edit_area_class).removeClass('hide');
            $("#" + this.id).find("." + this.view_area_class).addClass('hide');
        }
        else if(e.target && $(e.target).hasClass(this.cancel_edit_class)) {
            this.cancelEditComment();
        } 
        else if(e.target && $(e.target).hasClass(this.send_edit_class)) {
            this.sendEditComment();
        }
    }.bind(this));
};

PostComment.prototype.cancelEditComment = function() {
    $("#" + this.id).find("." + this.edit_area_class).addClass('hide');
    $("#" + this.id).find("." + this.view_area_class).removeClass('hide');
};

PostComment.prototype.sendEditComment = function() {
    if(this.getTextAreaText() === null || this.getTextAreaText() === '') {
        this.cancelEditComment();
        return;
    }
    this.setViewMessage(this.getTextAreaHtml());
    this.cancelEditComment();
    $.ajax( {
        url: $("#base-url").val() + "/post-comment/edit",
        type: 'post',
        context:this,
        data: {comment_id: this.comment_id, message: this.getTextAreaHtml()},
        success: function(data) {
            
        }
    })
};

PostComment.prototype.getTextAreaText = function() {
   return $("#" + this.id).find("." + this.edit_text_area_class).text();
};

PostComment.prototype.getTextAreaHtml = function() {
    
   return $("#" + this.id).find("." + this.edit_text_area_class).html();
}

PostComment.prototype.setViewMessage = function(message) {
    $("#" + this.id).find('.' + this.view_area_class).html(message);
}

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