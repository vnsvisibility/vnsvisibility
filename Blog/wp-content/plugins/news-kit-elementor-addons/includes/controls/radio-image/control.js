jQuery(window).on("elementor:init", (function() {
    "use strict";
    
    var radioImageControl = elementor.modules.controls.BaseData.extend({
        onReady: function() {
            var $this = this, element = $this.$el
            jQuery(element).on( "click", ".control-content-wrapper > div", function() {
                var _this = jQuery(this)
                _this.addClass("isActive").siblings().removeClass("isActive")
                $this.setValue( _this.data("value") );
            })
        },
        onBeforeDestroy: function() {
        }
    });
    elementor.addControlView("nekit-radio-image-control", radioImageControl)
}));