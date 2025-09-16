jQuery( window ).on( "elementor:init", (function() {
    "use strict";
    
    var numberSelectControl = elementor.modules.controls.BaseData.extend({
        onReady: function() {
            var $this = this, element = $this.$el
            var newValue = {
                'number': element.find( '.control-content-wrapper .nekit-input-field' ).val(),
                'select': element.find( '.control-content-wrapper .nekit-select-field' ).val()
            }
            /* Input field change */
            jQuery(element).on( "change", ".control-content-wrapper .nekit-input-field", function() {
                var _this = jQuery( this ), val = _this.val()
                newValue = {
                    ...newValue, 
                    'number': val
                }
                $this.setValue({ ...newValue, 'number': val });
            })
            /* Select field change */
            jQuery(element).on( "change", ".control-content-wrapper .nekit-select-field", function() {
                var _this = jQuery( this ), val = _this.val() 
                newValue = {
                    ...newValue, 
                    'select': val
                }
                $this.setValue({ ...newValue, 'select': val });
                if( val === 'none' ) {
                    _this.siblings().hide()
                } else {
                    _this.siblings().show()
                }
            })
        },
        onBeforeDestroy: function() {}
    });
    elementor.addControlView( "nekit-number-select-control", numberSelectControl )
}));