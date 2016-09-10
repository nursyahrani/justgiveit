//Dynamic loading
var TagNavigationItem = function($root){
    this.$root = $root;
    this.label = $root.data('label');
    this.id = $root.data('id');
    this.tick = $root.data('tick');
    this.not_favorite_class = null;
    this.favorite_class = null;
    this.tick_class = null;
    
    this.tick_event_ = null;
    this.untick_event_ = null;
    this.favorite_event_ = null;
    this.unfavorite_event_ = null;
    this.init();
    this.initEvent();
    this.initWidgetEvents();
};


TagNavigationItem.prototype.EVENTS = {
    TAG_NAVIGATION_ITEM_TICK : 'tag-navigation-item-tick',
    TAG_NAVIGATION_ITEM_UNTICK: 'tag-navigation-item-untick',
    TAG_NAVIGATION_ITEM_FAVORITE: 'tag-navigation-item-favorite',
    TAG_NAVIGATION_ITEM_UNFAVORITE: 'tag-navigation-item-unfavorite'
};

TagNavigationItem.prototype.init = function() {
   this.not_favorite_class = 'tag-navigation-item-unfavorite';
   this.favorite_class = 'tag-navigation-item-favorite';
   this.tick_class = 'tag-navigation-item-tick';
};

TagNavigationItem.prototype.initEvent = function() {
    $(document).on('click', '#' + this.id , function(e) {
        if(e.target && ($(e.target).closest("." + this.not_favorite_class).length === 0) && ($(e.target).closest("." + this.favorite_class).length === 0)) {
            this.toggleTick();
        } 
        if(e.target && $(e.target).closest("." + this.not_favorite_class).length !== 0) {
            if(CommonLibrary.isGuest()) {
                return false;
            }
            this.triggerFavoriteEvent(this.label);
        } 
        
        if(e.target && $(e.target).closest("." + this.favorite_class).length !== 0) {
            if(CommonLibrary.isGuest()) {
                return false;
            }
            this.triggerUnfavoriteEvent(this.label);
        } 
        e.stopPropagation();
    }.bind(this));
};

TagNavigationItem.prototype.initWidgetEvents = function() {
    this.tick_event_ = new CustomEvent(this.EVENTS.TAG_NAVIGATION_ITEM_TICK);
    this.untick_event_ = new CustomEvent(this.EVENTS.TAG_NAVIGATION_ITEM_UNTICK);
    this.favorite_event_ = new CustomEvent(this.EVENTS.TAG_NAVIGATION_ITEM_FAVORITE);
    this.unfavorite_event_ = new CustomEvent(this.EVENTS.TAG_NAVIGATION_ITEM_UNFAVORITE);
};

TagNavigationItem.prototype.toggleTick = function() {
    var $element = $("#" + this.id).find('.' + this.tick_class); 
    if($element.hasClass('hide') ) {
        this.triggerTickEvent(this.label);
    }else {
        this.triggerUntickEvent(this.label);
    }
};

TagNavigationItem.prototype.setUnfavorite = function() {
    var $element = $("#" + this.id);
    $element.find("." + this.favorite_class).addClass('hide');
    $element.find("." + this.not_favorite_class).removeClass('hide');
};


TagNavigationItem.prototype.setFavorite = function() {
    var $element = $("#" + this.id);
    $element.find("." + this.favorite_class).removeClass('hide');
    $element.find("." + this.not_favorite_class).addClass('hide');
}

TagNavigationItem.prototype.triggerTickEvent = function(label) {
    $("#" + this.id).trigger(this.EVENTS.TAG_NAVIGATION_ITEM_TICK, [label]);
};


TagNavigationItem.prototype.triggerUntickEvent = function(label) {
     $("#" + this.id).trigger(this.EVENTS.TAG_NAVIGATION_ITEM_UNTICK, [label]);
};


TagNavigationItem.prototype.triggerFavoriteEvent = function(label) {
    $("#" + this.id).trigger(this.EVENTS.TAG_NAVIGATION_ITEM_FAVORITE, [label]);
};


TagNavigationItem.prototype.triggerUnfavoriteEvent = function(label) {
     $("#" + this.id).trigger(this.EVENTS.TAG_NAVIGATION_ITEM_UNFAVORITE, [label]);
};

TagNavigationItem.prototype.getLabel = function() {
    return $("#" + this.id).data('label');
};

TagNavigationItem.prototype.setTick = function(tick) {
    var $element = $("#" + this.id).find('.' + this.tick_class); 
    if(tick) {
        $element.removeClass('hide');
        $("#" + this.id).data('tick', true);
    } else {
        $("#" + this.id).data('tick', false)
        $element.addClass('hide');
    }
};

TagNavigationItem.prototype.deleteElement = function() {
    this.disposeItem();
}

TagNavigationItem.prototype.disposeItem = function() {
   $(document).off('click', '#' + this.id);
};