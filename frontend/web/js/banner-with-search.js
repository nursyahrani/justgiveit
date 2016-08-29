/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var BannerWithSearch = function($root) {
    this.$root = $root;
    this.id = this.$root.data('id');
    this.$search_bar = null;
    this.search_bar = null;
    this.search_event_ = null;
    this.init();
    this.initWidgetEvents();
    this.initEvents();
};

BannerWithSearch.prototype.EVENT = {
    BANNER_WITH_SEARCH_SEARCH : 'banner-with-search-search'
};

BannerWithSearch.prototype.init = function() {
    this.$search_bar = this.$root.find('#' + this.id + "-search-bar");
    this.search_bar = new SearchBar(this.$search_bar);
};

BannerWithSearch.prototype.initEvents = function() {
    this.$search_bar.on(SearchBar.prototype.EVENT.SEARCH_BAR_SEARCH, function(e,data){
        this.triggerSearch(data);
    }.bind(this));
};

BannerWithSearch.prototype.initWidgetEvents = function() {
    this.search_event_ = new CustomEvent(this.EVENT.BANNER_WITH_SEARCH_SEARCH);
};

BannerWithSearch.prototype.triggerSearch = function(obj) {
    this.$root.trigger(this.EVENT.BANNER_WITH_SEARCH_SEARCH, [obj]);
};