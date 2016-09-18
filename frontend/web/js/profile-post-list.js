//pre-loaded
var ProfilePostList = function($root) {
    this.$root = $root;
    
    
    this.$list_area = null;
    
    this.posts = [];
    this.init();
    this.initEvents();
};

ProfilePostList.prototype.init = function() {
    this.$list_area = this.$root.find('.profile-post-list-area');
    this.$root.find(".post-card").each(function(index, value) {
        this.posts.push(new PostCard($(value))); 
        
    }.bind(this));
};

ProfilePostList.prototype.initEvents = function() {
    
};

ProfilePostList.prototype.getMorePosts = function() {
    
};


    