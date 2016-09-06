//dynamic loading

var PostCommentContainer = function($root) {
    this.$root = $root;
    this.id = $root.data('id');
    this.post_id = $root.data('post_id');
    this.submit_comment_class = null;
    this.text_area_id = null;
    this.text_area_error_class = null;
    this.post_comment_class = null;
    this.post_comment_area_class = null;
    this.post_comments = [];
    this.init();
    this.initEvents();
};

PostCommentContainer.prototype.init = function() {
    

    this.submit_comment_class = 'post-comment-container-submit-comment';
    this.text_area_id = this.id + "-text-area";
    this.text_area_error_class = 'post-comment-container-text-box-error';
    this.post_comment_area_class = 'post-comment-container-area';
    this.post_comment_class = 'post-comment';
    $.each($("#" + this.id).find('.post-comment') , function(index, value) {
        this.post_comments.push(new PostComment($(value))); 
        
    }.bind(this));
};

PostCommentContainer.prototype.initEvents = function() {
    $(document).on('click', "#" + this.id, function(e) {
        if(e.target && $(e.target).hasClass(this.submit_comment_class)) {
            this.submitComment();
        }
    }.bind(this));
    
    $(document).on(PostComment.prototype.EVENTS.POST_COMMENT_DELETE_EVENT, "#" + this.id, function(e,data) {
        if(e.target && $(e.target).hasClass(this.post_comment_class)) {
            //TODO: remove from the array class
        }
    }.bind(this));
    
    
    $(document).on(PostComment.prototype.EVENTS.POST_COMMENT_REPLY_EVENT, "#" + this.id, function(e,data) {
        if(e.target && $(e.target).hasClass(this.post_comment_class)) {
            //data is user_id
            var user_link = "<a href='" + data['user_link'] + "'>" + data['full_name']  +"</a>";
            this.appendValueToTextArea(user_link);
        }
    }.bind(this));
};

PostCommentContainer.prototype.submitComment = function() {
    $valid = this.validateClient();
    if($valid !== false) {
        this.disableSubmitButton();
        $.ajax({
            url: $("#base-url").val() + '/post-comment/create',
            type: 'post',
            context: this,
            data: {message: this.getTextAreaVal(), post_id: this.post_id},
            success: function(data) {
                var parsed = JSON.parse(data);
                this.prependToItemArea(parsed['view']);
                this.post_comments.push(new PostComment($(parsed['view']))); 


                this.setTextAreaToNull();
                this.enableSubmitButton();
            }
        });
    }
}

PostCommentContainer.prototype.validateClient = function() {
    $valid = true;
    
    if(this.getTextAreaVal() === null || this.getTextAreaVal() === '') {
        CommonLibrary.showError($("#" + this.id).find('.' + this.text_area_error_class), 'Text box cannot be empty');
        $valid = false;
    } else {
        CommonLibrary.hideError($("#" + this.id).find('.' + this.text_area_error_class));
    }
    
    return $valid;
};

PostCommentContainer.prototype.getTextAreaVal = function() {
    return $("#" + this.id).find('#' + this.text_area_id).html();
}

PostCommentContainer.prototype.setTextAreaToNull = function() {
    return $("#" + this.id).find('#' + this.text_area_id).html("");
}

PostCommentContainer.prototype.appendValueToTextArea = function(value) {
    return $("#" + this.id).find('#' + this.text_area_id).append(value);
}

PostCommentContainer.prototype.enableSubmitButton = function() {
    $("#" + this.id).find('.' + this.submit_comment_class).removeClass('disabled');
}

PostCommentContainer.prototype.disableSubmitButton = function() {
    $("#" + this.id).find('.' + this.submit_comment_class).addClass('disabled');
}

PostCommentContainer.prototype.prependToItemArea = function(view) {
    $("#" + this.id).find('.' + this.post_comment_area_class).prepend(view);
}