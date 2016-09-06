// load dynamically
var BidReplyContainer = function($root) {
    this.$root = $root;
    this.id = $root.data('id');
    this.bid_id = $root.data('bid_id');
    this.offset  = $root.data('offset');
    this.first_created_at  = $root.data('first_created_at');
    this.item_transition_class = null;
    this.item_area = null;
    this.bid_reply_template_id = "bid-reply-template-id";
    this.load_more_replies_class = "bid-reply-container-load-replies";
    this.total_replies_class = 'bid-reply-container-total-replies';
    this.init();
    this.initEvents();
};

BidReplyContainer.prototype.init = function() {
    this.item_transition_class = 'bid-reply-container-item-transition';
    this.item_area = 'bid-reply-container-item-area';
};

BidReplyContainer.prototype.initEvents = function() {
    $(document).on('click', '#' + this.id, function(e) {
        if(e.target && $(e.target).hasClass(this.load_more_replies_class)) {
            this.getMoreReplies();
        }
    }.bind(this));
};

BidReplyContainer.prototype.getMoreReplies = function() {
    $.ajax({
        url: $("#base-url").val() + "/bid/get-more-replies",
        type: 'post',
        context: this,
        data: {bid_id: this.bid_id, first_created_at: this.first_created_at, offset: this.offset},
        success: function(data) {
            var parsed = JSON.parse(data);
            if(parsed['status'] === 1) {
                this.appendToItemArea(parsed['view']);
                this.substractTotalMoreReplies(parsed['count']);
                this.offset += parseInt(parsed['count']);
                this.last_created_at = parsed['last_created_at'];
            }
        }
    });
};

BidReplyContainer.prototype.setNewMessage = function(message) {
    var unique_value = "bid-reply-transition-" + new Date().getUTCMilliseconds();
    this.addToTransition(message, unique_value);
    $.ajax({
        url: $("#base-url").val() + '/bid/reply',
        type: 'post',
        context: this,
        data: {bid_id: this.bid_id, message: message},
        success: function(data) {
            var parsed = JSON.parse(data);
            if(parsed['status'] === 1) {
                this.prependToItemArea(parsed['view']);
            }
            this.removeTransition(unique_value);
        }
    });
};

BidReplyContainer.prototype.addToTransition = function(message, unique_value) {
    var bid_reply_template = CommonLibrary.getBidReplyTemplate();
    var bid_reply_transition = bid_reply_template.replace(
            this.bid_reply_template_id, unique_value);
    bid_reply_transition = bid_reply_transition.replace("{message}", message);
    $("#" + this.id).find("." + this.item_transition_class).prepend(bid_reply_transition);
};

BidReplyContainer.prototype.removeTransition = function(unique_value) {
    $("#" + this.id).find('#' + unique_value).remove();
};

BidReplyContainer.prototype.prependToItemArea  = function(view) {
    $("#" + this.id).find("." + this.item_area).prepend(view);
}

BidReplyContainer.prototype.appendToItemArea = function(view) {
    $("#" + this.id).find("." + this.item_area).append(view);
}

BidReplyContainer.prototype.substractTotalMoreReplies = function(value) {
    var $element = $("#" + this.id).find('.' + this.total_replies_class);
    var total_replies = parseInt($element.html());
    var remaining = total_replies - value;
    if(remaining <= 0) {
        $element.parent().addClass('hide');
    } else {
        $element.html(total_replies - value);
    }
}