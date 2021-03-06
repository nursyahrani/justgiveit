var Loading = function($root) {
    this.$root = $root;
    this.$loading = null;
    this.init();
    this.initEvents();
};

Loading.prototype.init = function() {
    this.$loading = this.$root.find('.loading-img');
};

Loading.prototype.initEvents = function() {
    
};

Loading.prototype.hide = function() {
    this.$root.hide();
};

Loading.prototype.show = function() {
    this.$root.show();
};

Loading.prototype.setMessage  = function(message) {
    this.$root.html(message + this.$root.html());
};


