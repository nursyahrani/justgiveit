//pre-loaded widget
var QuantityWidget = function($root) {
    this.$root = $root;
    this.max_value = $root.data('max_value');
    this.$plus_button = null;
    this.$minus_button = null;
    this.$input = null;
    
    this.init();
    this.initEvents();
};

QuantityWidget.prototype.init = function() {
    this.$plus_button = this.$root.find('.quantity-widget-plus');
    this.$minus_button = this.$root.find('.quantity-widget-minus');
    this.$input = this.$root.find('.quantity-widget-number-input');
};

QuantityWidget.prototype.initEvents = function() {
    this.$plus_button.click(function(e) {
        this.addOne();
    }.bind(this));
    
    this.$minus_button.click(function(e) {
        this.minusOne();
    }.bind(this));
    
    this.$input.on('input', function(e) {
        var value = parseInt(this.$input.val());
        if(value > this.max_value) {
            this.$input.val(this.max_value);
        }
    }.bind(this));
};

QuantityWidget.prototype.addOne = function() {
    var newValue = parseInt(this.$input.val()) + 1;
    if(newValue <= this.max_value) {
        
        this.$input.val(parseInt(this.$input.val()) + 1);
    }
    
}

QuantityWidget.prototype.minusOne = function() {
    var newValue = parseInt(this.$input.val()) - 1;
    if(newValue >= 0) {
        this.$input.val(newValue);
    }
}

QuantityWidget.prototype.getQuantity = function() {
    return parseInt(this.$input.val());
}