var HomePostList = function($root) {
    this.$root = $root;
    this.$propose_button = null;
    this.$proposal_box_modal = null;
    this.proposal_box = null;
    this.$proposal_box = null;
    this.init();
    this.initEvents();
};

HomePostList.prototype.init = function () {
    this.$propose_button = this.$root.find("." + HomePostList.prototype.CSS_CLASSES.PROPOSE_BUTTON);
    this.$proposal_box_modal = this.$root.find("." + HomePostList.prototype.CSS_CLASSES.PROPOSAL_MODAL);
    this.$proposal_box = this.$root.find("." + HomePostList.prototype.CSS_CLASSES.PROPOSAL_BOX);

    this.proposal_box = new HomeProposalBox(this.$proposal_box);
};

HomePostList.prototype.initEvents = function() {
    var self = this;
    this.$propose_button.click(function(e){
        self.$proposal_box_modal.modal("show");
        self.$proposal_box_modal.load($(this).attr("value"));
    });    
    
    this.$proposal_box.on(HomeProposalBox.prototype.EVENT.HOME_PROPOSAL_BOX_PROPOSAL_SENT, function(e, data) {
        window.location.href = data;
    });
};

HomePostList.prototype.CSS_CLASSES = {
    PROPOSE_BUTTON : 'home-post-list-button-propose',
    PROPOSAL_MODAL: 'home-post-list-proposal-box-modal', 
    PROPOSAL_BOX: 'home-proposal-box-container'
};
    
    
    
   