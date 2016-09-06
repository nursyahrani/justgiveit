/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var CreatePost = function($root) {
    this.$root = $root;
    this.id = $root.data('id');
    
    //global valid
    this.imageValid = true;
    
    //field
    this.$tags = null;
    this.$title = null;
    this.$description = null;
    this.$image = null;
    this.$quantity = null;
    //field error
    this.$tags_error = null;
    this.$title_error = null;
    this.$description_error = null;
    
    //button
    this.$create_button = null;
    this.$select_photo_input = null;
    this.$upload_photo_modal = null;
    
    //loading
    this.$loading = null;
    this.loading = null;
    
    this.init();
    this.initEvents();
};

CreatePost.prototype.init = function() {
    this.$tags = this.$root.find('#create-post-information-tags');
    this.$title = this.$root.find('.create-post-information-title');
    this.$description = this.$root.find('.create-post-information-description');
    this.$image = this.$root.find('.create-post-image-view');
    this.$quantity = this.$root.find('.create-post-information-quantity');
    //error
    this.$tags_error = this.$root.find('.create-post-information-tags-error');
    this.$title_error = this.$root.find('.create-post-information-title-error');
    this.$description_error = this.$root.find('.create-post-information-description-error');
    this.$image_error = this.$root.find('.create-post-information-image-error');
    this.$quantity_error =this.$root.find('.create-post-information-quantity-error');
    //button
    this.$create_button = this.$root.find('.create-post-create');
    this.$select_photo_input = this.$root.find('.create-post-image-select-photo');
    this.$upload_photo_modal = this.$root.find('#' + this.id + "-modal");
    
    //loading
    this.$loading = this.$root.find('#' + this.id + '-loading');
    this.loading  = new Loading(this.$loading);
    
    //file
    this.currentFile = null;
};

CreatePost.prototype.initEvents = function() {
    var self = this;
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
          };
          reader.readAsDataURL(this.files[0]);
        }
    });
    
    this.$create_button.click(function(e) {
        var valid  = this.validateInClient();
        if(valid) {
            this.uploadImage();
        }
    }.bind(this));
};

CreatePost.prototype.uploadImage = function() {
    this.loading.setMessage("Uploading Image");
    this.loading.show();
    
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
               this.postData(image_id);
           }
       }
    });
    
};

CreatePost.prototype.postData = function(image_id) {
    this.loading.setMessage("Creating Post");
    this.loading.show();
    
    $.ajax({
        url: $("#base-url").val() + "/post/process-create",
        type: 'post',
        context: this,
        data: {title: this.getTitleVal(), description: this.getDescriptionVal(),
                image_id:image_id, tags: this.getTagsVal(), quantity: this.getQuantityVal()},
        success: function(data) {
            var parsed = JSON.parse(data);
            if(parsed['status'] === 1) {
                window.location.href = $("#base-url").val() + "/post/" + 
                        parsed['stuff_id'] + "/" + this.getTitleVal();
            }
        }
    });
}

CreatePost.prototype.validateInClient = function() {
    var valid  = true;
        
    if(!this.imageValid) {
        valid = false;
    } else {
        
        if(this.getImageVal() === null || this.getImageVal() === '') {
            valid = false;
            this.showError(this.$image_error, 'Please put some image');

        } else {
            this.hideError(this.$image_error);
        }
    } 

    if(this.getTitleVal() === null || this.getTitleVal() === '' ) {
        valid  = false;
        this.showError(this.$title_error, 'Title cannot be empty');
    } else {
        this.hideError(this.$title_error);
    }

    if(this.getDescriptionVal() === null || this.getDescriptionVal() === '' ) {
        valid = false;
        this.showError(this.$description_error, 'Please put some descriptions about the stuff');
    } else {
        this.hideError(this.$description_error);
    }

    if(this.getTagsVal() === null || this.getTagsVal().length === 0) {
        valid = false;
        this.showError(this.$tags_error, 'Please choose at least 1 tag');
        
    } else {
        this.hideError(this.$tags_error);
    }
    
    if(this.getQuantityVal() === 0 || this.getQuantityVal() === null) {
        valid = false;
        this.showError(this.$quantity_error, 'Quantity should be at least 1');
    } else {
        this.hideError(this.$quantity_error);
    }
    
    return valid;
};

CreatePost.prototype.showError = function($element, message) {
    $element.html(message);
};

CreatePost.prototype.hideError = function($element) {
    $element.html('');
};

CreatePost.prototype.getTitleVal = function() {
    return this.$title.val();
};


CreatePost.prototype.getDescriptionVal = function() {
    return this.$description.html();
};

CreatePost.prototype.getTagsVal = function() {
    return this.$tags.val();
}

CreatePost.prototype.getImageVal = function() {
    return this.$select_photo_input.val();
}

CreatePost.prototype.getQuantityVal = function() {
    var quantity = this.$quantity.val();
    if(quantity === null) {
        quantity = 0;
    }
    
    return parseInt( quantity);
}
