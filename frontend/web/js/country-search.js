var CountrySearch = function($root) {
    this.$root = $root; 
    this.id = $root.data('id');
    this.$field = null;
    this.$button = null;
    this.$view = null;
    this.$items_area = null;
    this.items = [];
    this.ticked = [];
    
    this.change_event_ = null;
    
    this.init();
    this.initEvents();
    this.initWidgetEvents();
    this.retrieved = false;
    
};

CountrySearch.EVENTS = {
    COUNTRY_SEARCH_CHANGE: 'country-search-change'
};

CountrySearch.prototype.init = function() {
    this.$field = this.$root.find('.country-search-field');
    this.$button = this.$root.find('.country-search-header');
    this.$view = this.$root.find('.country-search-view');
    this.$items_area = this.$root.find('.country-search-items-area');
};

CountrySearch.prototype.initWidgetEvents = function() {
    this.change_event_ = new CustomEvent(CountrySearch.EVENTS.COUNTRY_SEARCH_CHANGE);
};

CountrySearch.prototype.initEvents = function() {
    this.$button.click(function(e) {
        if(this.$view.hasClass('hide')) {
            this.$view.removeClass('hide');
            if(!this.retrieved) {
                this.loadCountry();
            }
        } else {
            this.$view.addClass('hide');
        }
        
    }.bind(this));

    $(document).on(CountrySearchItem.EVENTS.COUNTRY_SEARCH_ITEM_TICK, "#" + this.id, function(e,data) {
        this.ticked.push(data);
        this.triggerChangeEvent();
    }.bind(this));
    
    $(document).on(CountrySearchItem.EVENTS.COUNTRY_SEARCH_ITEM_UNTICK, "#" + this.id,  function(e , data) {
        this.ticked.remove(data);
        this.triggerChangeEvent();
    }.bind(this));
    
    $(document).on('click', function(e) {
        if(e.target && ($(e.target).closest("#" + this.id).length === 0)) {
            this.$view.addClass('hide');
        }
    }.bind(this));
};

CountrySearch.prototype.loadCountry = function() {
    this.retrieved = true;
    $.ajax({
       url: $("#base-url").val() + "/site/get-country-view-for-search",
       type: "post",
       context: this,
       data: {query: this.getQuery() },
       success: function(data) {
           var parsed = JSON.parse(data);
           if(parsed['status'] === 1) {
               this.implementView(parsed['view'])
           }
       }
    });
};

CountrySearch.prototype.getQuery = function() {
    return this.$field.val();
};

CountrySearch.prototype.implementView = function(view) {
    this.removeAllItems();
    this.$items_area.html(view);
    this.addAllItems();
};

CountrySearch.prototype.addAllItems = function() {
    $(this.$items_area.html()).filter('.country-search-item').each(function(index, value) {
        this.items.push(new CountrySearchItem($(value)));
    }.bind(this));
};

CountrySearch.prototype.removeAllItems = function() {
    for(var i = 0; i < this.items.length; i++ ) {
        this.items[i].disposeElement();
    }
};

CountrySearch.prototype.triggerChangeEvent = function() {
    this.$root.trigger(CountrySearch.EVENTS.COUNTRY_SEARCH_CHANGE, [this.ticked]);
}