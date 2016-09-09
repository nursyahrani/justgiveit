/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var Login = function($root) {
    this.$root = $root;
    this.id = $root.data('id');
    this.$register_with_email_button = null;
    this.$go_to_login_button = null;
    
    this.$login_panel = null;
    this.$register_panel = null;
    this.$forgot_password_panel = null;
    
    this.$login_register_button = null;
    this.$login_login_button = null;
    
    //register
    this.$register_first_name_field = null;
    this.$register_last_name_field = null;
    this.$register_email_field = null;
    this.$register_password_field = null;
    
    //login
    this.$login_email_field = null;
    this.$login_password_field = null;
    
    //login_error
    this.$login_email_error = null;
    this.$login_password_error = null;
    
    //regsiter error
    this.$register_first_name_error = null;
    this.$register_email_error = null;
    this.$register_password_error =null;
    
    
    //forgot password
    this.$forgot_password_captcha_field = null;
    this.$forgot_password_email_field = null;
    
    //forgot password error
    this.$forgot_password_email_error = null;
    this.$forgot_password_captcha_error = null;
    
    //forgot password submit
    this.$forgot_password_submit = null;
    this.$forgot_password_loading = null;
    this.forgot_password_loading = null;
    this.$forgot_password_validated = null;
    
    //auth
    this.$login_with_facebook = null;
    
    
    this.country;
    this.country_code;
    this.city;
    
    this.init();
    this.initEvents();
};

Login.prototype.init = function() {
    this.$register_with_email_button = this.$root.find('.login-login-register-email');
    
    this.$login_panel = this.$root.find('.login-login');
    this.$register_panel = this.$root.find('.login-register');
    this.$forgot_password_panel = this.$root.find('.login-forgot-password');
    
    this.$go_to_login_button = this.$root.find('.login-register-login');
    this.$go_to_forgot_password = this.$root.find('.login-login-forgot-password');
    this.$login_register_button = this.$root.find('.login-register-button');
    this.$login_login_button = this.$root.find('.login-login-button');
    //register form
    this.$register_first_name_field = this.$root.find('.login-register-first-name');
    this.$register_last_name_field = this.$root.find('.login-register-last-name');
    this.$register_email_field = this.$root.find('.login-register-email');
    this.$register_password_field = this.$root.find('.login-register-password');
    
    //login_form 
    this.$login_email_field = this.$root.find('.login-login-email');
    this.$login_password_field = this.$root.find('.login-login-password');
    
    //forgot password
    this.$forgot_password_captcha_field = this.$root.find('#' + this.id + '-forgot-password-captcha');
    this.$forgot_password_email_field = this.$root.find('.login-forgot-password-email');
    
    //forgot password error
    this.$forgot_password_email_error = this.$root.find('.login-forgot-password-email-error');
    this.$forgot_password_captcha_error = this.$root.find('.login-forgot-password-captcha-error');
    
    //forgot password submit
    this.$forgot_password_submit = this.$root.find('.login-forgot-password-button');
    this.$forgot_password_loading = this.$root.find('#' + this.id + "-forgot-password-loading");
    this.forgot_password_loading = new Loading(this.$forgot_password_loading);
    this.$forgot_password_validated = this.$root.find('.login-forgot-password-validated');
    //login error
    this.$login_email_error = this.$root.find('.login-login-email-error');
    this.$login_password_error = this.$root.find('.login-login-password-error');
    
    //register error
    this.$register_first_name_error = this.$root.find('.login-register-first-name-error');
    this.$register_email_error = this.$root.find('.login-register-email-error');
    this.$register_password_error = this.$root.find('.login-register-password-error');
    var self = this;
    
    
    this.$login_with_facebook = this.$root.find('.login-continue-with-facebook');
    
    
};

