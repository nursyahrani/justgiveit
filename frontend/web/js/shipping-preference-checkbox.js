var ShippingPreferenceCheckbox = function($root) { 
    this.$root = $root;
    this.$delivery_area = null;
    this.$delivery_radio = null;
    this.delivery_radio_class = null;
    
    this.$meet_up_area = null;
    this.$meet_up_radio = null;
    this.meet_up_radio_class = null;
    this.init();
    this.initEvents();
};

ShippingPreferenceCheckbox.prototype.init = function() {
    this.delivery_radio_class = 'shipping-preference-checkbox-delivery';
    this.meet_up_radio_class = 'shipping-preference-checkbox-meet-up';
    this.$delivery_area = this.$root.find('.shipping-preference-checkbox-delivery-area');
    this.$delivery_radio = this.$root.find('.' + this.delivery_radio_class);
    this.$meet_up_area = this.$root.find('.shipping-preference-checkbox-meet-up-area');
    this.$meet_up_radio = this.$root.find('.' + this.meet_up_radio_class);
};

ShippingPreferenceCheckbox.prototype.initEvents = function() {
    this.$delivery_area.click(function(e) {
        if(!e.target || !$(e.target).hasClass(this.delivery_radio_class)) {
            
            this.$delivery_radio.click();
        }
    }.bind(this));
    
    this.$meet_up_area.click(function(e) {
        if(!e.target || !$(e.target).hasClass(this.meet_up_radio_class)) {
            this.$meet_up_radio.click();
        }
        
        
    }.bind(this));
};
