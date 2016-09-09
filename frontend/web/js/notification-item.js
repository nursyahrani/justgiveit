var NotificationItem = function($root) {
    this.$root = $root;
    this.id = $root.data('id');
    this.url = $root.data('url');
    this.notification_id = $root.data('notification_id');
    this.click_event_ = null;
    this.init();
    this.initEvents();
    this.initWidgetEvents();
};

NotificationItem.prototype.initEvents = function() {
    $(document).on('click', '#' + this.id, function(e) {
        window.location.href = $("#base-url").val() + "/" +this.url;
        this.sendReadStatus();
        this.triggerClick(); 
        this.removeBlueBackground();
    }.bind(this));
    
};

NotificationItem.prototype.removeBlueBackground = function() {
    $("#" + this.id).removeClass('notification-item-not-read');
}
NotificationItem.prototype.initWidgetEvents = function() {
    this.click_event_ = new CustomEvent(this.EVENTS.NOTIFICATION_ITEM_CLICK);
};

NotificationItem.prototype.sendReadStatus  = function() {
    $.ajax({
        url: $("#base-url").val() + "/notification/set-unread",
        type: "post",
        data: {notification_id: this.notification_id},
        success: function(data) {
            var parsed = JSON.parse(data);
        }
    })
}



NotificationItem.prototype.init = function() {
    
}

NotificationItem.prototype.EVENTS = {
    NOTIFICATION_ITEM_CLICK : "notification_item_click"
}
NotificationItem.prototype.triggerClick = function() {
    this.$root.trigger(this.EVENTS.NOTIFICATION_ITEM_CLICK);
}