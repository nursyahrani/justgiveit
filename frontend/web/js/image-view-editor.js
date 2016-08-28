/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var ImageViewEditor = function($root) {
    this.$root  = $root;
    this.id = $root.data('id');
    this.$image = $root.find('.image-view-editor-image');
    this.$image_view_image_in_modal = $root.find('.image-view-editor-image-modal');
    this.$image_view_modal = $root.find('#' + this.id + '-modal');
    
    this.init();
};

ImageViewEditor.prototype.init = function() {
    this.$image.click(function(e){
        this.$image_view_modal.modal("show").load($(this).attr("value"));
    }.bind(this));
};

ImageViewEditor.prototype.setImage = function(image_path) {
    this.$image.attr('src', image_path);
    this.$image_view_image_in_modal.attr('src', image_path);
};