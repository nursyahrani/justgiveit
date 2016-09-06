var EditPost = function($root) {
    this.$root = $root;
    this.id = $root.data('id');
    this.stuff_id = $root.data('stuff_id');
    this.$tags = null;
    this.$title = null;
    this.$description = null;
    this.$quantity = null;
    
    this.$title_error = null;
    this.$description_error = null;
    this.$quantity_error = null;
    this.$tags_error = null;
    
    this.$cancel = null;
    this.$edit = null;
    
    this.cancel_event_ = null;
    this.init();
    this.initEvents();
    this.initWidgetEvents();
};

EditPost.prototype.init = function() {
    this.$quantity_error = this.$root.find('.edit-post-quantity-error');
    this.$description_error = this.$root.find('.edit-post-description-error');
    this.$tags_error = this.$root.find('.edit-post-tags-error');
    this.$title_error = this.$root.find('.edit-post-title-error');
    
    this.$quantity = this.$root.find('.edit-post-quantity');
    this.$description = this.$root.find('.edit-post-description');
    this.$tags = this.$root.find('#' + this.id + '-tags');
    this.$title = this.$root.find('.edit-post-title');
    
    this.$edit = this.$root.find('.edit-post-edit');
    this.$cancel = this.$root.find('.edit-post-cancel');
};

EditPost.prototype.initEvents = function(){
    this.$cancel.click(function(e) {
        this.triggerCancelEvent();
    }.bind(this));
    
    this.$edit.click(function(e) {
        $valid = this.validateClient();
        this.sendEdit();
    }.bind(this));
};

EditPost.prototype.sendEdit = function() {
    this.disableButton();
    $.ajax({
        url: $("#base-url").val() + "/post/edit",
        type: 'post',
        context: this,
        data: {title: this.getTitleVal(), description: this.getDescriptionVal(), 
            tags: this.getTagsVal(), quantity: this.getQuantityVal(), stuff_id:this.stuff_id},
        success: function(data) {
            var parsed = JSON.parse(data);
            if(parsed['status'] === 1) {
                window.location.reload();
            } else { 
                this.enableButton();
            }
        }
    });
};

EditPost.prototype.validateClient = function() {
    var valid = true;
    if(this.getTitleVal() === null || this.getTitleVal() === '' ) {
        valid  = false;
        CommonLibrary.showError(this.$title_error, 'Title cannot be empty');
    } else {
        CommonLibrary.hideError(this.$title_error);
    }

    if(this.getDescriptionVal() === null || this.getDescriptionVal() === '' ) {
        valid = false;
        CommonLibrary.showError(this.$description_error, 'Please put some descriptions about the stuff');
    } else {
        CommonLibrary.hideError(this.$description_error);
    }

    if(this.getTagsVal() === null || this.getTagsVal().length === 0) {
        valid = false;
        CommonLibrary.showError(this.$tags_error, 'Please choose at least 1 tag');
        
    } else {
        CommonLibrary.hideError(this.$tags_error);
    }
    
    if(this.getQuantityVal() === 0 || isNaN(this.getQuantityVal())) {
        valid = false;
        CommonLibrary.showError(this.$quantity_error, 'Quantity should be at least 1');
    } else {
        CommonLibrary.hideError(this.$quantity_error);
    }
    
    return valid;

};

EditPost.prototype.initWidgetEvents = function() {
    this.cancel_event_ = new CustomEvent(this.EVENTS.EDIT_POST_CANCEL);
}

EditPost.prototype.EVENTS = {
    EDIT_POST_CANCEL : 'edit-post-cancel'
};

EditPost.prototype.triggerCancelEvent = function() {
    this.$root.trigger(this.EVENTS.EDIT_POST_CANCEL);
}


EditPost.prototype.getTitleVal = function() {
    return this.$title.val();
};


EditPost.prototype.getDescriptionVal = function() {
    return this.$description.val();
};

EditPost.prototype.getTagsVal = function() {
    return this.$tags.val();
}


EditPost.prototype.getQuantityVal = function() {
    var quantity = this.$quantity.val();
    if(quantity === null) {
        quantity = 0;
    }
    
    return parseInt( quantity);
}

EditPost.prototype.disableButton = function() {
    this.$edit.addClass('disabled');
}

EditPost.prototype.enableButton = function() {
    this.$edit.removeClass('disabled');
};