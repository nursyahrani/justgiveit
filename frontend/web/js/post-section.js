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
};

PostSection.prototype.initEvents = function() {
    this.$bid_button.click(function(e) {
        var valid = this.validateInClient();
        if(valid) {
            this.sendProposal();
        }
    }.bind(this));
    
    this.$request_favorite_button.click(function(e) {
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
};

PostSection.prototype.sendProposal = function() {
    $.ajax({
        url: $("#base-url").val() + "/post/send-bid",
        type: 'post',
        data: {quantity: this.getQuantityVal(), message: this.getTextareaVal(), stuff_id: this.stuff_id},
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
    
    if(this.getQuantityVal() === 0) {
        $valid = false;
        this.showError(this.$quantity_error, 'Quantity should be at least 1');
    } else {
        this.hideError(this.$quantity_error);
    }
   
    if(this.getTextareaVal() === null || this.getTextareaVal() === '') {
        $valid = false;
        this.showError(this.$text_area_error, 'Please send a word to the owner to convince them you deserve this stuff');
    } else {
        this.hideError(this.$text_area_error);
    }
    return $valid;
};  

PostSection.prototype.getQuantityVal = function() {
    return this.quantity.getQuantity();
};

PostSection.prototype.getTextareaVal = function() {
    return this.$text_area.val();
}

PostSection.prototype.showError = function($element, $message) {
    $element.html($message);
}


PostSection.prototype.hideError = function($element) {
    $element.html('');
}
