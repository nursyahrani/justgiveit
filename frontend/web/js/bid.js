//dynamically added 
var Bid = function($root) {
    this.$root = $root;
    this.id = $root.data('id');
    this.bid_id = $root.data('bid_id');
    this.text_area_id = null;
    this.bid_reply_area_class = null;
    this.bid_reply_container_id = null;
    
    this.bid_reply_container = null;
    this.$bid_reply_container = null;
    
    this.bid_give_class = 'bid-give';
    this.cancel_give_class = 'bid-cancel-give';
    this.bid_delete_class = null;
    this.init();
    this.initEvents();
};

Bid.prototype.init = function() {
    this.text_area_id = this.id  + "-reply-box";
    this.bid_reply_area_class = 'bid-reply-area';
    this.bid_reply_container_id = this.id + "-bid-reply-container";
    this.bid_delete_class = 'bid-delete';
    this.$bid_reply_container = $("#" + this.id).find("#" + this.bid_reply_container_id);
    this.bid_reply_container = new BidReplyContainer(this.$bid_reply_container);
    
};

Bid.prototype.initEvents = function() {
    var map = {13: false};
  
    
    $(document).on('click', '#' + this.id, function(event) {
        if(event.target && ($(event.target).hasClass(this.bid_give_class))) {
            $("#" + this.id).find('.' + this.cancel_give_class).removeClass('hide');
            $("#" + this.id).find('.' + this.bid_give_class).addClass('hide');

            $.ajax({
                url: $("#base-url").val() + "/bid/give",
                type: 'post',
                context: this,
                data: {bid_id: this.bid_id},
                success: function(data) {
                },
                error : function(data) {
                }
            });

        }
        else if(event.target && ($(event.target).hasClass(this.cancel_give_class))) {
            
            $("#" + this.id).find('.' + this.bid_give_class).removeClass('hide');
            $("#" + this.id).find('.' + this.cancel_give_class).addClass('hide');

            $.ajax({
                url: $("#base-url").val() + "/bid/cancel-give",
                type: 'post',
                context: this,
                data: {bid_id: this.bid_id},
                success: function(data) {
                },
                error : function(data) {
                }
            });
        }
        else if(event.target && $(event.target).hasClass(this.bid_delete_class)) {
            krajeeDialog.confirm('Are you sure to remove your proposal?', function(out){
                if(out) {
                    this.deleteBid();
                }
            }.bind(this));

        }
    }.bind(this)); 
    
    
    $(document).on('keypress', '#' + this.id, function(event) {
        if(event.target && ($(event.target).prop('id') === this.text_area_id)) {
            if(event.keyCode in map) {
                map[event.keyCode ] = true;
                if(map[13] && !event.shiftKey && this.getReplyValue().trim() !== '' ) {
                   this.submitReply();
                   event.preventDefault();
                }
            }
        }
    }.bind(this)); 
    
    
    $(document).on('keyup', '#' + this.id, function(event) {
        if(event.target && ($(event.target).prop('id') === this.text_area_id)) {
            if(event.keyCode in map) {
                map[event.keyCode ] = false;
            }
        }
    }.bind(this)); 
};

Bid.prototype.getReplyValue = function() {
    return $("#" + this.id).find('#' + this.text_area_id).html();
}

Bid.prototype.submitReply = function() {
    this.bid_reply_container.setNewMessage(this.getReplyValue());
    this.emptyReplyBox();
}

Bid.prototype.emptyReplyBox = function() {
    $("#" + this.id).find('#' + this.text_area_id).html("");
}

Bid.prototype.deleteBid = function() {
    $("#" + this.id).remove();
    $.ajax({
        url: $("#base-url").val() + "/bid/delete",
        data: {bid_id: this.bid_id},
        type: 'post',
        success: function(data) {
            
        }
    })
}