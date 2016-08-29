/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var Post = function($root) {
    this.$root = $root;
    this.stuff_id = $root.data('stuff_id');
    this.$bid_button = null;
    this.$proposal_box_modal = null;
    this.$proposal_box = null; 
    this.proposal_box = null;
    this.bid_container = null;
    this.$bid_container = null;
    this.bidder_list = null;
    this.$bidder_list = null;
    this.$post_section = null;
    this.post_section = null;
    this.$post_image_view_editor = null;
    this.post_image_view_editor = null;
    this.$post_image = null;
    this.$change_image_button = null;
    this.$change_image_modal = null;
    this.$change_image = null;
    this.change_image = null;
    
    this.init();
    this.initEvents();
};

Post.prototype.init = function() {
    this.$bid_button = this.$root.find('#post-bid-button');
    this.$proposal_box_modal = this.$root.find('.post-proposal-box-modal');
    this.$proposal_box = this.$root.find('.home-proposal-box-container');
    this.proposal_box = new HomeProposalBox(this.$proposal_box);
    this.$bid_container = this.$root.find('#post-bid-containers');
    this.bid_container = new BidContainer(this.$bid_container);
    this.$bidder_list = this.$root.find('#bidder-list');
    this.bidder_list = new BidderList(this.$bidder_list);
    this.$post_section = this.$root.find('#post-section');
    this.post_section = new PostSection(this.$post_section);
    this.$post_image_view_editor = this.$root.find('#image-view-editor');
    this.post_image_view_editor = new ImageViewEditor(this.$post_image_view_editor);
    this.$post_image = this.$root.find('.post-image');
    this.$change_image_button = this.$root.find('.post-change-image');
    this.$change_image_modal = this.$root.find('#change-image-modal');
    this.$change_image = this.$root.find('#change-image');
    this.change_image = new ChangeImage(this.$change_image);
};

Post.prototype.initEvents = function() {
    var self = this;
    this.$bid_button.on('click', function(e) {
        self.$proposal_box_modal.modal("show");
        self.$proposal_box_modal.load($(this).attr("value"));
    });

    this.$proposal_box.on(HomeProposalBox.prototype.EVENT.HOME_PROPOSAL_BOX_PROPOSAL_SENT, function(e, data) {
        window.location.href = data;
    });
    
    this.$post_image.hover( function(){
        this.$change_image_button.removeClass('hide');
    }.bind(this));
    
    this.$post_image.mouseout(function() {
        if(!this.$change_image_button.is(':hover') && !this.$post_image.is(':hover')) {
            
            this.$change_image_button.addClass('hide');   
        }
    }.bind(this));
    
    this.$change_image_button.on('click', function(e) {
        this.$change_image_modal.modal("show").load($(this).attr("value"));
    }.bind(this));
    
    
    this.$change_image.on(ChangeImage.prototype.EVENT.CHANGE_IMAGE_CANCEL, function(e, data) {
        this.$change_image_modal.modal("hide");
    }.bind(this));
    
    this.$change_image.on(ChangeImage.prototype.EVENT.CHANGE_IMAGE_IMAGE_CHANGED, function(e,data){ 
        this.changeImage(data['image_id']);
        this.post_image_view_editor.setImage(data['image_path']);
        this.$change_image_modal.modal("hide");
        
    }.bind(this));
};

Post.prototype.changeImage = function(image_id) {
    $.ajax({
        url : $("#base-url").val() + "/post/edit-post-image",
        type: "POST",
        data: {stuff_id: this.stuff_id, image_id: image_id},
        success: function(data) {
            if(data['status'] === 1) {

            } else {

            }
        }
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