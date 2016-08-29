/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var SearchBar = function($root) {
    this.$root = $root;
    this.id = this.$root.data('id');
    this.$search_button = null;
    this.$location = null;
    this.$search_field = null;
    
    this.search_event_ = null;
    this.init();
    this.initEvents();
    this.initWidgetEvents();
};

SearchBar.prototype.EVENT = {
    SEARCH_BAR_SEARCH : 'search-bar-search'
};

SearchBar.prototype.init = function() {
    this.$search_button = this.$root.find('.search-bar-button');
    this.$location = this.$root.find('#' + this.id + "-city");
    this.$search_field = this.$root.find('.search-bar-input');
};


SearchBar.prototype.initEvents = function() {
    this.$search_button.click(function(e) {
        this.triggerSearchEvent({location: this.getLocation(), query: this.getQuery()});
    }.bind(this));
};

SearchBar.prototype.initWidgetEvents = function() {
    this.search_event_ = new CustomEvent(SearchBar.prototype.EVENT.SEARCH_BAR_SEARCH);
};

SearchBar.prototype.getLocation = function() {
    return this.$location.val();
};

SearchBar.prototype.getQuery =  function() {
    return this.$search_field.val();
}

SearchBar.prototype.triggerSearchEvent = function(obj) {
    this.$root.trigger(this.EVENT.SEARCH_BAR_SEARCH, [obj]);
};



