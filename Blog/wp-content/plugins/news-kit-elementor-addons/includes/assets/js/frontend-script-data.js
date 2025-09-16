var nekitWidgetData = []

jQuery(function($) {
    if( ! frontendDataSource.isElementorPreview && frontendDataSource.preloader != 'none' ) {
        $(window).on("load",function() {
        	
            var preloaderElm = $("#nekit-preloader-elm")
            if( frontendDataSource.preloaderExitAnimation != 'none' ) {
                preloaderElm.addClass( "nekit-animated-exit-" + frontendDataSource.preloaderExitAnimation )
            } else {
                preloaderElm.hide()
            }
            setTimeout(function() {
                preloaderElm.remove()
            }, 5000)
            
        })
    }
})