Login.prototype.initEvents = function() {
    this.$register_with_email_button.click(function(e){
        this.triggerRegisterEvent();
        this.$register_panel.removeClass('hide');
        this.$forgot_password_panel.addClass('hide');
        this.$login_panel.addClass('hide');
    }.bind(this));
    
    this.$go_to_login_button.click(function(e){
        this.triggerLoginEvent();
        this.$register_panel.addClass('hide');
        this.$forgot_password_panel.addClass('hide');
        this.$login_panel.removeClass('hide');
    }.bind(this));
    
    this.$go_to_forgot_password.click(function(e) {
        this.triggerForgotPasswordEvent();
        this.$register_panel.addClass('hide');
        this.$login_panel.addClass('hide');
        this.$forgot_password_panel.removeClass('hide');
    }.bind(this));
    
    this.$forgot_password_submit.click(function(e) {
        this.submitForgotPasswordForm();
    }.bind(this));
    
    this.$login_register_button.click( function(e) {
        this.submitRegisterForm();
    }.bind(this));
    
    this.$login_login_button.click(function(e) {
        this.submitLoginForm();
    }.bind(this));
    
    this.$login_with_facebook.click(function(e){
        $.ajax({
            url: $("#base-url").val() + "/site/auth?authclient=facebook",
            type: 'post',
            context: this,
            data: {country_code: this.country_code, country: this.country, city: this.city},
            success: function(data) {
            }
        });
    }.bind(this));
    
    this.$login_panel.on('keypress', function(e) {
        if(e.keyCode === 13) {
            this.submitLoginForm();
        }
    }.bind(this));
    
    this.$register_panel.on('keypress', function(e) {
        if(e.keyCode === 13) {
            this.submitRegisterForm();
        }
    }.bind(this))
};

Login.prototype.submitForgotPasswordForm = function() {
    $valid = this.validateForgotPasswordFormInClient();
    if($valid) {
        this.validateForgotPasswordFormInServer();
    }
};

Login.prototype.submitRegisterForm = function() {
    $valid = this.validateRegisterFormInClient();
    if($valid) {
        this.validateRegisterInServerSide();
    }
};

Login.prototype.submitLoginForm = function() {
    $valid = this.validateLoginFormInClient();
    if($valid) {
        this.validateLoginInServerSide();
    }
};

Login.prototype.validateForgotPasswordFormInClient = function() {
    var valid = true;
    
    var email = this.getForgotPasswordEmailField();
    var captcha = this.getForgotPasswordCaptchaField();
    
    if(email === null || email === '') {
        valid = false;
        CommonLibrary.showError(this.$forgot_password_email_error, "Email address must not be empty");
    } else {
        CommonLibrary.hideError(this.$forgot_password_email_error);
    }
    
    if(captcha === null ||captcha === '') {
        valid = false
        CommonLibrary.showError(this.$forgot_password_captcha_error, "Captcha should not be empty");
    } else {
        CommonLibrary.hideError(this.$forgot_password_captcha_error);
    }
    
    return valid;
    
};

Login.prototype.validateForgotPasswordFormInServer = function() {
    this.forgot_password_loading.show();
    $.ajax({
        url: $("#base-url").val() + "/site/request-password-reset",
        type: 'post',
        context: this,
        data: {email: this.getForgotPasswordEmailField(), captcha: this.getForgotPasswordCaptchaField()},
        success: function(data) {
            var parsed = JSON.parse(data);
            if(parsed['status'] === 1) {
                CommonLibrary.hideError(this.$forgot_password_email_error);
                CommonLibrary.hideError(this.$forgot_password_captcha_error);
                this.$forgot_password_submit.addClass('hide');
                this.$forgot_password_validated.removeClass('hide');
            } else {
                var error = parsed['error'];
                if(error['email'] !== undefined) {
                    CommonLibrary.showError(this.$forgot_password_email_error, error['email'][0]);
                }
                
                if(error['captcha'] !== undefined) {
                    CommonLibrary.showError(this.$forgot_password_captcha_error, error['captcha'][0]);
                }
            }
            this.forgot_password_loading.hide();
        }, 
        error: function(data) {
            this.forgot_password_loading.hide();
        }
    });
};

Login.prototype.validateLoginFormInClient = function() {
    var valid = true;
    
    var email = this.getLoginEmailField();
    var password = this.getLoginPasswordField();
    
    if(email === null || email === '') {
        valid = false;
        this.showLoginEmailErrorMsg("Email address must not be empty");
    } else {
        this.hideLoginEmailErrorMsg();
    }
    
    if(password === null || password === '') {
        valid = false;
        this.showLoginPasswordErrorMsg("Password field must not be empty");
    } else {
        this.hideLoginPasswordErrorMsg();
    }
    return valid;
    
};


Login.prototype.validateLoginInServerSide = function() {
    $.ajax({
        url :$("#base-url").val() + "/site/login",
        type: 'post',
        context: this,
        data: { email: this.getLoginEmailField(), password: this.getLoginPasswordField()},
        success: function(data){
            var parsedData = JSON.parse(data);
            if(parsedData['status'] === 0) {
                if('email' in parsedData['message']) {
                    this.showLoginEmailErrorMsg(parsedData['message']['email'][0]);   
                } else {
                    this.showLoginPasswordErrorMsg(parsedData['message']['password'][0]);
                }
            } else {
                this.hideLoginEmailErrorMsg();
                this.hideLoginPasswordErrorMsg();
            }
        }
    });
};

