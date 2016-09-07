/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var Login = function($root) {
    this.$root = $root;
    this.$register_with_email_button = null;
    this.$go_to_login_button = null;
    this.$login_panel = null;
    this.$register_panel = null;
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
    this.$go_to_login_button = this.$root.find('.login-register-login');
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
    
    //login error
    this.$login_email_error = this.$root.find('.login-login-email-error');
    this.$login_password_error = this.$root.find('.login-login-password-error');
    
    //register error
    this.$register_first_name_error = this.$root.find('.login-register-first-name-error');
    this.$register_email_error = this.$root.find('.login-register-email-error');
    this.$register_password_error = this.$root.find('.login-register-password-error');
    var self = this;
    
    this.$login_with_facebook = this.$root.find('.login-continue-with-facebook');
    //get json
    $.getJSON('http://ip-api.com/json', function(data) {
        self.country_code = data['countryCode'];
        self.city  = data['city'];
        self.country = data['country'];
    });
    
};

Login.prototype.initEvents = function() {
    var self = this;
    this.$register_with_email_button.click(function(e){
        this.triggerRegisterEvent();
        self.$register_panel.removeClass('login-hide');
        self.$login_panel.addClass('login-hide');
    }.bind(this));
    
    this.$go_to_login_button.click(function(e){
        this.triggerLoginEvent();
        self.$register_panel.addClass('login-hide');
        self.$login_panel.removeClass('login-hide');
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


Login.prototype.validateLoginFormInClient = function() {
    $valid = true;
    
    var email = this.getLoginEmailField();
    var password = this.getLoginPasswordField();
    
    if(email === null || email === '') {
        $valid = false;
        this.showLoginEmailErrorMsg("Email address must not be empty");
    } else {
        this.hideLoginEmailErrorMsg();
    }
    
    if(password === null || password === '') {
        $valid = false;
        this.showLoginPasswordErrorMsg("Password field must not be empty");
    } else {
        this.hideLoginPasswordErrorMsg();
    }
    return $valid;
    
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
                email: this.getRegisterEmailField(), password: this.getRegisterPasswordField(),
            country: this.country, country_code: this.country_code, city: this.city},
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
    LOGIN_REGISTER: "login-register"
};

Login.prototype.triggerLoginEvent = function() {
    this.$root.trigger(this.EVENTS.LOGIN_LOGIN);
};

Login.prototype.triggerRegisterEvent = function() {
    this.$root.trigger(this.EVENTS.LOGIN_REGISTER);
};