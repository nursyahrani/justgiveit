$(function(){
   
    $(document).ready(function() {

        var app = new App($(this));
    });
    //associated index
    var App = function($root) {
        this.$root = $root;
        this.$site = null;
        this.$post = null;
        this.init();
        this.initEvents();
    };
    
    App.prototype.CSS_CLASSES = {
        
    };

    App.prototype.init = function() {
        if(this.$root.find('.site-index').length !== 0) {
            this.$site = new Site(this.$root.find('.site-index'));   
        } 
        else if (this.$root.find('.post-index').length !== 0) {
            this.$post = new Post(this.$root.find('.post-index'));
        }
    };
    
    App.prototype.initEvents = function() {
        
    };
 
});


var Site = function($root) {
    this.$root = $root;
    this.$post_list = [];
    this.init();

};

Site.prototype.CSS_CLASSES = {
    HOME_POST_LIST: 'home-post-list-container'
};

Site.prototype.init = function() {
    this.initPostList();
};

Site.prototype.initPostList = function() {
    
    var self = this;
    $.each($("." + Site.prototype.CSS_CLASSES.HOME_POST_LIST), function(index, value) {
        self.$post_list.push(new HomePostList($(value))); 
    });
};
    