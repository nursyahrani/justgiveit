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
    
    //expand collapse button
    this.$starred_expand = null;
    this.$starred_collapse = null;
    this.$all_expand = null;
    this.$all_collapse = null;
    
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
    this.$starred_expand = this.$root.find('.tag-navigation-starred-expand');
    this.$starred_collapse = this.$root.find('.tag-navigation-starred-collapse');
    this.$all_expand = this.$root.find('.tag-navigation-all-expand');
    this.$all_collapse = this.$root.find('.tag-navigation-all-collapse');
    
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
    this.$starred_collapse.click(function(e) {
        this.$starred_item_area.addClass('hide');
        this.$starred_expand.removeClass('hide');
        this.$starred_collapse.addClass('hide');
    }.bind(this));
    
    this.$starred_expand.click(function(e) {
        this.$starred_item_area.removeClass('hide');
        this.$starred_collapse.removeClass('hide');
        this.$starred_expand.addClass('hide');
    }.bind(this));
    
    this.$all_collapse.click(function(e) {
        this.$all_item_area.addClass('hide');
        this.$all_expand.removeClass('hide');
        this.$all_collapse.addClass('hide');
    }.bind(this));
    
    this.$all_expand.click(function(e) {
        this.$all_item_area.removeClass('hide');
        this.$all_collapse.removeClass('hide');
        this.$all_expand.addClass('hide');
    }.bind(this));
    
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
                this.addTagFromSearchToAll(label, true, 'all-tags');
            }
            this.triggerChange(this.ticked_tags);
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
            
            this.triggerChange(this.ticked_tags);
            this.setUntick(this.$searched_items, label);
            this.setUntick(this.$all_items, label);
            this.setUntick(this.$starred_items, label);
        }
    }.bind(this));
    
    
    $(document).on(TagNavigationItem.prototype.EVENTS.TAG_NAVIGATION_ITEM_FAVORITE, "#" + this.id, function(e, label) {
        if(e.target && $(e.target).hasClass('tag-navigation-item')) {
            this.label_selector = '.tag-navigation-item[data-label="' + label +'"]';
            //it is in search area but not in all area and starred area
            if(this.$starred_item_area.find(this.label_selector).length === 0) {
                this.addTagFromSearchToStarred(label);
            }
            this.sendFavoriteAjax(label);
            
            this.setFavorite(this.$searched_items, label);
            this.setFavorite(this.$all_items, label);
            this.setFavorite(this.$starred_items, label);
        }
    }.bind(this));
    
    
    $(document).on(TagNavigationItem.prototype.EVENTS.TAG_NAVIGATION_ITEM_UNFAVORITE, "#" + this.id, function(e, label) {
        if(e.target && $(e.target).hasClass('tag-navigation-item')) {
            this.label_selector = '.tag-navigation-item[data-label="' + label +'"]';
            //it is in search area but not in all area and starred area
            if(this.$starred_item_area.find(this.label_selector).length !== 0) {
                this.removeTagFromStarred(label);
            }
            this.sendUnfavoriteAjax(label);
            
            this.setUnfavorite(this.$searched_items, label);
            this.setUnfavorite(this.$all_items, label);
            this.setUnfavorite(this.$starred_items, label);
        }
    }.bind(this));
};

TagNavigation.prototype.sendFavoriteAjax = function(label) {
    $.ajax({
        url: $("#base-url").val() + "/tags/request-starred",
        type: 'post',
        data: {tag_name: label},
        success: function(data) {
            
        }
    });
};

TagNavigation.prototype.sendUnfavoriteAjax = function(label) {
    $.ajax({
        url: $("#base-url").val() + "/tags/cancel-starred",
        type: 'post',
        data: {tag_name: label},
        success: function(data) {
            
        }
    });
};

TagNavigation.prototype.addTagFromSearchToStarred = function(label) {
   $.ajax({
        url : $("#base-url").val() + "/tags/get-tag",
        data: {label: label, tick: (this.ticked_tags.indexOf(label) !== -1), prepend_id: 'starred-tags', starred: true },
        type: 'post',
        context: this,
        success: function(data) {
            var parsed = JSON.parse(data);
            if(parsed['status'] === 1) {
                this.$starred_item_area.prepend(parsed['views']);
                this.$starred_items.push(new TagNavigationItem($(parsed['views'])));
            }
        }
    });
};

TagNavigation.prototype.removeTagFromStarred = function(label) {
    for(var i = 0; i < this.$starred_items.length; i++) {
        if(this.$starred_items[i].getLabel() === label) {
            this.$starred_items[i].deleteElement();
        }
    }
    
    this.$starred_item_area.find('.tag-navigation-item[data-label="' + label + '"]').remove();
};

TagNavigation.prototype.addTagFromSearchToAll = function(label, tick, prepend_id) {
    $.ajax({
        url : $("#base-url").val() + "/tags/get-tag",
        data: {label: label, tick: tick, prepend_id: prepend_id, favorite: false },
        type: 'post',
        context: this,
        success: function(data) {
            var parsed = JSON.parse(data);
            if(parsed['status'] === 1) {
                this.$all_item_area.prepend(parsed['views']);
                this.$all_items.push(new TagNavigationItem($(parsed['views'])));
            }
        }
    });
};


TagNavigation.prototype.setFavorite = function($items, label) {
    for(var i = 0; i < $items.length; i++) {
        if($items[i].getLabel() === label) {
            $items[i].setFavorite();
        }
    }
};


TagNavigation.prototype.setUnfavorite = function($items, label) {
    for(var i = 0; i < $items.length; i++) {
        if($items[i].getLabel() === label) {
            $items[i].setUnfavorite();
        }
    }
};


TagNavigation.prototype.setTick = function($items, label) {
    for(var i = 0; i < $items.length; i++) {
        if($items[i].getLabel() === label) {
            $items[i].setTick(true);
        }
    }
};

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
    this.$root.trigger(this.EVENTS.TAG_NAVIGATION_CHANGE, [obj]);
};

