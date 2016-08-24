
var Site = function($root) {
    this.$root = $root;
    this.$post_list = [];
    this.$banner_button = null;
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
    this.initPostList();
    this.$banner_button = this.$root.find('.site-banner-button');
    
};

Site.prototype.initEvents = function() {
    var self =this;
    this.$banner_button.click(function(e){
        if(CommonLibrary.isGuest()) {
            return false;
        }
        self.triggerBannerButtonClick();
    });
};

Site.prototype.initWidgetEvents =function() {
    this.trigger_button_click_event_ = 
            new CustomEvent(Site.prototype.EVENT.BANNER_BUTTON_CLICK);
  
};


Site.prototype.triggerBannerButtonClick = function() {
    this.$root.trigger(Site.prototype.EVENT.BANNER_BUTTON_CLICK);
};


Site.prototype.initPostList = function() {
    var self = this;
    $.each($("." + Site.prototype.CSS_CLASSES.HOME_POST_LIST), function(index, value) {
        self.$post_list.push(new HomePostList($(value))); 
    });
};
