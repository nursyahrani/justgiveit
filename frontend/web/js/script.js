$(document).ready(function() {
      var app = new App($(this));
  });
//associated index
var App = function($root) {
    this.$root = $root;
    this.$site = null;
    this.site = null;
    this.$post = null;
    this.$login_button = null;
    this.$login_modal =null;
    this.init();
    this.initEvents();
    this.$login_form = null;
    this.login_form = null;
    this.$profile_link_dropdown = null;
    this.profile_link_dropdown = null;
};

App.prototype.CSS_CLASSES = {

};

App.prototype.init = function() {
    if(this.$root.find('.site-index').length !== 0) {
        this.$site = this.$root.find('.site-index');
        this.site = new Site(this.$site);
    } 
    else if (this.$root.find('.post-index').length !== 0) {
        this.$post = new Post(this.$root.find('.post-index'));
    }

    if(this.$root.find('#login-menu').length !== 0) {
        this.$login_button = this.$root.find('#login-menu');
        this.$login_modal = this.$root.find('#login-modal');
    }

    this.$login_form = this.$root.find('#login-form');
    this.login_form = new Login(this.$login_form);

    this.$profile_link_dropdown = this.$root.find('#profile-menu');
    this.profile_link_dropdown = new LinkDropdown(this.$profile_link_dropdown);
};

App.prototype.initEvents = function() {
    $(".give-stuff-modal-button").click(function(event){
        $("#give-stuff-modal").modal("show").load($(this).attr("value"));
    });


    if(this.$root.find('#login-menu').length !== 0) {
        var self = this;
        this.$login_button.click(function(e) {
            self.$login_modal.modal("show").load($(this).attr("value"));
        });
    }

    if(this.$root.find('.site-index').length !== 0) {
        var self = this;

        this.$site.on(Site.prototype.EVENT.BANNER_BUTTON_CLICK, function(e, data) {
            $("#give-stuff-modal").modal("show").load($(this).attr("value"));
        });
    }
};



  