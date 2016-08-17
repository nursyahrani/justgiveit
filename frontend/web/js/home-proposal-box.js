/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var HomeProposalBox = function($root) {
    this.$root = $root;
    this.$text_area = null;
    this.$send_button = null;
    this.$loading_area = null;
    this.proposal_sent_event_ = null;
    this.stuff_id = $root.data('stuff-id');
    this.post_link = $root.data('post-link');

    this.init();
    this.initEvents();
    this.initWidgetEvents();
};

HomeProposalBox.prototype.EVENT = {
    HOME_PROPOSAL_BOX_PROPOSAL_SENT : 'home-proposal-box-proposal-sent'
};

HomeProposalBox.prototype.init = function() {
    this.$text_area = this.$root.find('.home-proposal-box-text-area');
    this.$send_button = this.$root.find('.home-proposal-box-send-button');
    this.$loading_area = this.$root.find('.home-proposal-box-loading-area');
  
};

HomeProposalBox.prototype.initWidgetEvents = function() {
    this.proposal_sent_event_ = new CustomEvent(HomeProposalBox.prototype.EVENT.HOME_PROPOSAL_BOX_PROPOSAL_SENT);
}

HomeProposalBox.prototype.initEvents = function() {
    this.$text_area.on('input', {self:this} ,this.inputTextArea_);
    this.$send_button.on('click', {self:this}, this.sendButton_);
    
   
};

HomeProposalBox.prototype.sendButton_ = function(e) {
    var self = e.data.self;
    var element = self.$root;
    var message = self.$text_area.val();
    if(message === null || message === '') {
        return false;
    }

    self.$loading_area.removeClass('home-proposal-box-hide');
    $.ajax({
        'url' : $("#base-url").val() + '/post/send-bid',
        'data' : {stuff_id: self.stuff_id, message: message},
        'type' : 'post',
        'success' : function(data) {
            var parsed  = JSON.parse(data);
            if(parsed.status === 1) {
                self.triggerProposalSentEvent_();
            } else {

            }
            self.$loading_area.addClass('home-proposal-box-hide');
            
        }
    });
};

HomeProposalBox.prototype.inputTextArea_  = function(e) {
    var self = e.data.self;
    var message = $(this).val().trim();

    if(message === null || message === '') {
        self.$send_button.attr('disabled', true);
    } else {
        self.$send_button.attr('disabled', false);
    }

};

HomeProposalBox.prototype.triggerProposalSentEvent_ = function() {
    this.$root.trigger(this.EVENT.HOME_PROPOSAL_BOX_PROPOSAL_SENT, [this.post_link]);
};

    