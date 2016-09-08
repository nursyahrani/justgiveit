var Site = function($root) {
    this.$root = $root;
    this.$post_list = null;
    this.post_list = null;
    this.$search_bar = null;
    this.search_bar = null;
    this.tag_navigation = null;
    this.$tag_navigation = null;
    this.$site_post_area = null;
    
    this.$email_registration = null;
    this.email_registration = null;
    
    this.init();
    this.initEvents();
};


Site.prototype.SCROLL_VALUE = -55;

Site.prototype.CSS_CLASSES = {
    HOME_POST_LIST: 'home-post-list-container'
};
Site.prototype.init = function() {
    this.$post_list = this.$root.find('.post-list');
    this.post_list = new PostList(this.$post_list);
    this.$search_bar = this.$root.find('#site-search-bar');
    this.search_bar = new SearchBar(this.$search_bar);
    this.$tag_navigation = this.$root.find('#tag-navigation');
    this.tag_navigation = new TagNavigation(this.$tag_navigation);
    this.$site_post_area = this.$root.find('.site-post-area');
    
    this.$email_registration = this.$root.find('#email-registration');
    this.email_registration = new EmailRegistration(this.$email_registration);
};

Site.prototype.initEvents = function() {
    this.$tag_navigation.on(TagNavigation.prototype.EVENT.TAG_NAVIGATION_CHANGE, function(e,data){
       this.post_list.setNewTags(data);
    }.bind(this));
    
    this.$search_bar.on(SearchBar.prototype.EVENT.SEARCH_BAR_SEARCH, function(e,data){
       this.post_list.setQueryAndLocation(data.query, data.location);
    }.bind(this));
    
    $(document).scroll(function(e) {
        var scrollPercentage = 
                100 * $(document).scrollTop() / ((this.post_list.getHeight() - 40) - $(document).height());
        if(scrollPercentage < Site.prototype.SCROLL_VALUE) {
            this.post_list.getMorePosts();
        }
    }.bind(this));
}
    


