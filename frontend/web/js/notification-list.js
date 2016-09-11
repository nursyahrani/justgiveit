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
    this.$see_all_button = null;
    this.$no_more=  null;
    this.notification_items = [];
    this.init();
    this.initEvents();
};

NotificationList.prototype.init = function() {
    this.$retrieve_loading = this.$root.find('#' + this.id + "-loading-retrieve-notif");
    this.retrieve_loading = new Loading(this.$retrieve_loading);
    this.$retrieve_button = this.$root.find('.notification-list-retrieve-button');
    this.$notif_list_area = this.$root.find('.notification-list-area');
    this.$notif_list_items_area = this.$root.find('.notification-list-items-area');
    this.$no_more = this.$root.find('.notification-list-no-more-notification'); 
    this.$notif_count = this.$root.find('.notification-list-count');
    this.$see_all_button = this.$root.find('.notification-list-see-all-button');
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
                 if(parseInt(parsed['count']) !== 0) {
                     this.setCount(parsed['count']);
                     
                 }
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
            var parsed = JSON.parse(data);
            if(parsed['status'] === 1) {
                this.removeCount();
            }
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
                if(parsed['views'] === '' || parsed['views'] === null) {
                    this.$no_more.removeClass('hide');
                } else {
                    this.$notif_list_items_area.html(parsed['views']);
                    $(parsed['views']).filter('.notification-item').each(function(index, value){
                        this.notification_items.push(new NotificationItem($(value)));
                    }.bind(this));
                }
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

    $("body").on('click', function(e) {
        if(e.target && ($(e.target).closest("#" + this.id).length === 0)) {
            this.$notif_list_area.addClass('hide');
        }
    }.bind(this));
    
    $(document).on('click', '#' + this.id, function(e) {
        if(e.target && $(e.target).closest('.notification-item').length !== 0 ) {
            this.$notif_list_area.addClass('hide');
        }
    }.bind(this));
};



NotificationList.prototype.setCount= function(count){
    $(this.$retrieve_button).addClass('notification-list-count');
    $(this.$retrieve_button).html("" +count);
};

NotificationList.prototype.removeCount = function() {
    $(this.$retrieve_button).removeClass('notification-list-count');
    this.$retrieve_button.html("<span class=\"glyphicon glyphicon-bell\"></span>");
}
