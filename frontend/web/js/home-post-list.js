var HomePostList = function($root) {
    this.$root = $root;
    this.stuff_id = this.$root.data('stuff_id');
    this.is_owner = this.$root.data('is_owner');
    this.$propose_button = null;
    this.$favorite_button = null;
    this.$total_favorite = null;
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
    this.$favorite_button = this.$root.find(".home-post-list-button-favorite");
    this.$total_favorite = this.$root.find('.home-post-list-total-favorite');
    this.proposal_box = new HomeProposalBox(this.$proposal_box);
};

HomePostList.prototype.initEvents = function() {
    var self = this;
    this.$propose_button.click(function(e){
        if(self.is_owner ) {
            return false;
        }
        if(CommonLibrary.isGuest()) {
            return false;
        }
        self.$proposal_box_modal.modal("show");
        self.$proposal_box_modal.load($(this).attr("value"));
    });    
    
    this.$favorite_button.click({self:this}, this.clickFavoriteButton_);
    
    this.$proposal_box.on(HomeProposalBox.prototype.EVENT.HOME_PROPOSAL_BOX_PROPOSAL_SENT, function(e, data) {
        window.location.href = data;
    });
};

HomePostList.prototype.clickFavoriteButton_ = function(e) {
    var self = e.data.self;
    if(CommonLibrary.isGuest()) {
        return false;
    }
    if(!self.hasFavorited()) {
        self.markFavorite();
        self.increaseFavorite();
        $.ajax({
          url : $("#base-url").val() + '/post/request-favorite',
          type: 'post',
          data: {stuff_id: self.stuff_id},
          success: function(data) {
              var parsedData = JSON.parse(data);
              if(parsedData['status'] === 0 ) {
                    self.decreaseFavorite();
              }
          }

        });   
    } else {
        self.unmarkFavorite();
        self.decreaseFavorite();
        $.ajax({
            url : $("#base-url").val() + '/post/cancel-favorite',
            type: 'post',
            data: {stuff_id: self.stuff_id},
            success: function(data) {
              var parsedData = JSON.parse(data);
              if(parsedData['status'] === 0 ) {
                  self.increaseFavorite();
              }
            }
        });
    }
};

HomePostList.prototype.CSS_CLASSES = {
    PROPOSE_BUTTON : 'home-post-list-button-propose',
    PROPOSAL_MODAL: 'home-post-list-proposal-box-modal', 
    PROPOSAL_BOX: 'home-proposal-box-container'
};
    
HomePostList.prototype.increaseFavorite = function() {
    var favorite = parseInt(this.$total_favorite.html());
    var newFavorite = favorite + 1;
    this.$total_favorite.html(newFavorite);
};

HomePostList.prototype.decreaseFavorite = function() {
    var favorite = parseInt(this.$total_favorite.html());
    var newFavorite = favorite - 1;
    this.$total_favorite.html(newFavorite);
};

HomePostList.prototype.markFavorite = function() {
  
    this.$favorite_button.addClass('home-post-list-button-red');  
};


HomePostList.prototype.unmarkFavorite = function() {
    this.$favorite_button.removeClass('home-post-list-button-red');
};

HomePostList.prototype.hasFavorited = function() {
    return this.$favorite_button.hasClass('home-post-list-button-red');
}