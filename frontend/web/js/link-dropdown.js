/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var LinkDropdown = function($root) {
    this.$root = $root;
    this.$dropdown_area = null;
    this.$dropdown_button = null;
    this.$dropdown_item = null;
    this.init();
    this.initEvent();
};


LinkDropdown.prototype.init = function () {
    this.$dropdown_area = this.$root.find('.link-dropdown-area');
    this.$dropdown_button = this.$root.find('.link-dropdown-button');
    this.$dropdown_item = this.$root.find('.link-dropdown-item');
};

LinkDropdown.prototype.initEvent = function() {
    var self = this;
    this.$dropdown_button.on('click', function(e) {
        self.$dropdown_area.toggle(100);
    });
    
    this.$dropdown_button.on('blur', function(e) {
        self.$dropdown_area.hide(100);
    });
    
    this.$dropdown_item.on('mousedown', function(e){
       this.click(); 
    });
};


