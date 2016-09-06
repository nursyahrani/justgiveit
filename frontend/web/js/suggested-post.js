var SuggestedPost = function($root) {
    this.$root = $root;
    this.post_cards = [];
    this.init();
};

SuggestedPost.prototype.init = function() {
    $.each($(".post-card"), function(index, value) {
        this.post_cards.push(new PostCard($(value))); 
    }.bind(this));
};
