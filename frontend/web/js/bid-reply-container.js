var BidReplyContainer = function($root) {
    this.$root = $root;
    this.id = $root.data('id');
    this.bid_id = $root.data('bid_id');
    this.item_transition_class = null;
    this.item_area = null;
    this.bid_reply_template_id = "bid-reply-template-id";
    this.init();
};

BidReplyContainer.prototype.init = function() {
    this.item_transition_class = 'bid-reply-container-item-transition';
    this.item_area = 'bid-reply-container-item-area';
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
                this.addToItemArea(parsed['view']);
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
    $("." + this.item_transition_class).prepend(bid_reply_transition);
};

BidReplyContainer.prototype.removeTransition = function(unique_value) {
    $("#" + this.id).find('#' + unique_value).remove();
};

BidReplyContainer.prototype.addToItemArea  = function(view) {
    $("#" + this.id).find("." + this.item_area).prepend(view);
}