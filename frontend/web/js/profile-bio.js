var ProfileBio = function($root) {
    this.$root = $root;
    this.$edit= null;
    this.$edit_area= null;
    this.$view_area = null;
    this.$edit_text_area = null;
    this.$edit_text_area_message = null;
    this.edit_text_area = null;
    this.$intro_text_area = null;
    this.init();
    this.initEvents();
};

ProfileBio.prototype.init = function() {
    this.$edit = this.$root.find('.profile-bio-edit');
    this.$edit_area = this.$root.find('.profile-bio-information-edit-area');
    this.$view_area = this.$root.find('.profile-bio-information');
    this.$edit_text_area = this.$root.find('.profile-bio-information-edit-text-area');
    this.$edit_text_area_message = this.$root.find('.profile-bio-information-edit-area-message');
  
};

ProfileBio.prototype.INTRO_LENGTH = 100;

ProfileBio.prototype.initEvents = function() {
    this.$edit.click(function(e) {
        this.$edit_area.removeClass('hide');
        this.$view_area.addClass('hide');
    }.bind(this));
    
    this.$edit_text_area.on('keydown', function(e) {
        if(e.keyCode === 13) {
            e.preventDefault();
            this.submitBio();
        }
    }.bind(this));
    
    this.$edit_text_area.on('input', function(e) {
        var length = this.$edit_text_area.html().length;
        var remaining = this.INTRO_LENGTH - length;
        this.$edit_text_area_message.html( remaining + "");
        if(remaining < 0) {
            this.$edit_text_area_message.css('color', 'red');
            this.$edit_text_area.addClass('site-field-error');

        } else {
            this.$edit_text_area_message.css('color', 'black');
            this.$edit_text_area.removeClass('site-field-error');
        }
    }.bind(this));
};

ProfileBio.prototype.submitBio = function() {
    var intro = this.$edit_text_area.html();
    if(intro === null || intro === '') {
        
        this.$edit_area.addClass('hide');
        this.$view_area.removeClass('hide');
        return;
    }
    
    if(intro.length >= 100) {
        return;
    }
    
    this.$edit_area.addClass('hide');
    this.$view_area.removeClass('hide');
    this.$view_area.html(intro);
    
    CommonLibrary.showCommonLoading();
    $.ajax({
        url: $("#base-url").val() + "/profile/update-intro",
        type: 'post',
        data: {intro: intro},
        success: function(data) {
            var parsed = JSON.parse(data);
            if(parsed['status'] === 1) {
                
            }
            CommonLibrary.hideCommonLoading();
        },
        error: function(data) {
            CommonLibrary.hideCommonLoading();
        }
        
    })
};