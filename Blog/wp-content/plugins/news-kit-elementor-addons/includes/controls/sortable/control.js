jQuery(window).on("elementor:init", (function() {
    "use strict";
    
    var radioImageControl = elementor.modules.controls.BaseData.extend({
        onReady: function() {
            var $this = this, element = $this.$el
            jQuery(element).find( ".control-content-wrapper" ).sortable({
                orientation: "vertical",
                items: "> .sort-item",
                update: function (event, ui) {
                    var items = jQuery(element).find( ".control-content-wrapper .sort-item" ), newValue = []
                    items.each(function() {
                        newValue.push(jQuery(this).data("value"))
                    })
                    $this.setValue(newValue);
                }
            })
        },
        onBeforeDestroy: function() {
        }
    });
    elementor.addControlView("sortable-control", radioImageControl)
}));