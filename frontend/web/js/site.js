
var Site = function($root) {
    this.$root = $root;
    this.$post_list = null;
    this.post_list = null;
    this.$banner_button = null;
    this.banner_search = null;
    this.$banner_search = null;
    this.trigger_button_click_event_ = null;
    this.init();
    this.initEvents();
    this.initWidgetEvents();

};

Site.prototype.CSS_CLASSES = {
    HOME_POST_LIST: 'home-post-list-container'
};

Site.prototype.EVENT = {
    BANNER_BUTTON_CLICK : 'site-banner-button-click'
};
Site.prototype.init = function() {
    this.$post_list = this.$root.find('.post-list');
    this.post_list = new PostList(this.$post_list);
    this.$banner_button = this.$root.find('.site-banner-button');
    this.$banner_search = this.$root.find('#banner-with-search');
    this.banner_search = new BannerWithSearch(this.$banner_search);
};

Site.prototype.initEvents = function() {
    var self =this;
    this.$banner_button.click(function(e){
        if(CommonLibrary.isGuest()) {
            return false;
        }
        self.triggerBannerButtonClick();
    });
    
    this.$banner_search.on(BannerWithSearch.prototype.EVENT.BANNER_WITH_SEARCH_SEARCH, 
        function(e,data) {
            this.post_list.searchNewData(data['query'], data['location']);
        }.bind(this)
    );
};

Site.prototype.initWidgetEvents =function() {
    this.trigger_button_click_event_ = 
            new CustomEvent(Site.prototype.EVENT.BANNER_BUTTON_CLICK);
  
};


Site.prototype.triggerBannerButtonClick = function() {
    this.$root.trigger(Site.prototype.EVENT.BANNER_BUTTON_CLICK);
};

//
//Site.prototype.initPostList = function() {
//    var self = this;
//    $.each($("." + Site.prototype.CSS_CLASSES.HOME_POST_LIST), function(index, value) {
//        self.$post_list.push(new HomePostList($(value))); 
//    });
//};
