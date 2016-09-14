var ConfirmationModal = function($root) {
    this.id = $root.data('id');
    this.$root = $root;
    
    this.ok_class = null;
    this.cancel_class = null;
    this.text_class = null;
    this.ok_event = null;
    this.cancel_event = null;
    this.init();
    this.initEvents();
    this.initWidgetEvents();
};
ConfirmationModal.prototype.EVENTS = {
    CONFIRMATION_MODAL_OK : "confirmation-modal-ok",
    CONFIRMATION_MODAL_CANCEL : "confirmation-modal-cancel"
}
ConfirmationModal.prototype.init = function() {
    this.ok_class = 'confirmation-modal-ok';
    this.cancel_class = 'confirmation-modal-cancel';
    this.text_class  = 'modal-body';
};

ConfirmationModal.prototype.initEvents = function() {
    $(document).on('click', '#' + this.id, function(e) {
        if(e.target && $(e.target).hasClass(this.ok_class)) {
            this.triggerOkEvent();
        } else if(e.target && $(e.target).hasClass(this.cancel_class)) {
            this.triggerCancelEvent();
        }
    }.bind(this));
};

ConfirmationModal.prototype.initWidgetEvents = function() {
    this.ok_event = new CustomEvent(this.EVENTS.CONFIRMATION_MODAL_OK);
    this.cancel_event = new CustomEvent(this.EVENTS.CONFIRMATION_MODAL_CANCEL);
};

ConfirmationModal.show = function(text, callback) {
    var $root = $("#" + 'confirmation-modal');
    var root = new ConfirmationModal($root);
    
    root.setText(text);
    root.show();
    $root.on(ConfirmationModal.prototype.EVENTS.CONFIRMATION_MODAL_OK, function(e) {
        callback(true);
        root.hideAndDelete();
    }.bind(this));
    
    $root.on(ConfirmationModal.prototype.EVENTS.CONFIRMATION_MODAL_CANCEL, function(e) {
        root.hideAndDelete();
    }.bind(this));
};

ConfirmationModal.prototype.setText = function(text) {
    $("#" + this.id).find('.' + this.text_class).html(text);

};

ConfirmationModal.prototype.hideAndDelete = function() {
    $("#" + this.id).modal('hide');
    $(document).off('click', '#' + this.id);


};

ConfirmationModal.prototype.hide = function() {
    $("#" + this.id).modal('hide');
}
ConfirmationModal.prototype.show = function() {
    $("#" + this.id).modal('show');

};

ConfirmationModal.prototype.triggerOkEvent = function() {
    $("#" + this.id).trigger(this.EVENTS.CONFIRMATION_MODAL_OK);
};

ConfirmationModal.prototype.triggerCancelEvent = function() {
    $("#" + this.id).trigger(this.EVENTS.CONFIRMATION_MODAL_CANCEL);
}