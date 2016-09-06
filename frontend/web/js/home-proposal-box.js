var HomeProposalBox = function($root) {
    this.$root = $root;
    this.id = $root.data('id');
    this.proposal_sent_event_ = null;
    this.stuff_id = $root.data('stuff-id');
    this.post_link = $root.data('post-link');
    this.text_area_class = null;
    this.send_button_class = null;
    this.loading_area_class = null;
    this.init();
    this.initEvents();
    this.initWidgetEvents();
};

HomeProposalBox.prototype.EVENT = {
    HOME_PROPOSAL_BOX_PROPOSAL_SENT : 'home-proposal-box-proposal-sent'
};

HomeProposalBox.prototype.init = function() {
  
    this.text_area_class = 'home-proposal-box-text-area';
    this.send_button_class = 'home-proposal-box-send-button';
    this.loading_area_class = 'home-proposal-box-loading-area';
};

HomeProposalBox.prototype.initWidgetEvents = function() {
    this.proposal_sent_event_ = new CustomEvent(HomeProposalBox.prototype.EVENT.HOME_PROPOSAL_BOX_PROPOSAL_SENT);
};

HomeProposalBox.prototype.initEvents = function() {
    $(document).on('input', '#' + this.id, function(e) {
        if(e.target && $(e.target).hasClass(this.text_area_class)) {
            this.inputTextArea_();
        }
        
    }.bind(this));

    $(document).on('click', '#' + this.id, function(e) {
        if(e.target && $(e.target).hasClass(this.send_button_class)) {
            this.sendButton_();
        }
    }.bind(this));
};

HomeProposalBox.prototype.sendButton_ = function() {
    var message = this.getTextAreaVal();
    if(message === null || message === '') {
        return false;
    }
    this.showLoading();
    $.ajax({
        'url' : $("#base-url").val() + '/post/send-bid',
        'data' : {stuff_id: this.stuff_id, message: message},
        'type' : 'post',
        context: this,
        'success' : function(data) {
            var parsed  = JSON.parse(data);
            if(parsed.status === 1) {
                this.triggerProposalSentEvent_();
            } else {

            }
            this.hideLoading();
            
        }
    });
};

HomeProposalBox.prototype.inputTextArea_  = function() {
    var message = this.getTextAreaVal().trim();

    if(message === null || message === '') {
        this.disableButton();
    } else {
        this.enableButton();
    }

};

HomeProposalBox.prototype.triggerProposalSentEvent_ = function() {
    $("#" + this.id).trigger(this.EVENT.HOME_PROPOSAL_BOX_PROPOSAL_SENT, [this.post_link]);
};

HomeProposalBox.prototype.getTextAreaVal = function() {
    return $("#"  + this.id).find('.' + this.text_area_class).val();
};


HomeProposalBox.prototype.showLoading = function() {
    $("#" + this.id).find("." + this.loading_area_class).removeClass('hide');
}


HomeProposalBox.prototype.hideLoading = function() {
    $("#" + this.id).find("." + this.loading_area_class).addClass('hide');
}


HomeProposalBox.prototype.enableButton = function() {
    $("#" + this.id).find("." + this.send_button_class).attr('disabled', false);
}


HomeProposalBox.prototype.disableButton = function() {
    $("#" + this.id).find("." + this.send_button_class).attr('disabled', true);
}