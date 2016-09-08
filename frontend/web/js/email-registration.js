//pre-loaded
var EmailRegistration = function($root) {
    this.$root = $root;
    this.id = $root.data('id');
    
    this.$registration_area = null;
    this.$validation_area = null;
    this.$resend_area = null;
    this.$validated_area = null;
    
    this.$registration_email = null;
    this.$registration_password = null;
    this.$registration_confirm_password = null;
    this.$registration_loading = null;
    this.registration_loading = null;
    this.$registration_save = null;
    
    this.$registration_email_error = null;
    this.$registration_password_error = null;
    this.$registration_confirm_password_error =  null;
    
    this.$validation_email_view = null; //validation email view also for resend email view
    this.$validation_resend_view = null;
    
    this.$resend_captcha_field = null;
    this.$resend_captcha_error = null;
    this.$resend_resend_button = null;
    this.$resend_cancel_button = null;
    this.$resend_resend_loading = null;
    this.resend_resend_loading = null;
    this.init();
    this.initEvents();
};

EmailRegistration.prototype.init = function() {
    this.$registration_area = this.$root.find('.email-registration-registration');
    this.$validation_area = this.$root.find('.email-registration-validation');
    this.$resend_area = this.$root.find('.email-registration-resend');
    this.$validated_area = this.$root.find('.email-registration-validated');
    
    this.$registration_email = this.$root.find('.email-registration-registration-email');
    this.$registration_password = this.$root.find('.email-registration-registration-password');
    this.$registration_confirm_password = this.$root.find('.email-registration-registration-confirm-password');
    this.$registration_loading = this.$root.find("#" + this.id + "-registration-loading");
    this.registration_loading = new Loading(this.$registration_loading);
    this.$registration_save = this.$root.find('.email-registration-registration-save');
    
    this.$registration_email_error = this.$root.find('.email-registration-registration-email-error');
    this.$registration_password_error = this.$root.find('.email-registration-registration-password-error');
    this.$registration_confirm_password_error = this.$root.find('.email-registration-registration-confirm-password-error');
    
    this.$validation_email_view = this.$root.find('.email-registration-validation-email');
    this.$validation_resend_view = this.$root.find('.email-registration-validation-resend-view');
    
    this.$resend_captcha_field = this.$root.find('.email-registration-resend-captcha');
    this.$resend_captcha_error = this.$root.find('.email-registration-resend-captcha-error');
    this.$resend_resend_button = this.$root.find('.email-registration-resend-resend');
    this.$resend_cancel_button = this.$root.find('.email-registration-resend-cancel');
    this.$resend_resend_loading = this.$root.find('#' + this.id + "-resend-loading");
    this.resend_resend_loading = new Loading(this.$resend_resend_loading);
};

EmailRegistration.prototype.initEvents = function() {
    this.$registration_save.click(function(e) {
        var valid = this.validateRegistrationClient();
        if(valid) {
            this.validateRegistrationServer();
        }
    }.bind(this));
    
    this.$validation_resend_view.click(function(e) {
        this.$resend_area.removeClass('hide');
        this.$validation_area.addClass('hide');
    }.bind(this));
    
    this.$resend_resend_button.click(function(e) {
        this.validateResendInServer()
    }.bind(this));
    
    this.$resend_cancel_button.click(function(e) {
        this.$resend_area.addClass('hide');
        this.$validation_area.removeClass('hide');
    }.bind(this));
};

EmailRegistration.prototype.validateResendInServer = function() {
    this.resend_resend_loading.show();
    $.ajax({
        url: $("#base-url").val() + "/site/resend-validation-email",
        type: 'post',
        data: {email: this.getValidationEmailView(), captcha: this.getResendCaptcha()},
        context:this,
        success:    function(data) {
            var parsed = JSON.parse(data);
            if(parsed['status'] === 0) {
                if(parsed['error'] !== undefined && parsed['error']['captcha'] !== undefined) {
                    CommonLibrary.showError(this.$resend_captcha_error, parsed['error']['captcha'][0]);
                }
            } else {
                CommonLibrary.hideError(this.$resend_captcha_error);
                this.$resend_cancel_button.click();
            }
            this.resend_resend_loading.hide();
        },
        error: function(data) {
            this.resend_resend_loading.hide();
        }
        
    });
};

EmailRegistration.prototype.validateRegistrationServer = function() {
    this.registration_loading.show();
    $.ajax( {
       url : $("#base-url").val() + "/site/register-login-user-email",
       type: 'post',
       context: this,
       data: {email: this.getEmailRegistration(), password: this.getPasswordRegistration()},
       success: function(data) {
           var parsed = JSON.parse(data);
           if(parsed['status'] === 0) {
               if(parsed['error']['email'] !== undefined) {
                   CommonLibrary.showError(this.$registration_email_error, parsed['error']['email'][0]);
               }
               if(parsed['error']['password'] !== undefined) {
                   CommonLibrary.showError(this.$registration_email_error, parsed['error']['password'][0]);
               }
           } else {
               this.$registration_area.addClass('hide');
               this.$validation_area.removeClass('hide');
               this.setValidationEmailView(this.getEmailRegistration());
               CommonLibrary.hideError(this.$registration_email_error);
               CommonLibrary.hideError(this.$registration_password_error);
               CommonLibrary.hideError(this.$registration_confirm_password_error);
           }
           this.registration_loading.hide();
       },
       error : function(data) {
           this.registration_loading.hide();
       }
    });
};

EmailRegistration.prototype.validateRegistrationClient = function() {
    var valid = true;
    var email = this.getEmailRegistration();
    var password = this.getPasswordRegistration();
    var confirm_password = this.getConfirmPasswordRegistration();
    
    if(email === null || email === '') {
        valid = false;
        CommonLibrary.showError(this.$registration_email_error, 'Email should not be empty');
    } else if(!CommonLibrary.validateEmail(email)) {
        valid = false;
        CommonLibrary.showError(this.$registration_email_error, 'Email is not valid');
    } else {
        CommonLibrary.hideError(this.$registration_email_error);
    }
    
    if(password === null || password === '') {
        valid = false;
        CommonLibrary.showError(this.$registration_password_error, 'Password should not be empty');
    } else if(password.length < 6) {
        valid = false;
        CommonLibrary.showError(this.$registration_password_error, 'Password should be at least 6 characters');

    } else {
        CommonLibrary.hideError(this.$registration_password_error);
    }
    
    if(confirm_password !== password) {
        valid = false;
        CommonLibrary.showError(this.$registration_confirm_password_error, 'Password does not match');
    } else {
        CommonLibrary.hideError(this.$registration_confirm_password_error);
    }
    
    return valid;
};

EmailRegistration.prototype.getEmailRegistration = function() {
    return this.$registration_email.val();
}

EmailRegistration.prototype.getPasswordRegistration = function() {
    return this.$registration_password.val();
}

EmailRegistration.prototype.getConfirmPasswordRegistration = function() {
    return this.$registration_confirm_password.val();
}

EmailRegistration.prototype.getValidationEmailView = function() {
    return $(this.$validation_email_view[0]).text().trim();
};

EmailRegistration.prototype.setValidationEmailView = function(email) {
    this.$validation_email_view.text(email)
};

EmailRegistration.prototype.getResendCaptcha = function() {
    return this.$resend_captcha_field.val();
}

EmailRegistration.prototype.refreshCaptcha = function() {
    
}