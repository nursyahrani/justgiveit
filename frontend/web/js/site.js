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
    this.$site_left_side_remove = null;
    this.$site_left_side = null;
    this.$site_left_side_wrapper = null;
    this.$open_left_side_button = null;
    this.$banner = null;
    this.init();
    this.initEvents();
};


Site.prototype.SCROLL_VALUE = 90;

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
    this.$banner = this.$root.find('#banner');
    this.$email_registration = this.$root.find('#email-registration');
    this.email_registration = new EmailRegistration(this.$email_registration);

    this.$site_left_side_wrapper = this.$root.find('.site-left-side-wrapper');
    this.$site_left_side = this.$root.find('.site-left-side');
    this.$site_left_side_remove = this.$root.find('.site-left-side-remove');
    this.$open_left_side_button = this.$root.find('.site-post-area-open-left-side');
    
    
};

Site.prototype.backToTop = function() {
    if(this.$banner !== undefined) {
        var banner_height =this.$banner.height();
    } else {
        var banner_height = 0;
    }
    $('.main-view').animate({
        'scrollTop' : banner_height
    });

}

Site.prototype.initEvents = function() {
    this.$tag_navigation.on(TagNavigation.prototype.EVENTS.TAG_NAVIGATION_CHANGE, function(e,data){
       this.backToTop();
       this.post_list.setNewTags(data);
    }.bind(this));
    
    this.$search_bar.on(SearchBar.prototype.EVENT.SEARCH_BAR_SEARCH, function(e,data){
        this.backToTop();
        this.post_list.setQueryAndLocation(data.query, data.location);
    }.bind(this));
    
    $(".main-view").scroll(function(e) {
        var scrollPercentage = 
                100 * $(".main-view").scrollTop() / ((this.post_list.getHeight() - 40) - $(".main-view").height());
        if(scrollPercentage > Site.prototype.SCROLL_VALUE) {
            this.post_list.getMorePosts();
        }
    }.bind(this));
    
    //bad practice, 250 should be stored somewhere
    this.$site_left_side_remove.click(function(e) {
        this.$open_left_side_button.removeClass('site-hide')
        this.$open_left_side_button.addClass('inline');
        this.$site_left_side_wrapper.addClass('site-hide');
        this.$site_post_area.removeClass('site-post-area-padding');
    }.bind(this));
    
    this.$open_left_side_button.click(function(e) {
        
        if( !this.$site_left_side_wrapper.is(':visible')) {
            this.$site_left_side_wrapper.removeClass('hide-right-side');
            this.$site_left_side_wrapper.removeClass('site-hide');   
                  
            this.$site_post_area.addClass('site-post-area-padding');   
        } else {
            this.$site_left_side_wrapper.addClass('hide-right-side');
            this.$site_left_side_wrapper.addClass('site-hide');        
            this.$site_post_area.removeClass('site-post-area-padding');   
        }
    }.bind(this));
    
    
    $(document).on('click',   function(e) {
        if(e.target && ($(e.target).closest("#tag-navigation").length === 0)) {
            if(window.innerWidth < 890 && $(e.target).closest(".site-post-area-open-left-side" ).length === 0) {
                this.$site_left_side_wrapper.addClass('site-hide');

                this.$site_post_area.removeClass('site-post-area-padding');
            } 
        }
    }.bind(this));
};
    


