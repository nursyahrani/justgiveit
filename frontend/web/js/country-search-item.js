var CountrySearchItem = function($root) {
    this.$root = $root;
    this.id  = $root.data('id');
    this.country_code = $root.data('country_code');
    this.tick_class = null;
    
    this.tick_event_ = null;
    this.untick_event_ = null;
    
    this.init();
    this.initEvents();
    this.initWidgetEvents();
};

CountrySearchItem.prototype.init = function() {
    this.tick_class = 'country-search-item-tick';
};

CountrySearchItem.EVENTS = {
    COUNTRY_SEARCH_ITEM_TICK : 'country-search-item-tick',
    COUNTRY_SEARCH_ITEM_UNTICK : 'country_search-item-untick'
};

CountrySearchItem.prototype.initEvents = function() {
    $(document).on('click', '#' + this.id , function(e) {
        var $tick = $("#" + this.id).find('.' + this.tick_class);
        if($tick.hasClass('hide')) {
            this.triggerTickEvent();
            $tick.removeClass('hide');
        } else {            
            this.triggerUntickEvent();
            $tick.addClass('hide');
            
        }
    }.bind(this));
};

CountrySearchItem.prototype.initWidgetEvents = function() {
    this.tick_event_ = new CustomEvent(CountrySearchItem.EVENTS.COUNTRY_SEARCH_ITEM_TICK);
    this.untick_event_ = new CustomEvent(CountrySearchItem.EVENTS.COUNTRY_SEARCH_ITEM_UNTICK);
};

CountrySearchItem.prototype.triggerTickEvent = function() {
    $("#" + this.id).trigger(CountrySearchItem.EVENTS.COUNTRY_SEARCH_ITEM_TICK, [this.country_code]);
};

CountrySearchItem.prototype.triggerUntickEvent = function() {
    $("#" + this.id).trigger(CountrySearchItem.EVENTS.COUNTRY_SEARCH_ITEM_UNTICK, [this.country_code]);
};

CountrySearchItem.prototype.disposeElement = function() {
    $(document).off('click', '#' + this.id);
};
