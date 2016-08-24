/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var BidContainer = function($root) {
    this.$root = $root;
    this.$bid_list = {};
    this.init();
};

BidContainer.prototype.init = function() {
    var self = this;
    $.each($(".bid"), function(index, value) {
        var stuff_id = $(value).find('id');
        self.$bid_list[stuff_id] = new Bid($(value));
    });
}



