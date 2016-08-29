//dynamically added
var ImageViewEditor = function($root) {
    this.$root  = $root;
    this.id = $root.data('id');
    this.image_class = null;
    this.image_view_image_in_modal_class = null;
    this.image_view_modal_id = null;
    
    this.init();
    this.initEvents();
};

ImageViewEditor.prototype.init = function() {
    this.image_class = "image-view-editor-image";
    this.image_view_image_in_modal_class = "image-view-editor-image-modal";
    this.image_view_modal_id = this.id + "-modal";
};
ImageViewEditor.prototype.initEvents = function() {
    $(document).on('click', '#' + this.id, function(e){
        if(e.target && $(e.target).hasClass(this.image_class)) {
            $("#" + this.id).find("#" + this.image_view_modal_id).modal("show").load($(this).attr("value"));
        }
    }.bind(this));
};

ImageViewEditor.prototype.setImage = function(image_path) {
    $("#" +id).find("." + this.image_class).attr('src', image_path);
    $("#" + id).find("." + this.image_view_image_in_modal_class).attr('src', image_path);
};