//pre-loaded
var NotificationList = function($root) {
    this.$root = $root;
    this.id = $root.data('id');
    
    this.$retrieve_loading = null;
    this.retrieve_loading = null;
    this.$retrieve_button = null;
    this.$notif_list_area = null;
    this.$notif_list_items_area = null;
    this.$notif_count = null;
    this.has_retrieved = false;
    this.init();
    this.initEvents();
    
};

NotificationList.prototype.init = function() {
    this.$retrieve_loading = this.$root.find('#' + this.id + "-loading-retrieve-notif");
    this.retrieve_loading = new Loading(this.$retrieve_loading);
    this.$retrieve_button = this.$root.find('.notification-list-retrieve-button');
    this.$notif_list_area = this.$root.find('.notification-list-area');
    this.$notif_list_items_area = this.$root.find('.notification-list-items-area');
    this.$notif_count = this.$root.find('.notification-list-count');
    this.countNewNotif();
    
    
};

NotificationList.prototype.countNewNotif = function() {
    $.ajax({
        url: $("#base-url").val() + "/notification/count-new-notification",
        type: "post",
        context: this,
        success: function(data) {
             var parsed = JSON.parse(data);
             if(parsed['status'] === 1) {
                 this.setCount(parsed['count']);
             }
        }
    });
};

NotificationList.prototype.updateLastSeen = function() {
    $.ajax({
        url: $("#base-url").val() + "/notification/update-last-seen",
        type: "post",
        context: this,
        success: function(data) {
            
        }
    });
};

NotificationList.prototype.retrieveNotification = function() {
    this.retrieve_loading.show();
    this.has_retrieved = true;
    $.ajax({
        url: $("#base-url").val() + "/notification/retrieve-notification",
        type: "post",
        context: this,
        success: function(data) {
            var parsed = JSON.parse(data);
            if(parsed['status'] === 1) {
                this.$notif_list_items_area.html(parsed['views']);
            }
            this.retrieve_loading.hide();
        },
        error: function(data) {
            this.retrieve_loading.hide();
        }
        
    });
};

NotificationList.prototype.initEvents= function() {
    this.$retrieve_button.click(function() {
        if(this.$notif_list_area.hasClass('hide')) {
            this.$notif_list_area.removeClass('hide');
        } else {
            this.$notif_list_area.addClass('hide');
        }
        this.updateLastSeen();
        if(!this.has_retrieved) {
            this.retrieveNotification();
        }
    }.bind(this));
   
};



NotificationList.prototype.setCount= function(count){
    $(this.$retrieve_button).addClass('notification-list-count');
    $(this.$retrieve_button).html("" +count);
};

