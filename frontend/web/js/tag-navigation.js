//preloaded
var TagNavigation = function($root) {
    this.$root = $root;
    this.id = $root.data('id');
    
    this.$tag_navigation_search = null;
    
    this.$starred = null;
    this.$all = null;
    this.$searched = null;
    
    this.$starred_item_area = null;
    this.$all_item_area = null;
    this.$searched_item_area = null;
    
    this.$starred_items = [];
    this.$all_items = [];
    this.$searched_items = [];
    
    
    this.ticked_tags = [];
    this.init();
    this.initEvents();
    this.initWidgetEvents();
};


TagNavigation.prototype.EVENTS = {
    TAG_NAVIGATION_CHANGE : 'tag-navigation-change',
    TAG_NAVIGATION_STARRED : 'tag-navigation-starred'
};


TagNavigation.prototype.init = function() {
    this.$tag_navigation_search = this.$root.find('.tag-navigation-search');
    this.$starred_item_area = this.$root.find('.tag-navigation-starred-area');
    this.$all_item_area = this.$root.find('.tag-navigation-all-area');
    this.$searched_item_area = this.$root.find('.tag-navigation-searched');
    
    this.$starred = this.$root.find('.tag-navigation-starred');
    this.$all = this.$root.find('.tag-navigation-all');
    this.$searched = this.$root.find('.tag-navigation-searched');
    
    $(this.$starred_item_area.html()).filter('.tag-navigation-item').each(function(index, value) {
        this.$starred_items.push(new TagNavigationItem($(value)));
    }.bind(this));
    
    $(this.$all_item_area.html()).filter('.tag-navigation-item').each(function(index, value) {
        this.$all_items.push(new TagNavigationItem($(value)));
    }.bind(this));
    
};


TagNavigation.prototype.initEvents = function() {
    this.$tag_navigation_search.on('input', function(e) {
        var searched_value = this.searchBarValue();
        if(searched_value === '' || searched_value === null) {
            this.$searched.addClass('hide');
            this.$all.removeClass('hide');
            this.$starred.removeClass('hide');
        } else {
            this.$searched.removeClass('hide');
            this.$all.addClass('hide');
            this.$starred.addClass('hide');
            this.searchTag(searched_value);
        }
    }.bind(this));
    
    $(document).on(TagNavigationItem.prototype.EVENTS.TAG_NAVIGATION_ITEM_TICK, "#" + this.id,  function(e, label) {
        if(e.target && $(e.target).hasClass('tag-navigation-item')) {
            this.ticked_tags.push(label);
            this.label_selector = '.tag-navigation-item[data-label="' + label +'"]';
            //it is in search area but not in all area and starred area
            if(this.$all_item_area.find(this.label_selector).length === 0 && this.$starred_item_area.find(this.label_selector).length === 0) {
                this.addTagFromSearchToAll(label, true);
            }
            this.setTick(this.$searched_items, label);
            console.log(this.ticked_tags);
            this.setTick(this.$all_items, label);
            this.setTick(this.$starred_items, label);
            e.stopPropagation();
        }
    }.bind(this));
    
    $(document).on(TagNavigationItem.prototype.EVENTS.TAG_NAVIGATION_ITEM_UNTICK, "#" + this.id, function(e, label) {
        if(e.target && $(e.target).hasClass('tag-navigation-item')) {
            this.ticked_tags.remove(label);
            console.log(this.ticked_tags);
            this.setUntick(this.$searched_items, label);
            this.setUntick(this.$all_items, label);
            this.setUntick(this.$starred_items, label);
        }
    }.bind(this));
};

TagNavigation.prototype.addTagFromSearchToAll = function(label, tick) {
    $.ajax({
        url : $("#base-url").val() + "/tags/get-tag",
        data: {label: label, tick: tick},
        type: 'post',
        context: this,
        success: function(data) {
            var parsed = JSON.parse(data);
            if(parsed['status'] === 1) {
                this.$all_item_area.prepend(parsed['views']);
                this.$all_items.push(new TagNavigationItem($(parsed['views'])));
            }
        }
    })
};

TagNavigation.prototype.setTick = function($items, label) {
    for(var i = 0; i < $items.length; i++) {
        if($items[i].getLabel() === label) {
            $items[i].setTick(true);
        }
    }
}

TagNavigation.prototype.setUntick = function($items, label) {
    for(var i = 0; i < $items.length; i++) {
        if($items[i].getLabel() === label) {
            $items[i].setTick(false);
        }
    }
}

TagNavigation.prototype.searchTag = function(value) {
    $.ajax({
        url : $("#base-url").val() + "/tags/search-tag",
        type: 'post',
        context: this,
        data: {query: value, ticked_tags: this.ticked_tags},
        success: function(data) {
            var parsed = JSON.parse(data);
            if(parsed['status'] === 1) {
                this.$searched_item_area.html(parsed['views']);
                for(var i = 0; i < this.$searched_items.length; i++) {
                    this.$searched_items[i].deleteElement();
                }
                this.$searched_items = [];
                $(this.$searched_item_area.html()).filter('.tag-navigation-item').each(function(index, value) {
                    this.$searched_items.push(new TagNavigationItem($(value)));
                }.bind(this));
            }
        }
    });
}

TagNavigation.prototype.searchBarValue = function() {
    return this.$tag_navigation_search.val();
};
TagNavigation.prototype.initWidgetEvents = function() {
    this.tag_navigation_change_ = new CustomEvent(this.EVENTS.TAG_NAVIGATION_CHANGE);
    this.tag_navigation_starred_ = new CustomEvent(this.EVENTS.TAG_NAVIGATION_STARRED);
};

TagNavigation.prototype.triggerChange = function(obj) {
    this.$root.trigger(this.EVENT.TAG_NAVIGATION_CHANGE, [obj]);
};

