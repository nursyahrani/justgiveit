/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var ChangeImage = function($root) {
    this.$root = $root;
    this.$image_error = null;
    this.$image = null;
    this.$select_photo_input = null;
    this.imageValid  = null;
    //file
    this.currentFile = null;
    this.$ok_button = null;
    this.$cancel_button = null;
    
    //event
    this.image_changed_event_ = null;
    this.cancel_event_ = null;
    this.init();
    this.initEvents();
    this.initWidgetEvents();
};

ChangeImage.prototype.init = function() {
    this.$select_photo_input = this.$root.find('.change-image-select-photo');
    this.$image_error = this.$root.find('.change-image-error');
    this.$image = this.$root.find('.change-image-view');
    this.$ok_button = this.$root.find('.change-image-button-ok');
    this.$cancel_button = this.$root.find('.change-image-button-cancel');
    
};

ChangeImage.prototype.initWidgetEvents = function() {
    this.image_changed_event_ = new CustomEvent(
            ChangeImage.prototype.EVENT.CHANGE_IMAGE_IMAGE_CHANGED);
    
    this.cancel_event_ = new CustomEvent(
            ChangeImage.prototype.EVENT.CHANGE_IMAGE_CANCEL);
    
};

ChangeImage.prototype.initEvents = function() {
    var self = this;
    
    this.$cancel_button.click(function(e){
        this.triggerCancelEvent_();
    }.bind(this));
    
    this.$ok_button.click(function(e){
        $.ajax({
            url : $("#base-url").val() + '/site/upload-image' ,
            type: 'post',
            data: this.currentFile,
            context: this,
            processData: false,
            enctype: 'multipart/form-data',
            cache: false,
            contentType: false,
            success: function(data) {
               var parsed = JSON.parse(data);
               if(parsed['status'] === 1) {
                   var image_id = parsed['image_id'];
                   var image_path = parsed['image_path']
                   this.triggerImageChangedEvent_({image_id: image_id, image_path: image_path});
               }
           }
        });
    }.bind(this));
    
    this.$select_photo_input.change(function(e ){
        if (this.files && this.files[0]) {
          var reader = new FileReader();
          if(this.files[0].size / 1024 / 1024 > 25) {
              self.showError(self.$image_error, 'File size cannot be larger than 20 MB');
              self.imageValid = false;
              return false;
          }
          else {
              self.imageValid = true;
              self.hideError(self.$image_error);
          }
          self.currentFile = new FormData();
          self.currentFile.append('image',this.files[0]);
          reader.onload = function (e) {
            var selectedImage = e.target.result;
            self.$image.attr('src', selectedImage);
            self.$ok_button.removeClass('hide');
          };
          reader.readAsDataURL(this.files[0]);
        }
    });
};


ChangeImage.prototype.showError = function($element, message ) {
    $element.html(message);
};

ChangeImage.prototype.hideError = function($element) {
    $element.html();
};



ChangeImage.prototype.EVENT = {
    CHANGE_IMAGE_IMAGE_CHANGED : 'change-image-image-changed',
    CHANGE_IMAGE_CANCEL : 'change-image-cancel'
};

ChangeImage.prototype.triggerImageChangedEvent_ = function(image_data) {
    this.$root.trigger(this.EVENT.CHANGE_IMAGE_IMAGE_CHANGED, [image_data]);
};

ChangeImage.prototype.triggerCancelEvent_ = function() {
    this.$root.trigger(this.EVENT.CHANGE_IMAGE_CANCEL);
    
}