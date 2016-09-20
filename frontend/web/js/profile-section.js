var ProfileSection = function($root) {
    this.$root = $root;
    this.id = $root.data('id');
    this.profile_image = null;
    
    this.$change_to_edit_name = null;
    this.$change_to_edit_location = null;
    
    //first name and last name
    this.$view_name_area = null;
    this.$edit_name_area = null;
    this.$name = null;
    this.$edit_first_name = null;
    this.$edit_first_name_error = null;
    this.$edit_last_name = null;
    this.$update_name = null;
    this.$cancel_name = null;
    
    //location
    this.$view_location_area = null;
    this.$edit_location_area = null;
    this.$edit_location = null;
    this.$update_location = null;
    this.$cancel_location = null;
    this.$location = null;
    
    this.init();
    this.initEvents();
};

ProfileSection.prototype.init = function() {
    this.profile_image = new ImageViewEditor(this.$root.find('#' + this.id + "-image-view"));
    
    this.$change_to_edit_name = this.$root.find('.profile-section-name-edit');
    this.$change_to_edit_location = this.$root.find('.profile-section-location-edit');
    
    //first name and last name
    this.$view_name_area = this.$root.find('.profile-section-information-name-area');
    this.$name = this.$root.find('.profile-section-information-name');
    this.$edit_name_area = this.$root.find('.profile-section-information-edit-name-area');
    this.$edit_first_name = this.$root.find('.profile-section-first-name');
    this.$edit_first_name_error = this.$root.find('.profile-section-first-name-error');
    this.$edit_last_name = this.$root.find('.profile-section-last-name');
    this.$cancel_name = this.$root.find('.profile-section-information-edit-name-cancel');
    this.$update_name = this.$root.find('.profile-section-information-edit-name-edit');
    //location
    this.$location = this.$root.find('.profile-section-information-location');
    this.$view_location_area = this.$root.find('.profile-section-information-location-area');
    this.$edit_location_area = this.$root.find('.profile-section-information-edit-location-area');
    this.$edit_location = this.$root.find('#profile-section-information-edit-location-field');
    this.$edit_location_error = this.$root.find('.profile-section-information-location-area-error');
    this.$update_location = this.$root.find('.profile-section-information-edit-location-edit')
    this.$cancel_location = this.$root.find('.profile-section-information-edit-location-cancel');
};

ProfileSection.prototype.initEvents = function() {
    this.$change_to_edit_name.click(function(e) {
        this.$view_name_area.addClass('hide');
        this.$edit_name_area.removeClass('hide');
    }.bind(this));
    
    this.$change_to_edit_location.click(function(e) {
        this.$view_location_area.addClass('hide');
        this.$edit_location_area.removeClass('hide');
    }.bind(this));
    
    this.$cancel_name.click(function(e) {
        this.$view_name_area.removeClass('hide');
        this.$edit_name_area.addClass('hide');
    }.bind(this));
    
    this.$cancel_location.click(function(e) {
        this.$view_location_area.removeClass('hide');
        this.$edit_location_area.addClass('hide');
    }.bind(this));
    
    this.$update_name.click(function(e) {
        this.updateName();
    }.bind(this));
    
    this.$update_location.click(function(e) {
        this.updateLocation();
    }.bind(this));

}

ProfileSection.prototype.updateLocation = function() {
    var valid = this.validateLocationInClient();
    if(valid) {
        this.$location.html(this.$edit_location.select2('data')[0].text);
        this.$view_location_area.removeClass('hide');
        this.$edit_location_area.addClass('hide');
        this.validateLocationInServer();
    }
};

ProfileSection.prototype.updateName = function() {
   var valid = this.validateNameInClient();
   if(valid) {
        this.$name.html(this.$edit_first_name.val() + " " + this.$edit_last_name.val()); 
        this.$view_name_area.removeClass('hide');
        this.$edit_name_area.addClass('hide');
        this.validateNameInServer();
   }
};  

ProfileSection.prototype.validateLocationInClient = function() {
    var valid = true;
    var location = this.$edit_location.val();
    
    if(location === '' || location === null) {
        valid = false;
        CommonLibrary.showError(this.$edit_location_error, 'Please choose your current city');
    } else {
        CommonLibrary.hideError(this.$edit_location_error);
    }
   
    return valid;
};

ProfileSection.prototype.validateLocationInServer = function() {
    CommonLibrary.showCommonLoading();
    $.ajax({
        url: $("#base-url").val() + "/profile/update-city",
        data: {city_id: parseInt(this.$edit_location.val())},
        type: 'post',
        success: function(data) {
            CommonLibrary.hideCommonLoading();
        },
        error: function(data) {
            CommonLibrary.hideCommonLoading();
        }
    });
};

ProfileSection.prototype.validateNameInClient = function() {
    var valid = true;
    var first_name = this.$edit_first_name.val();
    if(first_name === '' || first_name === null) {
        valid = false;
        CommonLibrary.showError(this.$edit_first_name_error, 'First Name cannot be empty');
    } else {
        CommonLibrary.hideError(this.$edit_first_name_error);
    }
    
    return valid;
};

ProfileSection.prototype.validateNameInServer = function() {
    CommonLibrary.showCommonLoading();
    $.ajax({
        url: $("#base-url").val() + "/profile/update-name",
        data: {first_name: this.$edit_first_name.val(), last_name: this.$edit_last_name.val() },
        type: 'post',
        success: function(data) {
            CommonLibrary.hideCommonLoading();
        },
        error: function(data) {
            CommonLibrary.hideCommonLoading();
        }
    });
}