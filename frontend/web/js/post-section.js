//pre-loaded

var PostSection = function($root) {
    this.$root = $root;
    this.id = $root.data('id');
    this.stuff_id = $root.data('stuff_id');

    //proposal_field = null;
    this.$quantity = null;
    this.quantity = null;
    this.$text_area = null;
    this.$bid_button = null;
    this.$request_favorite_button = null;
    this.$cancel_favorite_button = null;
    this.$delete_button = null;
    this.$edit_button = null;
    
    //proposal field error
    this.$quantity_error = null;
    this.$text_area_error = null;
    
    this.init();
    this.initEvents();
};


PostSection.prototype.init = function() {
    
    this.$quantity = this.$root.find('#' + this.id + '-quantity-widget');
    this.quantity = new QuantityWidget(this.$quantity);
    this.$text_area = this.$root.find('#' + this.id + '-text-area');
    this.$bid_button = this.$root.find('.post-section-bid');
    
    //proposal field error
    this.$text_area_error = this.$root.find('.post-section-text-area-section-error');
    this.$quantity_error = this.$root.find('.post-section-quantity-error');
    
    this.$request_favorite_button = this.$root.find('.post-section-request-favorite');
    this.$cancel_favorite_button = this.$root.find('.post-section-cancel-favorite');
    this.$delete_button = this.$root.find('.post-section-owner-delete');
    this.$edit_button = this.$root.find('.post-section-owner-edit');
    
    this.$view = this.$root.find('.post-section-view');
    this.$edit = this.$root.find('.post-section-edit');
    
    this.$edit_post = this.$root.find('#' + this.id + '-edit-post');
    this.edit_post  = new EditPost(this.$edit_post);
    
};

PostSection.prototype.initEvents = function() {
    
    this.$edit_post.on(EditPost.prototype.EVENTS.EDIT_POST_CANCEL, function(e) {
        this.$view.removeClass('hide');
        this.$edit.addClass('hide');
    }.bind(this));

    this.$delete_button.click(function(e) {
        krajeeDialog.confirm('Are you sure you want to delete this post?', function(out){
            if(out) {
                this.deletePost();
            }
        }.bind(this));
    }.bind(this));
    
    this.$edit_button.click(function(e) {
        this.$view.addClass('hide');
        this.$edit.removeClass('hide');
    }.bind(this));
    
    
    this.$bid_button.click(function(e) {
        if(CommonLibrary.isGuest()) {
            return false;
        }
        var valid = this.   validateInClient();
        if(valid) {
            this.sendProposal();
        }
    }.bind(this));
    
    this.$request_favorite_button.click(function(e) {
        if(CommonLibrary.isGuest()) {
            return false;
        }
        $.ajax({
          url : $("#base-url").val() + '/post/request-favorite',
          type: 'post',
          data: {stuff_id: this.stuff_id},
          success: function(data) {
              var parsedData = JSON.parse(data);
              if(parsedData['status'] === 1 ) {
                    window.location.reload();
              }
          }

        });   

    }.bind(this));
    
    
    this.$cancel_favorite_button.click(function(e) {
        $.ajax({
          url : $("#base-url").val() + '/post/cancel-favorite',
          type: 'post',
          data: {stuff_id: this.stuff_id},
          success: function(data) {
              var parsedData = JSON.parse(data);
              if(parsedData['status'] === 1 ) {
                    window.location.reload();
              }
          }

        });   
    }.bind(this));
    
    this.$text_area.on('focus',function(e) {
        if(CommonLibrary.isGuest()) {
            return false;
        }
    }.bind(this));
};

PostSection.prototype.deletePost = function() {
    $.ajax({
        url: $("#base-url").val() + "/post/delete",
        type: 'post',
        data: {stuff_id: this.stuff_id},
        success: function(data) {
            var parsed = JSON.parse(data);
            if(parsed['status'] === 1) {
                window.location.reload();
            } else {
                
            }
        }
    })
}

PostSection.prototype.sendProposal = function() {
    $.ajax({
        url: $("#base-url").val() + "/bid/send-bid",
        type: 'post',
        data: {quantity: this.getQuantityVal(), message: this.getTextAreaHtml(), stuff_id: this.stuff_id},
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
    
    if(this.getQuantityVal() === 0 || isNaN(this.getQuantityVal())) {
        $valid = false;
        this.showError(this.$quantity_error, 'Quantity should be at least 1');
    } else {
        this.hideError(this.$quantity_error);
    }
   
    if(this.getTextAreaText() === null || this.getTextAreaText() === '') {
        $valid = false;
        this.showError(this.$text_area_error, 'Please send a sentence to the owner to convince them you deserve this stuff');
    } else {
        this.hideError(this.$text_area_error);
    }
    return $valid;
};  

PostSection.prototype.getQuantityVal = function() {
    return this.quantity.getQuantity();
};

PostSection.prototype.getTextAreaText = function() {
    return this.$text_area.text();
}

PostSection.prototype.getTextAreaHtml = function() {
    return this.$text_area.html();
}

PostSection.prototype.showError = function($element, $message) {
    $element.html($message);
}


PostSection.prototype.hideError = function($element) {
    $element.html('');
}
