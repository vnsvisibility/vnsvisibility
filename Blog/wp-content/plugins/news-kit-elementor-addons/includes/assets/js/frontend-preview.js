jQuery(document).ready(function($) {
    var nrtl = false
    var ndir = "left"
    if ($('body').hasClass("rtl")) {
        nrtl = true;
        ndir = "right";
    };
    if( window.elementorFrontend ) {
        
        var nonceA = frontendData._wpnonce, ajaxUrlA = frontendData.ajaxUrl
        if( typeof( elementorFrontend.hooks ) != 'undefined' ) {
            // ticker news widget preview
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-ticker-news-one.default', function( $scope, $ ) {
                if( $scope.find(".ticker-item-wrap").length > 0 ) {
                    var duration = $scope.find(".nekit-ticker-news-wrap").data("duration")
                    var tcM = $scope.find( ".ticker-item-wrap" ).marquee({
                        duration: duration,
                        gap: 0,
                        delayBeforeStart: 0,
                        direction: ndir,
                        duplicated: true,
                        startVisible: true,
                        pauseOnHover: true
                    });
                    $scope.on( "click", ".nekit-ticker-pause", function() {
                        $(this).find( "i" ).toggleClass( "fa-pause fa-play" )
                        tcM.marquee( "toggle" );
                    })
                }
            });

            // banner widget one
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-main-banner-one.default', function( $scope, $ ) {
                var bc = $scope.find( ".main-banner-section" );
                if( bc.length ) {
                    var bic = bc.find( ".main-banner-slider" ),
                    sAuto = bic.data( "auto" ),
                    sArrows = bic.data( "arrows" ),
                    sDots = bic.data( "dots" ),
                    sLoop = bic.data( "loop" ),
                    sSpeed = bic.data("speed"),
                    sNextIcon = bic.data("next-icon"),
                    sPrevIcon = bic.data("prev-icon"),
                    sFade = bic.data("fade")
                    bic.slick({
                        dots: sDots,
                        infinite: sLoop,
                        rtl: nrtl,
                        speed: sSpeed,
                        arrows: sArrows,
                        autoplay: sAuto,
                        fade: sFade,
                        nextArrow: `<button type="button" class="slick-next"><i class="` + sNextIcon + `"></i></button>`,
                        prevArrow: `<button type="button" class="slick-prev"><i class="` + sPrevIcon + `"></i></button>`
                    });

                    // banner-tabs
                    var bptc = bc.find( ".main-banner-tabs" )
                    bptc.on( "click", ".banner-tabs li.banner-tab", function() {
                        var _this = $(this), tabItem = _this.attr( "tab-item" );
                        _this.addClass( "active" ).siblings().removeClass( "active" );
                        bptc.find( '.banner-tabs-content div[tab-content="' + tabItem + '"]' ).addClass( "active" ).siblings().removeClass( "active" );
                    })
                }
            })

            // banner widget two
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-main-banner-two.default', function( $scope, $ ) {
                var bc = $scope.find( ".main-banner-section" );
                if( bc.length ) {
                    var bic = bc.find( ".main-banner-slider" ),
                    sAuto = bic.data( "auto" ),
                    sArrows = bic.data( "arrows" ),
                    sDots = bic.data( "dots" ),
                    sLoop = bic.data( "loop" ),
                    sSpeed = bic.data("speed"),
                    sNextIcon = bic.data("next-icon"),
                    sPrevIcon = bic.data("prev-icon"),
                    sFade = bic.data("fade")
                    bic.slick({
                        dots: sDots,
                        infinite: sLoop,
                        rtl: nrtl,
                        speed: sSpeed,
                        arrows: sArrows,
                        autoplay: sAuto,
                        fade: sFade,
                        nextArrow: `<button type="button" class="slick-next"><i class="` + sNextIcon + `"></i></button>`,
                        prevArrow: `<button type="button" class="slick-prev"><i class="` + sPrevIcon + `"></i></button>`
                    });

                    // main banner popular posts slider events
                    var bpc = bc.find( ".popular-posts-wrap" );
                    if( bpc.length ) {
                        var bpcAuto = bpc.data( "auto" )
                        var bpcArrows = bpc.data( "arrows" )
                        var bpcLoop = bic.data( "loop" )
                        var bpcSpeed = bic.data("speed")
                        var bpcVertical = bpc.data( "vertical" );
                        var bpcNextIcon = bpc.data("next-icon")
                        var bpcPrevIcon = bpc.data("prev-icon")
                        if( bpcVertical) {
                            bpc.slick({
                                vertical: bpcVertical,
                                slidesToShow: 4,
                                dots: false,
                                infinite: bpcLoop,
                                arrows: bpcArrows,
                                autoplay: bpcAuto,
                                speed: bpcSpeed,
                                nextArrow: `<button type="button" class="slick-next"><i class="` + bpcNextIcon + `"></i></button>`,
                                prevArrow: `<button type="button" class="slick-prev"><i class="` + bpcPrevIcon + `"></i></button>`
                            })
                        } else {
                            bpc.slick({
                                dots: false,
                                infinite: bpcLoop,
                                arrows: bpcArrows,
                                rtl: nrtl,
                                draggable: true,
                                autoplay: bpcAuto,
                                speed: bpcSpeed,
                                nextArrow: `<button type="button" class="slick-next"><i class="` + bpcNextIcon + `"></i></button>`,
                                prevArrow: `<button type="button" class="slick-prev"><i class="` + bpcPrevIcon + `"></i></button>`
                            })
                        }  
                    }
                }
            })

            // banner widget three
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-main-banner-three.default', function( $scope, $ ) {
                var bc = $scope.find( ".main-banner-section" );
                if( bc.length ) {
                    var bic = bc.find( ".main-banner-slider" ),
                    sAuto = bic.data( "auto" ),
                    sArrows = bic.data( "arrows" ),
                    sDots = bic.data( "dots" ),
                    sLoop = bic.data( "loop" ),
                    sSpeed = bic.data("speed"),
                    sNextIcon = bic.data("next-icon"),
                    sPrevIcon = bic.data("prev-icon"),
                    sFade = bic.data("fade")
                    bic.slick({
                        dots: sDots,
                        infinite: sLoop,
                        rtl: nrtl,
                        speed: sSpeed,
                        arrows: sArrows,
                        autoplay: sAuto,
                        fade: sFade,
                        nextArrow: `<button type="button" class="slick-next"><i class="` + sNextIcon + `"></i></button>`,
                        prevArrow: `<button type="button" class="slick-prev"><i class="` + sPrevIcon + `"></i></button>`
                    });
                }
            })

            // banner widget four
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-main-banner-four.default', function( $scope, $ ) {
                var bc = $scope.find( ".main-banner-section" );
                if( bc.length ) {
                    var bic = bc.find( ".main-banner-slider" ),
                    sAuto = bic.data( "auto" ),
                    sArrows = bic.data( "arrows" ),
                    sDots = bic.data( "dots" ),
                    sLoop = bic.data( "loop" ),
                    sSpeed = bic.data("speed"),
                    sNextIcon = bic.data("next-icon"),
                    sPrevIcon = bic.data("prev-icon"),
                    sFade = bic.data("fade")
                    bic.slick({
                        dots: sDots,
                        infinite: sLoop,
                        rtl: nrtl,
                        speed: sSpeed,
                        arrows: sArrows,
                        autoplay: sAuto,
                        fade: sFade,
                        nextArrow: `<button type="button" class="slick-next"><i class="` + sNextIcon + `"></i></button>`,
                        prevArrow: `<button type="button" class="slick-prev"><i class="` + sPrevIcon + `"></i></button>`
                    });
                }
            })

            // banner widget four
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit_main_banner_four.default', function( $scope, $ ) {
                var bc = $scope.find( ".main-banner-section" );
                if( bc.length ) {
                    var bic = bc.find( ".main-banner-slider" )
                    var bAuto = bic.data( "auto" )
                    var bArrows = bic.data( "arrows" )
                    var bDots = bic.data( "dots" )
                    bic.slick({
                        dots: bDots,
                        infinite: true,
                        rtl: nrtl,
                        arrows: bArrows,
                        autoplay: bAuto,
                        nextArrow: `<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>`,
                        prevArrow: `<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>`
                    });
                }
            })

            // news carousel widget one
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-news-carousel-one.default', function( $scope, $ ) {
                var nc = $scope.find( ".news-carousel .news-carousel-post-wrap" );
                if( nc.length ) {
                    var ncDots= nc.data("dots") == '1'
                    var ncLoop= nc.data("loop") == '1'
                    var ncArrows= nc.data("arrows") == '1'
                    var ncAuto  = nc.data("auto") == '1'
                    var ncSpeed  = nc.data("speed")
                    var ncColumns  = nc.data("columns")
                    var ncColumnsTablet  = nc.data("columns-tablet")
                    var ncColumnsMobile  = nc.data("columns-mobile")
                    var ncPrevIcon  = nc.data("prev-icon")
                    var ncNextIcon  = nc.data("next-icon")
                    var ncFade  = nc.data("fade") == '1'
                    nc.slick({
                        dots: ncDots,
                        infinite: ncLoop,
                        arrows: ncArrows,
                        autoplay: ncAuto,
                        speed: ncSpeed,
                        rtl: nrtl,
                        slidesToShow: ncColumns,
                        fade: ncFade,
                        nextArrow: `<button type="button" class="slick-next"><i class="` + ncNextIcon + `"></i></button>`,
                        prevArrow: `<button type="button" class="slick-prev"><i class="` + ncPrevIcon + `"></i></button>`,
                        responsive: [
                            {
                                breakpoint: 769,
                                settings: {
                                    slidesToShow: ncColumnsTablet
                                }
                            },
                            {
                                breakpoint: 640,
                                settings: {
                                    slidesToShow: ncColumnsMobile
                                }
                            }
                        ]
                    })
                }
            })

            // news carousel widget two
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-news-carousel-two.default', function( $scope, $ ) {
                var nc = $scope.find( ".news-carousel .news-carousel-post-wrap" );
                if( nc.length ) {
                    var ncLoop= nc.data("loop") == '1'
                    var ncArrows= nc.data("arrows") == '1'
                    var ncAuto  = nc.data("auto") == '1'
                    var ncColumns  = nc.data("columns")
                    var ncSpeed  = nc.data("speed")
                    var ncColumnsTablet  = nc.data("columns-tablet")
                    var ncColumnsMobile  = nc.data("columns-mobile")
                    var ncPrevIcon  = nc.data("prev-icon")
                    var ncNextIcon  = nc.data("next-icon")
                    var ncFade  = nc.data("fade") == '1'
                    nc.slick({
                        dots: false,
                        infinite: ncLoop,
                        arrows: ncArrows,
                        autoplay: ncAuto,
                        rtl: nrtl,
                        speed: ncSpeed,
                        slidesToShow: ncColumns,
                        fade: ncFade,
                        nextArrow: `<button type="button" class="slick-next"><i class="` + ncNextIcon + `"></i></button>`,
                        prevArrow: `<button type="button" class="slick-prev"><i class="` + ncPrevIcon + `"></i></button>`,
                        responsive: [
                            {
                                breakpoint: 769,
                                settings: {
                                    slidesToShow: ncColumnsTablet,
                                },
                            },
                            {
                                breakpoint: 640,
                                settings: {
                                    slidesToShow: ncColumnsMobile,
                                },
                            }
                        ]
                    })
                }
            })

            // news carousel widget three
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-news-carousel-three.default', function( $scope, $ ) {
                var nc = $scope.find( ".news-carousel .news-carousel-post-wrap" );
                if( nc.length ) {
                    var ncDots= nc.data("dots") == '1'
                    var ncLoop= nc.data("loop") == '1'
                    var ncArrows= nc.data("arrows") == '1'
                    var ncAuto  = nc.data("auto") == '1'
                    var ncColumns  = nc.data("columns")
                    var ncSpeed  = nc.data("speed")
                    var ncColumnsTablet  = nc.data("columns-tablet")
                    var ncColumnsMobile  = nc.data("columns-mobile")
                    var ncPrevIcon  = nc.data("prev-icon")
                    var ncNextIcon  = nc.data("next-icon")
                    var ncFade  = nc.data("fade") == '1'
                    nc.slick({
                        dots: ncDots,
                        infinite: ncLoop,
                        arrows: ncArrows,
                        autoplay: ncAuto,
                        rtl: nrtl,
                        speed: ncSpeed,
                        slidesToShow: ncColumns,
                        fade: ncFade,
                        nextArrow: `<button type="button" class="slick-next"><i class="` + ncNextIcon + `"></i></button>`,
                        prevArrow: `<button type="button" class="slick-prev"><i class="` + ncPrevIcon + `"></i></button>`,
                        responsive: [
                            {
                                breakpoint: 769,
                                settings: {
                                    slidesToShow: ncColumnsTablet,
                                }
                            },
                            {
                                breakpoint: 640,
                                settings: {
                                    slidesToShow: ncColumnsMobile,
                                }
                            }
                        ]
                    })
                }
            })

            // news carousel widget three
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-back-to-top.default', function( $scope, $ ) {
                var btTop = $scope.find( ".nekit-back-to-top-wrap.widget-position--fixed" );
                if( btTop.length ) {
                    btTop.hide()
                    var showAt = btTop.data("show")
                    $(window).scroll(function() {
                        if ( $(this).scrollTop() > showAt ) {
                            btTop.show();
                        } else {
                            btTop.hide();
                        }
                    });

                    btTop.click(function() {
                        // Animate the scrolling motion.
                        $("html, body").animate({scrollTop:0},"slow");
                    })
                }
            })

            // news carousel widget three
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-live-search.default', function( $scope, $ ) {
                // on search trigger click
                if( $scope.find( '.nekit-live-search-widget' ).hasClass('trigger-form-onclick') ) {
                    $( '.nekit-search-form-wrap' ).hide()
                    $scope.on( "click", ".search-trigger", function() {
                        var _this = $(this)
                        _this.next().slideToggle()
                    })
                }

                // on search key type
                if( $scope.hasClass("search-type--live-search") ) {
                    var searchFormContainer = $scope.find("form"), dataSettings = $scope.find('input[type="hidden"]').val()
                    $scope.on( "change, keyup", '.nekit-search-form-wrap form input[type="search"]', function() {
                        var _this = $(this), searchKey = _this.val()
                        if( searchKey.trim() != '' ) {
                            $.ajax({
                                method: 'post',
                                url: ajaxUrlA,
                                data: {
                                    action: 'nekit_live_search_widget_posts_content',
                                    search_key : searchKey.trim(),
                                    dataSettings: dataSettings,
                                    _wpnonce: nonceA
                                },
                                beforeSend: function() {
                                    searchFormContainer.addClass( 'retrieving-posts' );
                                    searchFormContainer.removeClass( 'results-loaded' )
                                },
                                success : function(res) {
                                    var parsedRes = res.data
                                    $scope.find(".search-results-wrap").remove()
                                    searchFormContainer.after(parsedRes.posts)
                                    searchFormContainer.removeClass( 'retrieving-posts' ).addClass( 'results-loaded' );
                                },
                                complete: function() {
                                    // double check the search key value
                                    var searchFieldCurrentVal = $scope.find('.nekit-search-form-wrap form input[type="search"]').val()
                                    if( searchFieldCurrentVal.trim() == '' ) {
                                        $scope.find(".search-results-wrap").remove()
                                        searchFormContainer.removeClass( 'retrieving-posts results-loaded' );
                                    }
                                }
                            })
                        } else {
                            $scope.find(".search-results-wrap").remove()
                            searchFormContainer.removeClass( 'retrieving-posts results-loaded' )
                        }
                    })
                }
            })

            // site nav mega menu widget 
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit_site_nav_mega_menu.default', function( $scope, $ ) {
                var datSectionContainer = $scope.find(".news-elementor-nav-mega-menu.nav-mega-menu-wrap")
                if( datSectionContainer.length > 0 ) {
                    datSectionContainer.each(function() {
                        var megaMenuContainerItem = $(this), toMobileMenu = megaMenuContainerItem.data("mobile")
                        if( ! ( $(window).width() > toMobileMenu ) ) {
                            megaMenuContainerItem.addClass("isResponsiveMenu")
                            megaMenuContainerItem.on( "click", ".responsive-menu-trigger", function() {
                                $(this).next().toggleClass("isShow")
                            })
                        } else {
                            megaMenuContainerItem.removeClass("isResponsiveMenu")
                        }

                         // handle sub menu dropdown
                        var menuItemWithSubmenu = megaMenuContainerItem.find( ".nekit-nav-mega-menu-list-wrap .nekit-has-mega-menu" )
                        if( menuItemWithSubmenu.length == 0 ) return;
                        var menuItemWithSubmenuInnerElm = menuItemWithSubmenu.find("> a");
                        var parentIconHasSubmenuClosed = megaMenuContainerItem.data("dropdown"), parentIconHasSubmenuOpened = megaMenuContainerItem.data("upside"), parentIconPosition = megaMenuContainerItem.data("dropdown-position")
                        if( parentIconPosition == 'before' ) {
                            if( parentIconHasSubmenuClosed != 'no-icon' && menuItemWithSubmenuInnerElm.find("i").length == 0 ) menuItemWithSubmenuInnerElm.prepend('<i class="' + parentIconHasSubmenuClosed + ' "></i>')
                        } else {
                            if( parentIconHasSubmenuClosed != 'no-icon' && menuItemWithSubmenuInnerElm.find("i").length == 0 ) menuItemWithSubmenuInnerElm.append('<i class="' + parentIconHasSubmenuClosed + ' "></i>')
                        }

                        // handle click and hover submenu show hide
                        if( menuItemWithSubmenuInnerElm.parent().hasClass("appear-event--click") ) {
                            menuItemWithSubmenuInnerElm.click(function(e) {
                                e.preventDefault()
                                menuItemWithSubmenuInnerElm.next().toggleClass("isShow")
                                if( parentIconHasSubmenuOpened != 'no-icon' ) $(this).find("i").toggleClass( parentIconHasSubmenuClosed + " " + parentIconHasSubmenuOpened )
                            })
                        } else {
                            menuItemWithSubmenuInnerElm.parent().hover(function() {
                                menuItemWithSubmenuInnerElm.next().toggleClass("isShow")
                                if( parentIconHasSubmenuOpened != 'no-icon' ) $(this).find("i").toggleClass( parentIconHasSubmenuClosed + " " + parentIconHasSubmenuOpened )
                            })
                        }
                    })
                }
            })

            // date and time widget 
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-date-and-time.default', function( $scope, $ ) {
                var datSectionContainer = $scope.find(".date-and-time-wrap")
                if( datSectionContainer.length > 0 ) {
                    var datDataFormat = datSectionContainer.data("format")
                    setInterval(function() {
                        datSectionContainer.find(".time-count").html(new Date().toLocaleTimeString())
                    },1000);
                }
            })

            //theme mode widget
            elementorFrontend.hooks.addAction( 'frontend/element_ready/theme_mode.default', function( $scope, $ ) {
                var tmSectionContainer = $scope.find('.theme-mode-wrap')
                if( tmSectionContainer.length > 0 ){
                    tmSectionContainer.click(function(){
                        var _this = $(this)
                        if( _this.hasClass("light-mode--on") ){
                            _this.removeClass("light-mode--on").addClass("dark-mode--on")
                            $(".theme-mode").parents('body').toggleClass('nekit_dark_mode')
                        }else if(_this.hasClass("dark-mode--on")){
                            _this.removeClass("dark-mode--on").addClass("light-mode--on")
                            $(".theme-mode").parents('body').toggleClass('nekit_dark_mode')
                        }
                    })
                }
            })

            // full width banner widget
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-full-width-banner.default', function( $scope, $ ) {
                var fwbSectionContainer = $scope.find('.nekit-full-width-banner-wrap')
                if( fwbSectionContainer.length > 0 ){
                    var _this = $(document).find('.nekit-full-width-banner-wrap')
                    var fwbArrows = fwbSectionContainer.data('arrow')
                    var fwbAutoplay  = fwbSectionContainer.data('autoplay')
                    var fwbFade  = fwbSectionContainer.data('fade')
                    var fwbInfinite  = fwbSectionContainer.data('infinite')
                    var fwbSpeed = fwbSectionContainer.data('speed')
                    var fwbAutoplaySpeed = fwbSectionContainer.data('autoplayspeed')
                    var fwbCenterMode = fwbSectionContainer.data('centermode')
                    var fwbCenterPadding = fwbSectionContainer.data('centerpadding') + 'px'
                    var fwbprevArrow = fwbSectionContainer.data('prevarrow')
                    var fwbnextArrow = fwbSectionContainer.data('nextarrow')
                    fwbSectionContainer.slick({
                        arrows: fwbArrows,
                        autoplay: fwbAutoplay,
                        autoplaySpeed: fwbAutoplaySpeed,
                        fade: fwbFade,
                        infinite: fwbInfinite,
                        speed: fwbSpeed,
                        centerMode: fwbCenterMode,
                        centerPadding: fwbCenterPadding,
                        nextArrow: `<button type="button" class="slick-next"><i class="`+ fwbnextArrow +`"></i></button>`,
                        prevArrow: `<button type="button" class="slick-prev"><i class="`+ fwbprevArrow +`"></i></button>`
                    })
                }
            })

            // categories collection widget
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-categories-collection.default', function($scope,$) {
                var ccSectionContainer = $scope.find('.carousel-active')
                if( ccSectionContainer.length > 0 ) {
                    var ccArrows = ccSectionContainer.data('arrows')
                    var ccAutoplay = ccSectionContainer.data('autoplay')
                    var ccAutoplaySpeed = ccSectionContainer.data('autoplayspeed')
                    var ccFade = ccSectionContainer.data('fade')
                    var ccInfinite = ccSectionContainer.data('infinite')
                    var ccSpeed = ccSectionContainer.data('speed')
                    var ccSlidesToShow = ccSectionContainer.data('slidestoshow')
                    var ccPrevArrow = ccSectionContainer.data('prev')
                    var ccNextArrow = ccSectionContainer.data('next')
                    var ccMobile = ccSectionContainer.data('mobile')
                    var ccTablet = ccSectionContainer.data('tablet')
                    ccFade = ( ccSlidesToShow == 1 && ccFade)
                    ccSectionContainer.slick({
                        arrows: ccArrows,
                        autoplay: ccAutoplay,
                        autoplaySpeed: ccAutoplaySpeed,
                        fade: ccFade,
                        infinite: ccInfinite,
                        speed: ccSpeed,
                        slidesToShow: ccSlidesToShow,
                        prevArrow: '<button type="button" class="slick-prev"><i class="' + ccPrevArrow + '"></i></button>',
                        nextArrow: '<button type="button" class="slick-next"><i class="' + ccNextArrow + '"></i></button>',
                        responsive: [
                            {
                                breakpoint: 769,
                                settings: {
                                    slidesToShow: ccTablet,
                                },
                            },
                            {
                                breakpoint: 640,
                                settings: {
                                slidesToShow: ccMobile,
                                },
                            }
                        ]
                    })
                }
            });

            // news timeline widget
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-news-timeline.default', function( $scope, $ ) {
                var ntSectionContainer = $scope.find('.nekit-news-timeline-wrap')
                if( ntSectionContainer.length > 0 ) {
                    ntSectionContainer.each(function() {
                        var _this = $(this) , sectionOffset = Math.round( _this.offset().top ) , windowHeight = $( window ).height()
                        var windowScrolled = $( window ).scrollTop() , sectionHeight = _this.height()
                        var color = _this.data('color'), defaultColor = _this.data('defaultcolor')
                        if( sectionOffset < ( windowHeight / 2 ) ) { // handle the script if section visible on load
                            var barHeight = ( windowHeight / 2 )
                            _this.find(".timeline-fixed-bar .progress-bar").css("height",barHeight)
                            // fill the icon color on progress bar scroll
                            var polylineIcon = _this.find(".post-item .polyline-icon")
                            polylineIcon.each(function() {
                                var iconElm = $(this), iconOffset = iconElm.offset().top, iconHeightWithSectionTop = iconOffset - sectionOffset
                                if( barHeight > iconHeightWithSectionTop ) {
                                    $(this).css("color",color)
                                } else {
                                    $(this).css("color",defaultColor)
                                }
                            })
                        }
                        $( window ).on("scroll",function() {
                            color = _this.data('color')
                            sectionOffset = Math.round( _this.offset().top )
                            windowHeight = $( window ).height()
                            windowScrolled = $( window ).scrollTop()
                            sectionHeight = _this.height()
                            if( ( ( sectionOffset - windowScrolled ) - ( windowHeight / 2 ) ) <= 50  ){      //Section Reached
                                var barHeight = Math.abs(Math.round( ( sectionOffset - windowScrolled ) - ( windowHeight / 2 ) ))
                                _this.find(".timeline-fixed-bar .progress-bar").css("height",barHeight)
                                if( barHeight > sectionHeight ){
                                    barHeight = Math.abs(Math.round( sectionHeight ))
                                    _this.find(".timeline-fixed-bar .progress-bar").css("height",barHeight)
                                }
                                if($(window).scrollTop() + $(window).height() == $(document).height()){
                                    barHeight = Math.abs(Math.round( sectionHeight ))
                                    _this.find(".timeline-fixed-bar .progress-bar").css("height",barHeight)    
                                }
            
                                // fill the icon color on progress bar scroll
                                var polylineIcon = _this.find(".post-item .polyline-icon")
                                polylineIcon.each(function() {
                                    var iconElm = $(this), iconOffset = iconElm.offset().top, iconHeightWithSectionTop = iconOffset - sectionOffset
                                    if( barHeight > iconHeightWithSectionTop ) {
                                        $(this).css("color",color)
                                    } else {
                                        $(this).css("color",defaultColor)
                                    }
                                })
                            } else {
                                barHeight = Math.abs(Math.round( 0 ))
                                _this.find(".timeline-fixed-bar .progress-bar").css("height",barHeight)
                            }
                        })
                    })
                }
            })

            // mega menu widget
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-site-nav-mega-menu.default', function( $scope, $ ) {
                var megaMenuContainerItem = $scope.find('.news-elementor-nav-mega-menu')
                if( megaMenuContainerItem.length > 0 ) {
                    var toMobileMenu = megaMenuContainerItem.data("mobile")
                    megaMenuHandler.addSubmenuDropdownIcon(megaMenuContainerItem) // handle sub menu dropdown
                    if( ! ( $(window).width() > toMobileMenu ) ) {
                        megaMenuContainerItem.addClass("isResponsiveMenu")
                        megaMenuContainerItem.on( "click", ".responsive-menu-trigger", function() {
                            var _this = $(this)
                            var burgerMenuType = _this.data("type")
                            var burgerMenuIcon = _this.data("open")
                            var burgerMenuCloseIcon = _this.data("close")
                            if( burgerMenuType == 'icon' ) {
                                _this.find("i").toggleClass( burgerMenuIcon + ' ' + burgerMenuCloseIcon )
                            } else {
                                if( $.trim(_this.text().toLowerCase()) == $.trim(burgerMenuCloseIcon).toLowerCase() ) {
                                    _this.text( burgerMenuIcon )
                                } else {
                                    _this.text( burgerMenuCloseIcon )
                                }
                            }
                            _this.next().toggleClass("isShow")
                        })
                    } else {
                        megaMenuContainerItem.removeClass("isResponsiveMenu")
                    }
                }
            })

            const megaMenuHandler = {
                addSubmenuDropdownIcon: function(megaMenuContainerItem) {
                    var menuItemWithSubmenu = megaMenuContainerItem.find( ".nekit-nav-mega-menu-list-wrap > .nekit-has-mega-menu, .nekit-nav-mega-menu-list-wrap > .nekit-has-sub-menu" )
                    if( menuItemWithSubmenu.length == 0 ) return;
                    menuItemWithSubmenu.each(function() {
                        var parentMenuItemWithSubmenuInnerElm = $(this).find("> a");
                        var menuItemWithSubmenuInnerElm = $(this).find(".nekit-sub-menu .nekit-has-sub-menu > a");
                        var parentIconHasSubmenuClosed = megaMenuContainerItem.data("parent-dropdown"), parentIconHasSubmenuOpened = megaMenuContainerItem.data("parent-upside"), parentIconChildHasSubmenuClosed = megaMenuContainerItem.data("dropdown"), parentIconChildHasSubmenuOpened = megaMenuContainerItem.data("upside"), parentIconPosition = megaMenuContainerItem.data("dropdown-position")
                        if( parentIconPosition == 'before' ) {
                            if( parentIconHasSubmenuClosed != 'no-icon' && parentMenuItemWithSubmenuInnerElm.find("i.nekit-indicator-menu-icon").length == 0 ) parentMenuItemWithSubmenuInnerElm.prepend('<i class="nekit-indicator-menu-icon ' + parentIconHasSubmenuClosed + ' "></i>')
                            if( parentIconChildHasSubmenuClosed != 'no-icon' && menuItemWithSubmenuInnerElm.find("i.nekit-indicator-menu-icon").length == 0 ) menuItemWithSubmenuInnerElm.prepend('<i class="nekit-indicator-menu-icon ' + parentIconChildHasSubmenuClosed + ' "></i>')
                        } else {
                            if( parentIconHasSubmenuClosed != 'no-icon' && parentMenuItemWithSubmenuInnerElm.find("i.nekit-indicator-menu-icon").length == 0 ) parentMenuItemWithSubmenuInnerElm.append('<i class="nekit-indicator-menu-icon ' + parentIconHasSubmenuClosed + ' "></i>')
                            if( parentIconChildHasSubmenuClosed != 'no-icon' && menuItemWithSubmenuInnerElm.find("i.nekit-indicator-menu-icon").length == 0 ) menuItemWithSubmenuInnerElm.append('<i class="nekit-indicator-menu-icon ' + parentIconChildHasSubmenuClosed + ' "></i>')
                        }
                        
                        // handle click and hover submenu show hide - on parent first menu items
                        if( parentMenuItemWithSubmenuInnerElm.parent().hasClass("appear-event--click") || ( parentMenuItemWithSubmenuInnerElm.parent().hasClass("nekit-has-sub-menu") && parentMenuItemWithSubmenuInnerElm.parents(".news-elementor-nav-mega-menu").hasClass("nekit-submenu-onmouse-click") ) ) {
                            parentMenuItemWithSubmenuInnerElm.on("click",function(e) {
                                e.preventDefault()
                                parentMenuItemWithSubmenuInnerElm.next().toggleClass("isShow")
                                if( parentMenuItemWithSubmenuInnerElm.next().hasClass("close-event--outside-click") ) scriptHandlers.handleSubmenuClose(parentMenuItemWithSubmenuInnerElm.next())
                                if( parentIconChildHasSubmenuOpened != 'no-icon' ) $(this).find("i.nekit-indicator-menu-icon").toggleClass( parentIconHasSubmenuClosed + " " + parentIconHasSubmenuOpened )
                            })
                        } else {
                            parentMenuItemWithSubmenuInnerElm.parent().hover(function() {
                                parentMenuItemWithSubmenuInnerElm.next().toggleClass("isShow")
                                if( parentIconChildHasSubmenuOpened != 'no-icon' ) $(this).find("i.nekit-indicator-menu-icon").toggleClass( parentIconHasSubmenuClosed + " " + parentIconHasSubmenuOpened )
                            })
                        }
        
                        // handle click and hover submenu show hide - on child sub menu with child items
                        if( menuItemWithSubmenuInnerElm.parent().hasClass("appear-event--click") || ( menuItemWithSubmenuInnerElm.parent().hasClass("nekit-has-sub-menu") && menuItemWithSubmenuInnerElm.parents(".news-elementor-nav-mega-menu").hasClass("nekit-submenu-onmouse-click") ) ) {
                            menuItemWithSubmenuInnerElm.on("click",function(e) {
                                e.preventDefault()
                                menuItemWithSubmenuInnerElm.next().toggleClass("isShow")
                                if( menuItemWithSubmenuInnerElm.next().hasClass("close-event--outside-click") ) scriptHandlers.handleSubmenuClose(menuItemWithSubmenuInnerElm.next())
                                if( parentIconChildHasSubmenuOpened != 'no-icon' ) $(this).find("i.nekit-indicator-menu-icon").toggleClass( parentIconChildHasSubmenuClosed + " " + parentIconChildHasSubmenuOpened )
                            })
                        } else {
                            menuItemWithSubmenuInnerElm.parent().hover(function() {
                                menuItemWithSubmenuInnerElm.next().toggleClass("isShow")
                                if( parentIconChildHasSubmenuOpened != 'no-icon' ) $(this).find("i.nekit-indicator-menu-icon").toggleClass( parentIconChildHasSubmenuClosed + " " + parentIconChildHasSubmenuOpened )
                            })
                        }
                    }) // for each meta item with mega menu
                }
            }

            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-single-table-of-content.default', function( $scope, $ ){
                var TocSectionContainer = $scope.find(".nekit-single-table-of-content")
                if( TocSectionContainer.length > 0 ) {
                    $.fn.isInViewport = function() {
                        var elementTop = $(this).offset();
                        var elementBottom = elementTop + $(this).outerHeight();
                        var viewportTop = $(window).scrollTop();
                        var viewportBottom = viewportTop + $(window).height();
                        return elementBottom > viewportTop && elementTop < viewportBottom;
                    }
            
                    TocSectionContainer.each(function() {
                        const _this = $(this)
                        const containerToRender = $(this).find(".table-of-content-list-wrap")
                        const tocHandler = {
                            init: function() {
                                this.headingTags = []
                                this.listItemPointer = 0
                                this.headingsToLook = _this.data('anchor')
                                this.headingsMarker = _this.data('marker')
                                this.headingsView = _this.data('view')
                                this.noHeadingsFoundHide = ( _this.data('hide') == 'true' )
                                this.noHeadingsFoundText = _this.data('text')
                                var contentContainer = $(document).find('.nekit-single-content')
                                this.headingNodes = contentContainer.find(this.headingsToLook)
                                this.handleContentToggle()
                                this.handleToggle()
                                if( this.headingNodes.length > 0 ) {
                                    this.getAllHeadingNodes()
                                    this.createHeadingTreeView()
                                    this.onAnchorRedirect()
                                    this.highlightAnchor()
                                } else {
                                    if( this.noHeadingsFoundHide ) {
                                        _this.remove()           
                                    } else {
                                        containerToRender.html( this.noHeadingsFoundText );
                                    }
                                }
                            },
                            highlightAnchor() {
                                $(window).scroll(function() {
                                    let tocHeadings = $(document).find(".nekit-single-table-of-content .toc-list-item")
                                    for( let i = 0 ; i < tocHeadings.length; i++) {
                                        if( $(tocHandler.headingNodes[i]).isInViewport() ) {
                                            $(tocHeadings[i]).addClass("active").siblings().removeClass("active")
                                        }
                                    }
                                });
                            },
                            onAnchorRedirect: function() {
                                $(document).on( "click", ".nekit-single-table-of-content .toc-heading-title a", function(e) {
                                    var hashLink = $(this).attr("href").replace("#","")
                                    $("html, body").animate({
                                        scrollTop: $("#" + hashLink ).offset().top - 50
                                    }, "slow")
                                    e.preventDefault()
                                })
                            },
                            getAllHeadingNodes: function() {
                                this.headingNodes.each((index,element) => {
                                    // add anchor point for each heading
                                    $(element).before('<span id="nekit-toc-heading-anchor--' + index + '" class="nekit-toc-menu-anchor"></span>');
                                    let anchorLink = 'nekit-toc-heading-anchor--' + index
                                    // generate the stack of heading tags
                                    this.headingTags.push({
                                        tag: +element.nodeName.slice(1),
                                        text: element.textContent,
                                        anchorLink
                                    });
                                })
                            },
                            createHeadingTreeView: function() {
                                this.headingTags.forEach((heading, index) => {
                                    heading.level = 0;
                                    for (let i = index - 1; i >= 0; i--) {
                                        const currentOrderedItem = this.headingTags[i];
                                        if (currentOrderedItem.tag <= heading.tag) {
                                            heading.level = currentOrderedItem.level;
                                            if (currentOrderedItem.tag < heading.tag) {
                                                heading.level++;
                                            }
                                            break;
                                        }
                                    }
                                });
                                if( this.headingsView == 'tree' ) {
                                    containerToRender.html(this.getTreeHtml(0));
                                } else {
                                    containerToRender.html(this.getFlatHtml());
                                }
                                if( this.headingsMarker == 'number' ) {
                                    var tocContent = containerToRender.find(" > .toc-list-item-wrap")
                                    this.giveNumbering(tocContent)
                                }
                            },
                            giveNumbering: function(tocContent, numberingString = '') {
                                var tocList = tocContent.find( " > .toc-list-item" )
                                if( tocList.length > 0 ) {
                                    tocList.each(function(index) {
                                        var _this = $(this), newNumberingString = '<span class="numbering-prefix">' + numberingString + (index + 1).toString() + '.</span>'
                                        _this.find(" > .toc-heading-title a").prepend(newNumberingString)
                                        var tocInnerContent = _this.find(" > .toc-list-item-wrap")
                                        if(tocInnerContent.length > 0) tocHandler.giveNumbering(tocInnerContent,newNumberingString)
                                    })
                                }
                            },
                            getTreeHtml: function(level) {
                                // generate list wrap
                                let html = `<ul class="toc-list-item-wrap">`;
                                // For each list item, build its markup.
                                var levelCount = 1;
                                while (this.listItemPointer < this.headingTags.length) {
                                    const currentItem = this.headingTags[this.listItemPointer];
                                    if (level > currentItem.level) {
                                        break;
                                    }
                                    if (level === currentItem.level) {
                                        html += `<li class="toc-list-item">`;
                                        html += `<span class="toc-heading-title"><a href="#${currentItem.anchorLink}">`;
                                        let liContent = `${currentItem.text}`;
                                        html += liContent;
                                        html += '</a></span>';
                                        this.listItemPointer++;
                                        const nextItem = this.headingTags[this.listItemPointer];
                                        if (nextItem && level < nextItem.level) {
                                            html += this.getTreeHtml(nextItem.level);
                                        }
                                        html += '</li>';
                                    }
                                    levelCount++;
                                }
                                html += `</ul>`;
                                return html;
                            },
                            getFlatHtml: function() {
                                // generate list wrap
                                let html = `<ul class="toc-list-item-wrap">`;
                                // For each list item, build its markup.
                                var levelCount = 0;
                                while (levelCount < this.headingTags.length) {
                                    const currentItem = this.headingTags[levelCount];
                                    html += `<li class="toc-list-item">`;
                                    html += `<span class="toc-heading-title"><a href="#${currentItem.anchorLink}">`;
                                    let liContent = `${currentItem.text}`;
                                    html += liContent;
                                    html += '</a></span>';
                                    html += '</li>';
                                    levelCount++;
                                }
                                html += `</ul>`;
                                return html;
                            },
                            handleContentToggle: function() {
                                _this.on( "click", ".toc-content-toggle-button", function() {
                                    var contentToggleButton = $(this), minimizedIcon = contentToggleButton.data("minimized"), maximizedIcon = contentToggleButton.data("maximized")
                                    containerToRender.slideToggle(400, function() {
                                        contentToggleButton.find("i").toggleClass( minimizedIcon + ' ' + maximizedIcon )
                                    })
                                })
                            },
                            handleToggle: function() {
                                _this.on( "click", ".toc-toggle-button", function() {
                                    var contentToggleButton = $(this), minimizedIcon = contentToggleButton.data("minimized"), maximizedIcon = contentToggleButton.data("maximized")
                                    _this.find(".table-of-content-wrap").slideToggle(400, function() {
                                        contentToggleButton.find("i").toggleClass( minimizedIcon + ' ' + maximizedIcon )
                                    })
                                })
                            }
                        }
                        tocHandler.init()
                    })
                }
            })

            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-ticker-news-two.default', function( $scope, $ ) {
                var tnTwoSectionContainer = $scope.find('.nekit-ticker-news-two')
                if( tnTwoSectionContainer.length > 0 ) {
                    var classToAddSlick = tnTwoSectionContainer.find('.ticker-item-wrap')
                    var arrow = tnTwoSectionContainer.data('arrows')
                    var autoplay = tnTwoSectionContainer.data('autoplay')
                    var autoplaySpeed = tnTwoSectionContainer.data('autoplay-speed')
                    var speed = tnTwoSectionContainer.data('speed')
                    var fade = tnTwoSectionContainer.data('fade')
                    var infinite = tnTwoSectionContainer.data('infinite')
                    var sliderNextArrow = tnTwoSectionContainer.data('nextarrow')
                    var sliderPreviousArrow = tnTwoSectionContainer.data('previousarrow')
                    var nextArrow = ''
                    var previousArrow = ''
                    var sliderVertical = ( fade == true ) ? false : tnTwoSectionContainer.data('vertical')
                    nextArrow = ( tnTwoSectionContainer.data('nextarrow') == '' ) ? '' : `<button type="button" class="slick-next"><i class="` + sliderNextArrow + `"></i></button>` 
                    previousArrow = ( tnTwoSectionContainer.data('previousarrow') == '' ) ? '' : `<button type="button" class="slick-prev"><i class="` + sliderPreviousArrow + `"></i></button>` 
                    classToAddSlick.slick({
                        infinite: infinite,
                        arrows: arrow,
                        autoplay: autoplay,
                        speed: speed,
                        fade: fade,
                        autoplaySpeed: autoplaySpeed, 
                        nextArrow: nextArrow,
                        prevArrow: previousArrow,
                        vertical: sliderVertical
                    })
                }
            })

            // main banner one script handler
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-main-banner-five.default', function( $scope, $ ) {
                var mbSectionContainer = $scope.find(".main-banner-section")
                if( mbSectionContainer.length > 0 ) {
                    mbSectionContainer.each(function() {
                        var _this = $(this), bannerItemsWrap = _this.find(".main-banner-slider"), bannerItemsTabsWrap = _this.find( ".main-banner-tabs" )
                        var sAuto = bannerItemsWrap.data("auto"),
                        sArrows = bannerItemsWrap.data("arrows"),
                        sDots = bannerItemsWrap.data("dots"),
                        sLoop = bannerItemsWrap.data("loop"),
                        sSpeed = bannerItemsWrap.data("speed"),
                        sNextIcon = bannerItemsWrap.data("next-icon"),
                        sPrevIcon = bannerItemsWrap.data("prev-icon")
                        sFade = bannerItemsWrap.data("fade")
                        bannerItemsWrap.slick({
                            dots: sDots,
                            arrows: sArrows,
                            autoplay: sAuto,
                            infinite: sLoop,
                            speed: sSpeed,
                            rtl: nrtl,
                            fade: sFade,
                            nextArrow: `<button type="button" class="slick-next"><i class="` + sNextIcon + `"></i></button>`,
                            prevArrow: `<button type="button" class="slick-prev"><i class="` + sPrevIcon + `"></i></button>`
                        });
                    })
                }
            })
            
            // New filter one
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-news-filter-one.default', function( $scope, $ ) {
                var nnfSectionContainer = $scope.find(".nekit-filter-widget")
                if( nnfSectionContainer.length > 0 ) {
                    nnfSectionContainer.each(function() {
                        var $scope = $(this)
                        var adjustLayout =$(this) .data("adjustlayout")
                        if( adjustLayout == 'on' ) {
                            var onBurgerIconClick = $(this).find(".tab-title-wrap")
                            onBurgerIconClick.hide()
                            var preloadedActiveTabTitle = onBurgerIconClick.find('.isActive').text()
                            $scope.find( '.active-tab' ).text( preloadedActiveTabTitle )
                            $scope.on('click', '.burger-icon', function() {
                                var _this = $(this)
                                _this.next().toggle()
                            })
                        }
                        $scope.on("click", ".filter-tab-wrapper .tab-title", function() {
                            var _this = $(this)
                            var activeTabTitle = _this.text()
                            _this.parents('.filter-tab-wrapper').find( '.active-tab' ).text( activeTabTitle )
                            if( _this.hasClass( 'isActive' ) ) return
                            if( _this.parents( '.nekit-filter-widget' ).hasClass( 'adjust-layout--on' ) ) {
                                _this.parents('.tab-title-wrap').hide()
                            }
                        })
                    })
                }
            })

            //News Filter Two
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-news-filter-two.default', function( $scope, $ ) {
                var nnfSectionContainer = $scope.find(".nekit-filter-widget")
                if( nnfSectionContainer.length > 0 ) {
                    nnfSectionContainer.each(function() {
                        var $scope = $(this)
                        var adjustLayout =$(this) .data("adjustlayout")
                        if( adjustLayout == 'on' ) {
                            var onBurgerIconClick = $(this).find(".tab-title-wrap")
                            onBurgerIconClick.hide()
                            var preloadedActiveTabTitle = onBurgerIconClick.find('.isActive').text()
                            $scope.find( '.active-tab' ).text( preloadedActiveTabTitle )
                            $scope.on('click', '.burger-icon', function() {
                                var _this = $(this)
                                _this.next().toggle()
                            })
                        }
                        $scope.on("click", ".filter-tab-wrapper .tab-title", function() {
                            var _this = $(this)
                            var activeTabTitle = _this.text()
                            _this.parents('.filter-tab-wrapper').find( '.active-tab' ).text( activeTabTitle )
                            if( _this.hasClass( 'isActive' ) ) return
                            if( _this.parents( '.nekit-filter-widget' ).hasClass( 'adjust-layout--on' ) ) {
                                _this.parents('.tab-title-wrap').hide()
                            }
                        })
                    })
                }
            })

            //News Fitler Three
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-news-filter-three.default', function( $scope, $ ) {
                var nnfSectionContainer = $scope.find(".nekit-filter-widget")
                if( nnfSectionContainer.length > 0 ) {
                    nnfSectionContainer.each(function() {
                        var $scope = $(this)
                        var adjustLayout =$(this).data("adjustlayout")
                        if( adjustLayout == 'on' || $(window).width() <= 540 ) {
                            var onBurgerIconClick = $(this).find(".tab-title-wrap")
                            var preloadedActiveTabTitle = onBurgerIconClick.find('.isActive').text()
                            $scope.find( '.active-tab' ).text( preloadedActiveTabTitle )
                            $scope.on('click', '.burger-icon', function() {
                                var _this = $(this)
                                _this.next().toggle()
                            })
                        }
                        $scope.on("click", ".filter-tab-wrapper .tab-title", function() {
                            var _this = $(this)
                            var activeTabTitle = _this.text()
                            _this.parents('.filter-tab-wrapper').find( '.active-tab' ).text( activeTabTitle )
                            if( _this.hasClass( 'isActive' ) ) return
                            if( _this.parents( '.nekit-filter-widget' ).hasClass( 'adjust-layout--on' ) ) {
                                _this.parents('.tab-title-wrap').hide()
                            }
                        })
                    })
                }
            })

            //News Filter Four
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-news-filter-four.default', function( $scope, $ ) {
                var nnfSectionContainer = $scope.find(".nekit-filter-widget")
                if( nnfSectionContainer.length > 0 ) {
                    nnfSectionContainer.each(function() {
                        var $scope = $(this)
                        var adjustLayout =$(this) .data("adjustlayout")
                        if( adjustLayout == 'on' ) {
                            var onBurgerIconClick = $(this).find(".tab-title-wrap")
                            onBurgerIconClick.hide()
                            var preloadedActiveTabTitle = onBurgerIconClick.find('.isActive').text()
                            $scope.find( '.active-tab' ).text( preloadedActiveTabTitle )
                            $scope.on('click', '.burger-icon', function() {
                                var _this = $(this)
                                _this.next().toggle()
                            })
                        }
                        $scope.on("click", ".filter-tab-wrapper .tab-title", function() {
                            var _this = $(this)
                            var activeTabTitle = _this.text()
                            _this.parents('.filter-tab-wrapper').find( '.active-tab' ).text( activeTabTitle )
                            if( _this.hasClass( 'isActive' ) ) return
                            if( _this.parents( '.nekit-filter-widget' ).hasClass( 'adjust-layout--on' ) ) {
                                _this.parents('.tab-title-wrap').hide()
                            }
                        })
                    })
                }
            })

            // social share widget
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-social-share.default', function( $scope, $ ) {
                var socialShareContainer = $scope.find( '.nekit-social-share' )    
                if( socialShareContainer.length > 0 ) {
                    if( socialShareContainer.hasClass( 'social-share--on' ) ) {
                        var socialSharePrefix = socialShareContainer.find( '.social-share-prefix' )
                        socialSharePrefix.on( 'click', function(){
                            var _this = $(this)
                            _this.siblings().toggleClass( 'isactive' )
                        })
                    }
                }
            })
            
            // canvas menu widget
            elementorFrontend.hooks.addAction( 'frontend/element_ready/nekit-canvas-menu.default', function( $scope, $ ) {
                $scope.on( "click", ".canvas-content-trigger", function() {
                    var _innerThis = $(this)
                    _innerThis.next().toggleClass( "isShow" )
                    $('body').toggleClass("nekit-canvas-menu-overlay")
                })
                $(document).mouseup(function (e) {
                    var container = $scope.find( ".canvas-menu-content" );
                    if (!container.is(e.target) && container.has(e.target).length === 0) {
                        $scope.find( ".canvas-menu-content" ).removeClass("isShow")
                        $('body').removeClass("nekit-canvas-menu-overlay")
                    }
                })
            })
        }
    }
})