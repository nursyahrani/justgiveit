/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var BidderList = function($root) {
    this.$root = $root;
    this.$give_button = null;
    this.$cancel_button = null;
    this.stuff_id = $root.data('stuff_id');
    this.init();
    this.initEvents();
};

BidderList.prototype.init = function() {
    this.$give_button = this.$root.find('.bidder-list-item-give-button');
    
    this.$cancel_button = this.$root.find('.bidder-list-item-cancel-button');
};


BidderList.prototype.initEvents = function() {
    var self = this;
    this.$give_button.click(function(e) {
        var user_id = $(this).data('user_id');
        $(this).addClass('bidder-list-hide');
        $(this).parent().find('.bidder-list-item-cancel-button').removeClass('bidder-list-hide');
        $.ajax({
            url: $("#base-url").val() + '/post/give',
            type: 'post',
            context: this,
            data: {user_id : user_id, stuff_id: self.stuff_id},
            success: function(data) {
                var parsed = JSON.parse(data);
                if(parsed['status'] === 0) {
                    $(this).removeClass('bidder-list-hide');
                    $(this).parent().find('.bidder-list-item-cancel-button').addClass('bidder-list-hide');
                }
            }
        })
    });
    
    
    this.$cancel_button.click(function(e) {
        var user_id = $(this).data('user_id');
        $(this).addClass('bidder-list-hide');
        $(this).parent().find('.bidder-list-item-give-button').removeClass('bidder-list-hide');
        $.ajax({
            url: $("#base-url").val() + '/post/cancel-give',
            type: 'post',
            context: this,
            data: {user_id : user_id, stuff_id: self.stuff_id},
            success: function(data) {
                var parsed = JSON.parse(data);
                if(parsed['status'] === 0) {
                    $(this).removeClass('bidder-list-hide');
                    $(this).parent().find('.bidder-list-item-cancel-button').addClass('bidder-list-hide');
                }
            }
        })
    });
};

