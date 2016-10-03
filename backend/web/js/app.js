$(document).ready(function(e) {
    new App($(this));
});

var App = function($root) {
    this.$root = $root;
    this.login = null;
    this.init();
};

App.prototype.init = function() {
    if(this.$root.find('.login-index').length !== 0) {
        this.login = new Login(this.$root.find('.login-index'));
    }
};