var ProfileBio = function($root) {
    this.$root = $root;
    this.$edit= null;
    this.$edit_area= null;
    this.$view_area = null;
    this.$edit_text_area = null;
    this.init();
    this.initEvents();
};

ProfileBio.prototype.init = function() {
    this.$edit = this.$root.find('.profile-bio-edit');
    this.$edit_area = this.$root.find('.profile-bio-information-edit-area');
    this.$view_area = this.$root.find('.profile-bio-information');
    this.$edit_text_area = this.$root.find('.profile-bio-information-edit-text-area');
};

ProfileBio.prototype.initEvents = function() {
    this.$edit.click(function(e) {
        this.$edit_area.removeClass('hide');
        this.$view_area.addClass('hide');
    }.bind(this));
    
    this.$edit_text_area.on('keydown', function(e) {
        if(e.keyCode === 13) {
            e.preventDefault();
        }
    }.bind(this));
    
    this.$edit_text_area.on('input', function(e) {
        
    }.bind(this));
};

ProfileBio.prototype.submitBio = function() {
    
};