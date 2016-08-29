//dynamically added element
var PostCard = function($root) {
    this.$root = $root;
    this.stuff_id = this.$root.data('stuff_id');
    this.id = this.$root.data('id');
    this.is_owner = this.$root.data('is_owner');
    
    this.propose_button_class = null;
    this.favorite_button_class = null;
    this.total_favorite_class = null;
    this.proposal_box_modal_class = null;
    this.proposal_box_class = null;
    
    this.$image_view_editor = null;
    this.image_view_editor = null;
    this.proposal_box = null;
    this.$proposal_box = null;
    
    this.init();
    this.initEvents();
};

PostCard.prototype.init = function () {
    this.propose_button_class = "post-card-button-propose";
    this.proposal_box_modal_class = "post-card-proposal-box-modal";
    this.favorite_button_class = "post-card-button-favorite";
    this.total_favorite_class = 'post-card-total-favorite';
    this.proposal_box_class = 'home-proposal-box-container';
    this.image_view_editor_id = this.id + "-image-view"; 
    
    this.$image_view_editor = this.$root.find("#" + this.image_view_editor_id);
    this.image_view_editor = new ImageViewEditor(this.$image_view_editor);
    this.$proposal_box = this.$root.find("." + this.proposal_box_class);
    this.proposal_box = new HomeProposalBox(this.$proposal_box);
};

PostCard.prototype.initEvents = function() {
    var self =this;
    $(document).on("click", "#" + this.id,function(e) {
        if(e.target && $(e.target).hasClass(this.propose_button_class) ){
            if(this.is_owner ) {
                return false;
            }   
            if(CommonLibrary.isGuest()) {
                return false;
            }
            $("#" + this.id).find("." + this.proposal_box_modal_class).modal("show")
                    .load($(this).attr("value"));
            
        } else if(e.target && $(e.target).hasClass(this.favorite_button_class)) {
            this.clickFavoriteButton_();
        } 
    }.bind(this));
    
    
    $(document).on(HomeProposalBox.prototype.EVENT.HOME_PROPOSAL_BOX_PROPOSAL_SENT,
        "#" + this.id,  function(e,data) {
                            if(e.target && $(e.target).hasClass(this.proposal_box_class)) {
                                window.location.href = data;
                            }
                        }.bind(this));
};

PostCard.prototype.clickFavoriteButton_ = function() {
    if(CommonLibrary.isGuest()) {
        return false;
    }
    if(!this.hasFavorited()) {
        this.markFavorite();
        this.increaseFavorite();
        $.ajax({
          url : $("#base-url").val() + '/post/request-favorite',
          type: 'post',
          data: {stuff_id: this.stuff_id},
          success: function(data) {
              var parsedData = JSON.parse(data);
              if(parsedData['status'] === 0 ) {
                    this.decreaseFavorite();
              }
          }

        });   
    } else {
        this.unmarkFavorite();
        this.decreaseFavorite();
        $.ajax({
            url : $("#base-url").val() + '/post/cancel-favorite',
            type: 'post',
            context: this,
            data: {stuff_id: this.stuff_id},
            success: function(data) {
              var parsedData = JSON.parse(data);
              if(parsedData['status'] === 0 ) {
                  this.increaseFavorite();
              }
            }
        });
    }
};

    
PostCard.prototype.increaseFavorite = function() {
    var favorite = this.getTotalFavorite();
    var newFavorite = favorite + 1;
    this.setTotalFavorite(newFavorite);
};

PostCard.prototype.decreaseFavorite = function() {
    var favorite = this.getTotalFavorite();
    var newFavorite = favorite - 1;
    this.setTotalFavorite(newFavorite);
};

PostCard.prototype.markFavorite = function() {
    $("#" + this.id).find("." + this.favorite_button_class).addClass('post-card-button-red');  
};


PostCard.prototype.unmarkFavorite = function() {
    $("#" + this.id).find("." + this.favorite_button_class).removeClass('post-card-button-red');
};

PostCard.prototype.setTotalFavorite = function(new_favorite) {
    $("#" + this.id).find("." + this.total_favorite_class).html(new_favorite);
};

PostCard.prototype.getTotalFavorite = function() {
    return parseInt($("#" + this.id).find("." + this.total_favorite_class).html());
};

PostCard.prototype.hasFavorited = function() {
    return $("#" + this.id).find("." + this.favorite_button_class).hasClass('post-card-button-red');
};