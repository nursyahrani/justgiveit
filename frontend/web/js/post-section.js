/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var PostSection = function($root) {
    this.$root = $root;
    this.$view = null;
    this.$edit = null;
    this.$go_to_edit_button = null;
    this.$edit_cancel_button = null;
    this.$edit_edit_button = null;
    this.stuff_id = $root.data('stuff_id');
    //field
    this.$title = null;
    this.$description = null;
    this.$tags = null;
    
    //error field.
    this.$title_error = null;
    this.$description_error = null;
    this.$tags_error = null;
    
    this.init();
    this.initEvents();
};

PostSection.prototype.init = function() {
    this.$view = this.$root.find('.post-section-view');
    this.$edit = this.$root.find('.post-section-edit');
    this.$go_to_edit_button = this.$root.find('#post-section-view-edit-button');
    this.$edit_cancel_button = this.$root.find('.post-section-edit-cancel-button');
    this.$edit_edit_button = this.$root.find('.post-section-edit-edit-button');
    
    this.$title = this.$root.find('.post-section-edit-title');
    this.$description = this.$root.find('.post-section-edit-description');
    this.$tags = this.$root.find('#post-section-edit-tags');
    
    this.$title_error = this.$root.find('.post-section-edit-title-error');
    this.$description_error = this.$root.find('.post-section-edit-description-error');
    this.$tags_error = this.$root.find('.post-section-edit-tags-error');
}

PostSection.prototype.initEvents = function() {
    this.$go_to_edit_button.click(function(e) {
        this.$view.addClass('post-section-hide');
        this.$edit.removeClass('post-section-hide');
    }.bind(this));
    
    this.$edit_cancel_button.click(function(e){
        this.$view.removeClass('post-section-hide');
        this.$edit.addClass('post-section-hide');
    }.bind(this));
    
    this.$edit_edit_button.click({self:this},this.edit_);
};

PostSection.prototype.edit_ = function(e) {
    var self = e.data.self;
    $valid = self.validateInClient();
    if($valid) {
        self.submitEditToServer();
    }
};

PostSection.prototype.submitEditToServer = function() {
   $.ajax({
       url: $("#base-url").val() + "/post/edit",
       type: 'post',
       data: {title: this.getTitleVal(), description: this.getDescriptionVal(), tags: this.getTagsVal()
       , stuff_id:this.stuff_id},
       success: function(data) {
           var parsed = JSON.parse(data);
           if(parsed['status'] === 1) {
               window.location.reload();
           }
       }
   })
};

PostSection.prototype.validateInClient = function() {
    $valid = true;
    
    if(this.getTitleVal() === null || this.getTitleVal() === '') {
        $valid = false;
        this.showError(this.$title_error, 'Title should not be empty');
    } else {
        this.hideError(this.$title_error);
    }
    
    
    if(this.getDescriptionVal() === null || this.getDescriptionVal() === '') {
        $valid = false;
        this.showError(this.$description_error, 'Description should not be empty');
    } else {
        this.hideError(this.$description_error);
    }
    
    
    if(this.getTagsVal() === null || this.getTagsVal().length === 0) {
        $valid = false;
        this.showError(this.$tags_error, 'Please choose at least 1 tag');
    } else {
        this.hideError(this.$tags_error);
    }
    return $valid;
};  

PostSection.prototype.getTitleVal = function() {
    return this.$title.val();
};


PostSection.prototype.getDescriptionVal = function() {
    return this.$description.val();
};


PostSection.prototype.getTagsVal = function() {
    return this.$tags.val();
}

PostSection.prototype.showError = function($element, $message) {
    $element.html($message);
}


PostSection.prototype.hideError = function($element) {
    $element.html('');
}
