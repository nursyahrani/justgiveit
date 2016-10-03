var Login = function($root) {
    this.$root = $root;
    this.$email = null;
    this.$email_error = null;
    this.$password = null;
    this.$password_error = null;
    this.$login_btn = null;
    this.loading = null;
    this.init();
    this.initEvents();
};
    

Login.prototype.init = function() {
    this.$email = this.$root.find('.login-email-field');
    this.$email_error = this.$root.find('.login-email-error');
    this.$password = this.$root.find('.login-password-field');
    this.$password_error = this.$root.find('.login-password-error');
    this.$login_btn = this.$root.find('.login-login-button');
    this.loading = new Loading(this.$root.find('#login-loading'));
};

Login.prototype.initEvents = function() {
    this.$login_btn.click(function(e) {
        var valid = this.validateInClient();
        if(valid) {
            this.submitLogin();   
        }
    }.bind(this));
    
};

Login.prototype.validateInClient = function() {
    var valid = true;
    var email = this.getEmailValue();
    var password = this.getPasswordValue();
    
    if(email === null || email === '') {
        valid = false;
        CommonLibrary.showError(this.$email_error, 'Email cannot be empty');
    } else {
        CommonLibrary.hideError(this.$email_error);
    }
    
    if(password === null || password === '') {
        valid = false;
        CommonLibrary.showError(this.$password_error, 'Password cannot be empty');
    } else {
        CommonLibrary.hideError(this.$password_error);
    }
    
    return valid;
};

Login.prototype.submitLogin = function() {
    this.loading.show();
    this.$login_btn.prop('disabled', true);
    $.ajax({
        url: $("#base-url").val() + "/site/process-login",
        type: 'post',
        data: {email: this.$email.val(), password:this.$password.val()},
        context: this,
        success: function(data) {
            var parsed = JSON.parse(data);
            this.$login_btn.prop('disabled', false);
            if(parsed['status'] === 1) {
                window.location.href = $("#base-url").val() + "/";
                CommonLibrary.hideError(this.$password_error);
                CommonLibrary.hideError(this.$email_error);
            } else {
                if(parsed['errors']['password'] !== undefined) {
                    CommonLibrary.showError(this.$password_error, parsed['errors']['password'][0]);
                }
                if(parsed['errors']['email'] !== undefined) {
                    CommonLibrary.showError(this.$email_error, parsed['errors']['email'][0]);
                }
                
            }
            this.loading.hide();
        },
        error: function(data) {
            this.loading.hide();
        }
    });
};

Login.prototype.getEmailValue = function() {
    return this.$email.val();
};

Login.prototype.getPasswordValue = function() {
    return this.$password.val();
}

