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
    this.$login_form = null;
    this.$home_menu_btn = null;
    this.login_form = null;
    this.$profile_link_dropdown = null;
    this.profile_link_dropdown = null;
    this.$create_post_modal = null;
    this.$create_post_button  =null;
    this.$create_post_form = null;
    this.create_post_form = null;

this.init();
    this.initEvents();
    
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
    } else if(this.$root.find('.create-post-index').length !== 0) {
        this.$create_post_form = this.$root.find('.create-post-index');
        this.create_post_form = new CreatePost(this.$create_post_form);
    }

    if(this.$root.find('#login-menu').length !== 0) {
        this.$login_button = this.$root.find('#login-menu');
        this.$login_modal = this.$root.find('#login-modal');
    }
    
    this.$home_menu_button  = this.$root.find('.home-menu-button');
    
    this.$login_form = this.$root.find('#login-form');
    this.login_form = new Login(this.$login_form);
    this.$create_post_button = this.$root.find('.give-stuff-modal-button');
    this.$profile_link_dropdown = this.$root.find('#profile-menu');
    this.profile_link_dropdown = new LinkDropdown(this.$profile_link_dropdown);
    this.$create_post_form =this.$root.find('#create-post');
    this.create_post_form = new CreatePost(this.$create_post_form);
};

App.prototype.initEvents = function() {
    this.$create_post_button.click(function(event) {
        window.location.href = $("#base-url").val() + "/post/create";
    }.bind(this));


    if(this.$root.find('#login-menu').length !== 0) {
        var self = this;
        this.$login_button.click(function(e) {
            self.$login_modal.modal("show").load($(this).attr("value"));
        });
    }
    
    this.$home_menu_button.click(function(e) {
        window.location.href = $("#base-url").val() + "/";
    });
    
    
};