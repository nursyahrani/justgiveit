/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    var Post = function($root) {
        this.$root = $root;
        this.$bid_button = null;
        this.$proposal_box_modal = null;
        this.$proposal_box = null; 
        this.proposal_box = null;
        this.bid_container = null;
        this.$bid_container = null;
        this.init();
        this.initEvents();
    };
    
    Post.prototype.init = function() {
        this.$bid_button = this.$root.find('.post-bid-button');
        this.$proposal_box_modal = this.$root.find('.post-proposal-box-modal');
        this.$proposal_box = this.$root.find('.home-proposal-box-container');
        this.proposal_box = new HomeProposalBox(this.$proposal_box);
        this.$bid_container = this.$root.find('.bid-container');
        this.bid_container = new BidContainer(this.$bid_container);
    };
    
    Post.prototype.initEvents = function() {
        var self = this;
        this.$bid_button.on('click', function(e) {
            self.$proposal_box_modal.modal("show");
            self.$proposal_box_modal.load($(this).attr("value"));
        });
        
        this.$proposal_box.on(HomePostList.prototype.EVENT.HOME_PROPOSAL_BOX_PROPOSAL_SENT, function(e, stuff_id) {
            
        });
    };
    
    Post.prototype.addBidLayoutByStuffId = function(stuff_id) {
        $.ajax({
            url : $("#base-url").val() + "/bid/get-bid-layout",
            context: this,
            data: {stuff_id: stuff_id},
            type: 'post',
            success: function(data) {
                if(data['status'] === 1) {

                } else {

                }
            }
        })
    };