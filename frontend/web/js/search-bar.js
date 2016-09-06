var SearchBar = function($root) {
    this.$root = $root;
    this.id = this.$root.data('id');
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
    this.$location = this.$root.find('#' + this.id + "-city");
    this.$search_field = this.$root.find('.search-bar-input');
};


SearchBar.prototype.initEvents = function() {
    this.$search_field.on('input', function(e) {
        this.triggerSearchEvent({location: this.getLocationValue(), query: this.getQuery()});
    }.bind(this));
    
    this.$location.change(function(e) {
        this.triggerSearchEvent({location: this.getLocationValue(), query: this.getQuery()});
    }.bind(this));
};

SearchBar.prototype.initWidgetEvents = function() {
    this.search_event_ = new CustomEvent(SearchBar.prototype.EVENT.SEARCH_BAR_SEARCH);
};

SearchBar.prototype.getLocationValue = function() {
    return this.$location.val();
};

SearchBar.prototype.getLocationText = function() {
    var data = this.$location.select2('data');
    return data[0].text;
};


SearchBar.prototype.getQuery =  function() {
    return this.$search_field.val();
};

SearchBar.prototype.triggerSearchEvent = function(obj) {
    this.$root.trigger(this.EVENT.SEARCH_BAR_SEARCH, [obj]);
};

SearchBar.prototype.isLocationNull = function() {
    return this.$location.val() === "";
}

