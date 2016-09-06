var TagNavigation = function($root) {
    this.$root = $root;
    this.id = $root.data('id');
    
    this.item_checkbox_class = null;
    this.all_checkbox_class = null;
    
    this.tag_navigation_change_ = null;
    this.init();
    this.initEvents();
    this.initWidgetEvents();
};


TagNavigation.prototype.EVENT = {
    TAG_NAVIGATION_CHANGE : 'tag-navigation-change'
};


TagNavigation.prototype.init = function() {
    this.item_checkbox_class = "tag-navigation-item-checkbox";
    this.all_checkbox_class  = "tag-navigation-all-checkbox";
};

TagNavigation.prototype.initEvents = function() {
    $(document).on('change', '#' + this.id, function(e) {
        if(e.target && $(e.target).hasClass(this.item_checkbox_class) ){
            this.uncheckAllCheckbox();
            var tags = this.getAllChecked();
            this.triggerChange(tags);
        } else if(e.target && $(e.target).hasClass(this.all_checkbox_class)) {
            this.uncheckAll();
            var tags = this.getAllChecked();
            this.triggerChange(tags);
        }

    }.bind(this));
};

TagNavigation.prototype.initWidgetEvents = function() {
    this.tag_navigation_change_ = new CustomEvent(this.EVENT.TAG_NAVIGATION_CHANGE);
};

TagNavigation.prototype.getAllChecked = function() {
    var tags = []; 
    $("#" + this.id).find('.' + this.item_checkbox_class + ":checked").each(function(e) {
        tags.push($(this).data('item'));
    });
    
    return tags;
}

TagNavigation.prototype.uncheckAll = function() {
    
    $("#" + this.id).find('.' + this.item_checkbox_class + ":checked").each(function(e) {
        $(this).prop('checked', false);
    });
};

TagNavigation.prototype.uncheckAllCheckbox = function() {
    $("#" + this.id).find('.' + this.all_checkbox_class + ":checked").prop('checked', false);
    
};

TagNavigation.prototype.triggerChange = function(obj) {
    this.$root.trigger(this.EVENT.TAG_NAVIGATION_CHANGE, [obj]);
};