Login.prototype.validateRegisterInServerSide = function() {
    $.ajax({
        url :$("#base-url").val() + "/site/signup",
        type: 'post',
        context: this,
        data: {first_name: this.getRegisterFirstNameField(), last_name: this.getRegisterLastNameField(),
                email: this.getRegisterEmailField(), password: this.getRegisterPasswordField()},
        success: function(data){
            var parsedData = JSON.parse(data);
            if(parsedData['status'] === 0) {
                if('email' in parsedData['message']) {
                    this.showRegisterEmailErrorMsg(parsedData['message']['email'][0]);   
                }
            } else {
                this.hideRegisterEmailErrorMsg();
            }
        }
    });
};


Login.prototype.validateRegisterFormInClient = function() {
    $valid = true;
    var first_name = this.getRegisterFirstNameField();
    var last_name = this.getRegisterLastNameField();
    var email = this.getRegisterEmailField();
    var password = this.getRegisterPasswordField();
    
    if(first_name === null || first_name === '' ) {
        $valid = false;
        this.showRegisterFirstNameErrorMsg("First name should not be empty");
    } else {
        this.hideRegisterFirstNameErrorMsg();
    }
    
    if(!CommonLibrary.validateEmail(email)) {
        $valid = false;
        this.showRegisterEmailErrorMsg("Email address is not valid");
    } else {
        this.hideRegisterEmailErrorMsg();
    }
    
    if(password.length < 6) {
        $valid = false;
        this.showRegisterPasswordErrorMsg("Password should be at least 6 characters");
    } else {
        this.hideRegisterPasswordErrorMsg();
    }
    return $valid;
    
};

Login.prototype.getRegisterFirstNameField = function() {
    return this.$register_first_name_field.val();
};

Login.prototype.getRegisterLastNameField = function() {
    return this.$register_last_name_field.val();
};

Login.prototype.getRegisterEmailField = function() {
    return this.$register_email_field.val();
};


Login.prototype.getRegisterPasswordField = function() {
    return this.$register_password_field.val();
};


Login.prototype.getLoginEmailField = function() {
    return this.$login_email_field.val();
};

Login.prototype.getLoginPasswordField = function() {
    return this.$login_password_field.val();
};

Login.prototype.getForgotPasswordEmailField = function(){
    return this.$forgot_password_email_field.val();
};

Login.prototype.getForgotPasswordCaptchaField = function() {
    return this.$forgot_password_captcha_field.val();
}


Login.prototype.showRegisterFirstNameErrorMsg = function(message) {
   this.$register_first_name_error.html(message);
};

Login.prototype.hideRegisterFirstNameErrorMsg = function() {
   this.$register_first_name_error.html('');
};

Login.prototype.showRegisterEmailErrorMsg = function(message) {
   this.$register_email_error.html(message);
};


Login.prototype.hideRegisterEmailErrorMsg = function() {
   this.$register_email_error.html('');
};

Login.prototype.showRegisterPasswordErrorMsg = function(message) {
   this.$register_password_error.html(message);
};

Login.prototype.hideLoginEmailErrorMsg = function() {
   this.$login_email_error.html('');
};


Login.prototype.hideLoginPasswordErrorMsg = function() {
   this.$login_password_error.html('');
};


Login.prototype.showLoginEmailErrorMsg = function(message) {
   this.$login_email_error.html(message);
};

Login.prototype.showLoginPasswordErrorMsg = function(message) {
   this.$login_password_error.html(message);
};


Login.prototype.hideRegisterPasswordErrorMsg = function() {
   this.$register_password_error.html('');
};

Login.prototype.EVENTS = {
    LOGIN_LOGIN : "login-login",
    LOGIN_FORGOT_PASSWORD : "login-forgot-password",
    LOGIN_REGISTER: "login-register"
};

Login.prototype.triggerLoginEvent = function() {
    this.$root.trigger(this.EVENTS.LOGIN_LOGIN);
};

Login.prototype.triggerRegisterEvent = function() {
    this.$root.trigger(this.EVENTS.LOGIN_REGISTER);
};

Login.prototype.triggerForgotPasswordEvent = function() {
    this.$root.trigger(this.EVENTS.LOGIN_FORGOT_PASSWORD);
}