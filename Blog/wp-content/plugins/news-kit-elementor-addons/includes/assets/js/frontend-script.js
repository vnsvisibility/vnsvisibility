// script handlers here
jQuery(document).ready(function($) {
    "use strict"
    var nrtl = false
    var ndir = "left"
    if ($('body').hasClass("rtl")) {
        nrtl = true;
        ndir = "right";
    };
    var loaderElm = '<div class="nekit-loader"><div class="loader-wrap"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>'
    
    var newsTickerContainer = $(".nekit-ticker-news-wrap")
    if( newsTickerContainer.length > 0 ) {
        newsTickerContainer.each(function() {
            var duration = $(this).data("duration")
            var tcM = $(this).find( ".ticker-item-wrap" ).marquee({
                duration: duration,
                gap: 0,
                delayBeforeStart: 0,
                direction: ndir,
                duplicated: true,
                startVisible: true,
                pauseOnHover: true
            });
            $(this).on( "click", ".nekit-ticker-pause", function() {
                $(this).find( "i" ).toggleClass( "fa-pause fa-play" )
                tcM.marquee( "toggle" );
            })
        })
    }

    var nonceA = frontendData._wpnonce, ajaxUrlA = frontendData.ajaxUrl
    var widgetContainer = $(".nekit-widget-block.slider-container")
    if( widgetContainer.length > 0 ) {
        widgetContainer.each(function() {
            var innerContainer = $(this).find(".widget-inner")
            var columnD = innerContainer.data("column-desktop")
            var columnT = innerContainer.data("column-tablet")
            var columnM = innerContainer.data("column-mobile")
            var direction = ( innerContainer.data("slide-direction") == 'vertical')
            var auto = ( innerContainer.data("slide-auto") == 'yes')
            var arrows = ( innerContainer.data("slide-controller") == 'yes')
            var infinite = ( innerContainer.data("slide-infinite") == 'yes')
            var slidesToScroll = innerContainer.data("slide-number")
            var speed = innerContainer.data("slide-speed")
            innerContainer.slick({
                infinite: infinite,
                vertical: direction,
                dots: false,
                autoplay: auto,
                arrows: arrows,
                slidesToShow: columnD,
                slidesToScroll: slidesToScroll,
                speed: speed,
                nextArrow: `<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>`,
                prevArrow: `<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>`,
                responsive: [
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: columnT,
                            slidesToScroll: slidesToScroll
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: columnM,
                            slidesToScroll: slidesToScroll
                        }
                    }
                ]
            })
        })
    }

    // back to top widget script
    var btTop = $( ".nekit-back-to-top-wrap" );
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

    // live search widget
    var liveSearchContainer = $(".nekit-live-search-widget.live-search-wrap")
    if( liveSearchContainer.length > 0 ) {
        liveSearchContainer.each(function() {
            var currentElem = $(this), widgetId = currentElem.parents('.elementor-widget[data-element_type="widget"]').data("id"), dataSettings = JSON.stringify( nekitWidgetData[widgetId] )
            // on live search trigger click
            if( currentElem.hasClass("trigger-form-onclick") ) {
                currentElem.on( "click", ".search-trigger .search-icon-wrap", function() {
                    var _this = $(this)
                    _this.parent().next().toggle()
                    _this.parent().next().find('input[type="search"]').focus()
                    $(".nekit-search-form-wrap").on( "click", ".close-modal", function() {
                        $(this).parent().hide()
                    })
                    $(document).mouseup(function (e) {
                        var searchModalContainer = $(".nekit-search-form-wrap");
                        if (!searchModalContainer.is(e.target) && searchModalContainer.has(e.target).length === 0) {
                            searchModalContainer.hide()
                        };
                    })
                })
            }
            // on search key type
            if( currentElem.hasClass("search-type--live-search") ) {
                // close search results on outside click
                $(document).mouseup(function (e) {
                    var searchResultModalContainer = $(".search-results-wrap");
                    if ( !searchResultModalContainer.is(e.target) && searchResultModalContainer.has(e.target).length === 0) {
                        searchResultModalContainer.hide()
                    };
                })

                var searchFormContainer = currentElem.find("form")
                currentElem.on( "change, keyup", '.nekit-search-form-wrap form input[type="search"]', function() {
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
                                currentElem.find(".search-results-wrap").remove()
                                searchFormContainer.after(parsedRes.posts)
                                searchFormContainer.removeClass( 'retrieving-posts' ).addClass( 'results-loaded' );
                            },
                            complete: function() {
                                // double check the search key value
                                var searchFieldCurrentVal = currentElem.find('.nekit-search-form-wrap form input[type="search"]').val()
                                if( searchFieldCurrentVal.trim() == '' ) {
                                    currentElem.find(".search-results-wrap").remove()
                                    searchFormContainer.removeClass( 'retrieving-posts results-loaded' );
                                }
                            }
                        })
                    } else {
                        currentElem.find(".search-results-wrap").remove()
                        searchFormContainer.removeClass( 'retrieving-posts results-loaded' )
                    }
                })
            }
        })
    }

    // date and time widget
    var datSectionContainer = $(".date-and-time-wrap")
    if( datSectionContainer.length > 0 ) {
        setTimeout(function() {
            datSectionContainer.find(".time-count").html(new Date().toLocaleTimeString())
        },1000);
    }
    
    // mega menu script handler
    $(window).resize(function() {
        scriptHandlers.megaMenuWidget()
    });

    const scriptHandlers = {
        init: function() {
            this.megaMenuWidget()
            this.navMenuWidget()
        },
        megaMenuWidget: function() {
            var megaMenuContainer = $(".news-elementor-nav-mega-menu")
            if( megaMenuContainer.length > 0 ) {
                megaMenuContainer.each(function() {
                    var megaMenuContainerItem = $(this), toMobileMenu = megaMenuContainerItem.data("mobile")
                    scriptHandlers.addSubmenuDropdownIcon(megaMenuContainerItem) // handle sub menu dropdown
                    if( ! ( $(window).width() > toMobileMenu ) ) {
                        megaMenuContainerItem.addClass("isResponsiveMenu")
                        megaMenuContainerItem.on( "click", ".responsive-menu-trigger", function() {
                            var _this = $(this)
                            _this.addClass("nekit-hamburger-open");
                            _this.next().addClass("isShow")
                            $('body').addClass("nekit-mega-menu-overlay")
                            scriptHandlers.onElementOutsideClick(_this.next(), function() {
                                _this.next().removeClass("isShow")
                                _this.removeClass("nekit-hamburger-open");
                                $('body').removeClass("nekit-mega-menu-overlay")
                            })
                        })
                    } else {
                        megaMenuContainerItem.removeClass("isResponsiveMenu")
                    }
                    scriptHandlers.handleResponsiveMenu(megaMenuContainerItem) // handle sub menu dropdown
                })
            }
        },
        navMenuWidget: function() {
            var megaMenuContainer = $(".news-elementor-nav-menu")
            if( megaMenuContainer.length > 0 ) {
                megaMenuContainer.each(function() {
                    var megaMenuContainerItem = $(this), toMobileMenu = megaMenuContainerItem.data("mobile")
                    scriptHandlers.addNavSubmenuDropdownIcon(megaMenuContainerItem) // handle sub menu dropdown
                    if( ! ( $(window).width() > toMobileMenu ) ) {
                        megaMenuContainerItem.addClass("isResponsiveMenu")
                        megaMenuContainerItem.on( "click", ".responsive-menu-trigger", function() {
                            var _this = $(this)
                            _this.toggleClass("nekit-hamburger-open");
                            _this.next().toggleClass("isShow")
                            $('body').addClass("nekit-menu-overlay")
                            scriptHandlers.onElementOutsideClick(_this.next(), function() {
                                _this.next().removeClass("isShow")
                                _this.toggleClass("nekit-hamburger-open");
                                $('body').removeClass("nekit-menu-overlay")
                            })
                        })
                    } else {
                        megaMenuContainerItem.removeClass("isResponsiveMenu")
                    }
                    scriptHandlers.handleNavResponsiveMenu(megaMenuContainerItem) // handle sub menu dropdown
                })
            }
        },
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
                        $(this).next().toggleClass("isShow")
                        if( $(this).next().hasClass("close-event--outside-click") ) scriptHandlers.handleSubmenuClose($(this).next())
                        if( parentIconChildHasSubmenuOpened != 'no-icon' ) $(this).find("i.nekit-indicator-menu-icon").toggleClass( parentIconHasSubmenuClosed + " " + parentIconHasSubmenuOpened )
                        // close other sub menu 
                        var siblingsMenuItem = $(this).parent( ".nekit-has-sub-menu, .nekit-has-mega-menu" ).siblings( ".nekit-has-sub-menu, .nekit-has-mega-menu" )
                        if( siblingsMenuItem.length > 0 ) {
                            siblingsMenuItem.find(".nekit-sub-menu, .nekit-mega-menu-container").removeClass("isShow")
                        }
                    })
                } else {
                    parentMenuItemWithSubmenuInnerElm.hover(function() {
                        if( parentIconChildHasSubmenuOpened != 'no-icon' ) $(this).find(" > i.nekit-indicator-menu-icon").toggleClass( parentIconHasSubmenuClosed + " " + parentIconHasSubmenuOpened )
                        // close other sub menu
                        var siblingsMenuItem = $(this).parent( ".nekit-has-sub-menu, .nekit-has-mega-menu" ).siblings( ".nekit-has-sub-menu, .nekit-has-mega-menu" )
                        if( siblingsMenuItem.length > 0 ) {
                            siblingsMenuItem.find(".nekit-sub-menu, .nekit-mega-menu-container").removeClass("isShow")
                        }
                    })
                }

                // handle click and hover submenu show hide - on child sub menu with child items
                if( menuItemWithSubmenuInnerElm.parent().hasClass("appear-event--click") || ( menuItemWithSubmenuInnerElm.parent().hasClass("nekit-has-sub-menu") && menuItemWithSubmenuInnerElm.parents(".news-elementor-nav-mega-menu").hasClass("nekit-submenu-onmouse-click") ) ) {
                    menuItemWithSubmenuInnerElm.on("click",function(e) {
                        e.preventDefault()
                        $(this).next().toggleClass("isShow")
                        if( menuItemWithSubmenuInnerElm.next().hasClass("close-event--outside-click") ) scriptHandlers.handleSubmenuClose(menuItemWithSubmenuInnerElm.next())
                        if( parentIconChildHasSubmenuOpened != 'no-icon' ) $(this).find("i.nekit-indicator-menu-icon").toggleClass( parentIconChildHasSubmenuClosed + " " + parentIconChildHasSubmenuOpened )
                        // close other sub menu 
                        var siblingsMenuItem = $(this).parent( ".nekit-has-sub-menu" ).siblings( ".nekit-has-sub-menu" )
                        if( siblingsMenuItem.length > 0 ) {
                            siblingsMenuItem.find(".nekit-sub-menu").removeClass("isShow")
                        }
                    })
                } else {
                    menuItemWithSubmenuInnerElm.hover(function() {
                        if( parentIconChildHasSubmenuOpened != 'no-icon' ) $(this).find(" > i.nekit-indicator-menu-icon").toggleClass( parentIconChildHasSubmenuClosed + " " + parentIconChildHasSubmenuOpened )
                    })
                }
            }) // for each meta item with mega menu
        },
        addNavSubmenuDropdownIcon: function(megaMenuContainerItem) {
            var menuItemWithSubmenu = megaMenuContainerItem.find( ".nekit-nav-menu-list-wrap > .nekit-has-sub-menu" )
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
                if( parentMenuItemWithSubmenuInnerElm.parent().hasClass("appear-event--click") || ( parentMenuItemWithSubmenuInnerElm.parent().hasClass("nekit-has-sub-menu") && parentMenuItemWithSubmenuInnerElm.parents(".news-elementor-nav-menu").hasClass("nekit-submenu-onmouse-click") ) ) {
                    parentMenuItemWithSubmenuInnerElm.on("click",function(e) {
                        e.preventDefault()
                        $(this).next().toggleClass("isShow")
                        if( $(this).next().hasClass("close-event--outside-click") ) scriptHandlers.handleSubmenuClose($(this).next())
                        if( parentIconChildHasSubmenuOpened != 'no-icon' ) $(this).find("i.nekit-indicator-menu-icon").toggleClass( parentIconHasSubmenuClosed + " " + parentIconHasSubmenuOpened )
                        // close other sub menu 
                        var siblingsMenuItem = $(this).parent( ".nekit-has-sub-menu" ).siblings( ".nekit-has-sub-menu" )
                        if( siblingsMenuItem.length > 0 ) {
                            siblingsMenuItem.find(".nekit-sub-menu, .nekit-menu-container").removeClass("isShow")
                        }
                    })
                } else {
                    parentMenuItemWithSubmenuInnerElm.hover(function() {
                        if( parentIconChildHasSubmenuOpened != 'no-icon' ) $(this).find(" > i.nekit-indicator-menu-icon").toggleClass( parentIconHasSubmenuClosed + " " + parentIconHasSubmenuOpened )
                        // close other sub menu
                        var siblingsMenuItem = $(this).parent( ".nekit-has-sub-menu" ).siblings( ".nekit-has-sub-menu" )
                        if( siblingsMenuItem.length > 0 ) {
                            siblingsMenuItem.find(".nekit-sub-menu, .nekit-menu-container").removeClass("isShow")
                        }
                    })
                }

                // handle click and hover submenu show hide - on child sub menu with child items
                if( menuItemWithSubmenuInnerElm.parent().hasClass("appear-event--click") || ( menuItemWithSubmenuInnerElm.parent().hasClass("nekit-has-sub-menu") && menuItemWithSubmenuInnerElm.parents(".news-elementor-nav-menu").hasClass("nekit-submenu-onmouse-click") ) ) {
                    menuItemWithSubmenuInnerElm.on("click",function(e) {
                        e.preventDefault()
                        $(this).next().toggleClass("isShow")
                        if( menuItemWithSubmenuInnerElm.next().hasClass("close-event--outside-click") ) scriptHandlers.handleSubmenuClose(menuItemWithSubmenuInnerElm.next())
                        if( parentIconChildHasSubmenuOpened != 'no-icon' ) $(this).find("i.nekit-indicator-menu-icon").toggleClass( parentIconChildHasSubmenuClosed + " " + parentIconChildHasSubmenuOpened )
                        // close other sub menu 
                        var siblingsMenuItem = $(this).parent( ".nekit-has-sub-menu" ).siblings( ".nekit-has-sub-menu" )
                        if( siblingsMenuItem.length > 0 ) {
                            siblingsMenuItem.find(".nekit-sub-menu").removeClass("isShow")
                        }
                    })
                } else {
                    menuItemWithSubmenuInnerElm.hover(function() {
                        if( parentIconChildHasSubmenuOpened != 'no-icon' ) $(this).find(" > i.nekit-indicator-menu-icon").toggleClass( parentIconChildHasSubmenuClosed + " " + parentIconChildHasSubmenuOpened )
                    })
                }
            }) // for each meta item with mega menu
        },
        handleResponsiveMenu: function(megaMenuContainerItem) {
            if( ! megaMenuContainerItem.hasClass("isResponsiveMenu") ) return;
            var canvasHeaderIcon = megaMenuContainerItem.data("dropdown-header-icon")
            megaMenuContainerItem.on("click", ".nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap .nekit-has-mega-menu >a", function(e) {
                e.preventDefault()
                var _this = $(this), menuItem = _this.parent()
                var currentMenuLabel = _this.text()
                var toShowContainer = menuItem.find(" > .nekit-mega-menu-container")
                if( ! megaMenuContainerItem.hasClass( "mobile-menu-dropdown-sub-menu-display-type--default" ) ) {
                    toShowContainer.prepend('<div class="header">' + canvasHeaderIcon + '<span class="header-label">' + currentMenuLabel + '</span></div>')
                }
                toShowContainer.toggleClass("current-responsive-active-menu-content")
            })

            megaMenuContainerItem.on("click", ".nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap .nekit-has-sub-menu > a", function(e) {
                e.preventDefault()
                var _this = $(this), menuItem = _this.parent()
                var currentMenuLabel = _this.text()
                var toShowContainer = menuItem.find(" > .nekit-sub-menu")
                if( ! megaMenuContainerItem.hasClass( "mobile-menu-dropdown-sub-menu-display-type--default" ) ) {
                    toShowContainer.prepend('<div class="header">' + canvasHeaderIcon + '<span class="header-label">' + currentMenuLabel + '</span></div>')
                }
                toShowContainer.toggleClass("current-responsive-active-menu-content")
            })

            // navigate back to the previous menu
            megaMenuContainerItem.on( "click", ".nekit-nav-mega-menu-container .nekit-nav-mega-menu-list-wrap .current-responsive-active-menu-content .header", function(e) {
                e.preventDefault()
                $(this).parent().removeClass("current-responsive-active-menu-content")
                $(this).remove()
            })
        },
        handleNavResponsiveMenu: function(navMenuContainerItem) {
            if( ! navMenuContainerItem.hasClass("isResponsiveMenu") ) return;
            var canvasHeaderIcon = navMenuContainerItem.data("dropdown-header-icon")
            navMenuContainerItem.on("click", ".nekit-nav-menu-container .nekit-nav-menu-list-wrap .nekit-has-sub-menu > a", function(e) {
                e.preventDefault()
                var _this = $(this), menuItem = _this.parent()
                var currentMenuLabel = _this.text()
                var toShowContainer = menuItem.find(" > .nekit-sub-menu")
                if( ! navMenuContainerItem.hasClass( "mobile-menu-dropdown-sub-menu-display-type--default" ) ) {
                    toShowContainer.prepend('<div class="header">' + canvasHeaderIcon + '<span class="header-label">' + currentMenuLabel + '</span></div>')
                }
                toShowContainer.toggleClass("current-responsive-active-menu-content")
            })

            // navigate back to the previous menu
            navMenuContainerItem.on( "click", ".nekit-nav-menu-container .nekit-nav-menu-list-wrap .current-responsive-active-menu-content .header", function(e) {
                e.preventDefault()
                $(this).parent().removeClass("current-responsive-active-menu-content")
                $(this).remove()
            })
        },
        handleSubmenuClose: function(currentSubmenu) {
            scriptHandlers.onElementOutsideClick(currentSubmenu, function() {
                currentSubmenu.removeClass("isShow")
            })
        },
        onElementOutsideClick: function(currentElement, callback) {
            $(document).mouseup(function (e) {
                var container = $(currentElement);
                if (!container.is(e.target) && container.has(e.target).length === 0) callback();
            })
        }
    }
    scriptHandlers.init()

    // theme mode widget
    var tmSectionContainer = $('.nekit-theme-mode')
    if( tmSectionContainer.length > 0 ) {
        tmSectionContainer.click(function() {
            var _this = $(this)
            if( _this.hasClass("light-mode--on") ) {
                _this.removeClass("light-mode--on").addClass("dark-mode--on")
                $(".theme-mode").parents('body').toggleClass('nekit_dark_mode')
                $.cookie( "nekitThemeMode", "dark", { path: '/' } );
            } else if(_this.hasClass("dark-mode--on")) {
                _this.removeClass("dark-mode--on").addClass("light-mode--on")
                $(".theme-mode").parents('body').toggleClass('nekit_dark_mode')
                $.cookie( "nekitThemeMode", "light", { path: '/' } );
            }
        })
    }
    
    // full width banner Widget
    var fwbSectionContainer = $('.nekit-full-width-banner-wrap')
    if( fwbSectionContainer.length > 0 ){
        fwbSectionContainer.each(function(){
            var _this = $(this)
            var fwbArrows = _this.data('arrow')
            var fwbAutoplay  = _this.data('autoplay')
            var fwbAutoplay  = _this.data('autoplay')
            var fwbFade  = _this.data('fade')
            var fwbInfinite  = _this.data('infinite')
            var fwbSpeed = _this.data('speed')
            var fwbAutoplaySpeed = _this.data('autoplayspeed')
            var fwbCenterMode = _this.data('centermode')
            var fwbCenterPadding = _this.data('centerpadding') + 'px'
            var fwbprevArrow = _this.data('prevarrow')
            var fwbnextArrow = _this.data('nextarrow')
            $(this).slick({
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
        })
    }
    
    // categories collection widget
    var ccSectionContainer = $('.nekit-categories-collection-wrap.carousel-active')
    if( ccSectionContainer.length > 0 ) {
        ccSectionContainer.each(function() {
            var _this = $(this)
            var ccParams = {
                "show_arrows": "yes",
                "enable_autoplay": "no",
                "show_fade": "no",
                "show_infinite": "no",
                "carousel_speed": 1500,
                "autoplay_speed": 300,
                "widget_column": 3,
                "widget_column_tablet": 2,
                "widget_column_mobile": 1
            }
            var widgetContainer = _this.parents('.elementor-widget-nekit-categories-collection[data-widget_type="nekit-categories-collection.default"]')
            if( typeof widgetContainer.data('settings') != 'undefined' ) {
                ccParams = widgetContainer.data('settings')
            }
            var ccArrows = _this.data('arrows')
            var ccAutoplay = _this.data('autoplay')
            var ccAutoplaySpeed = _this.data('autoplayspeed')
            var ccFade = _this.data('fade')
            var ccInfinite = _this.data('infinite')
            var ccSpeed = _this.data('speed')
            var ccSlidesToShow = _this.data('slidestoshow')
            var ccPrevArrow = _this.data('prev')
            var ccNextArrow = _this.data('next')
            var ccMobile = _this.data('mobile')
            var ccTablet = _this.data('tablet')
            ccFade = ( ccSlidesToShow == 1 && ccFade)
            _this.slick({
                arrows: ( ccParams.show_arrows == 'yes' ),
                autoplay: ( ccParams.enable_autoplay == 'yes' ),
                autoplaySpeed: ccParams.autoplay_speed,
                fade: ( ccParams.show_fade == 'yes' ),
                infinite: ( ccParams.show_infinite == 'yes' ),
                speed: ccParams.carousel_speed,
                slidesToShow: ccParams.widget_column,
                prevArrow: '<button type="button" class="slick-prev"><i class="' + ccPrevArrow + '"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="' + ccNextArrow + '"></i></button>',
                responsive: [
                    {
                        breakpoint: 769,
                        settings: {
                            slidesToShow: ccParams.widget_column_tablet
                        }
                    },
                    {
                        breakpoint: 640,
                        settings: {
                            slidesToShow: ccParams.widget_column_mobile
                        }
                    }
                ]
            })
        })
    };

    // news timeline widget handler
    var ntSectionContainer = $('.nekit-news-timeline-wrap')
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
    
    // news carousel one script handler
    var ncOneSection = $(".nekit-carousel-widget")
    if( ncOneSection.length > 0 ) {
        ncOneSection.each(function() {
            var $scope = $(this), nc = $scope.find( ".news-carousel .news-carousel-post-wrap" );
            if( nc.length ) {
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
    }
    
    // handle table of content widget
    var TocSectionContainer = $(".nekit-single-table-of-content")
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
    // main banner one script handler
    var mbSectionContainer = $(".main-banner-section")
    if( mbSectionContainer.length > 0 ) {
        mbSectionContainer.each(function() {
            var _this = $(this), bannerItemsWrap = _this.find(".main-banner-slider"), bannerItemsTabsWrap = _this.find( ".main-banner-tabs" )
            var sAuto = bannerItemsWrap.data("auto"),
            sArrows = bannerItemsWrap.data("arrows"),
            sDots = bannerItemsWrap.data("dots"),
            sLoop = bannerItemsWrap.data("loop"),
            sSpeed = bannerItemsWrap.data("speed"),
            sNextIcon = bannerItemsWrap.data("next-icon"),
            sPrevIcon = bannerItemsWrap.data("prev-icon"),
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

            // banner-tabs - layout one
            if( bannerItemsTabsWrap.length > 0 ) {
                bannerItemsTabsWrap.on( "click", ".banner-tabs li.banner-tab", function() {
                    var _this = $(this), tabItem = _this.attr( "tab-item" );
                    _this.addClass( "active" ).siblings().removeClass( "active" );
                    bannerItemsTabsWrap.find( '.banner-tabs-content div[tab-content="' + tabItem + '"]' ).addClass( "active" ).siblings().removeClass( "active" );
                })
            }

            // main banner popular posts slider events - layout two
            var bannerPopularPostsWrap = _this.find( ".popular-posts-wrap" );
            if( bannerPopularPostsWrap.length ) {
                var bpcAuto = bannerPopularPostsWrap.data( "auto" )
                var bpcArrows = bannerPopularPostsWrap.data( "arrows" )
                var bpcLoop = bannerPopularPostsWrap.data( "loop" )
                var bpcSpeed = bannerPopularPostsWrap.data("speed")
                var bpcVertical = bannerPopularPostsWrap.data( "vertical" );
                var bpcNextIcon = bannerPopularPostsWrap.data("next-icon")
                var bpcPrevIcon = bannerPopularPostsWrap.data("prev-icon")
                if( bpcVertical) {
                    bannerPopularPostsWrap.slick({
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
                    bannerPopularPostsWrap.slick({
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
        })
    }
    
    // news filter script handler
    var nnfSectionContainer = $(".nekit-filter-widget")
    if( nnfSectionContainer.length > 0 ) {
        nnfSectionContainer.each(function() {
            var $scope = $(this)
            var adjustLayout =$(this).data("adjustlayout")
            if( adjustLayout == 'on' || $(window).resize() ) {
                var onBurgerIconClick = $scope.find(".tab-title-wrap")
                var preloadedActiveTabTitle = onBurgerIconClick.find('.isActive').text()
                $scope.find( '.active-tab' ).text( preloadedActiveTabTitle )
                $scope.on('click', '.filter-tab-wrapper', function() {
                    var _this = $(this)
                    if( adjustLayout == 'on' ) _this.find( '.tab-title-wrap' ).toggle()
                    scriptHandlers.onElementOutsideClick( _this, function() {
                        _this.find( '.tab-title-wrap' ).hide()
                    })
                })
            }
            $scope.on("click", ".filter-tab-wrapper .tab-title", function() {
                var _this = $(this), dataTab = _this.data("tab")
                if( adjustLayout == 'on' ) {
                    var activeTabTitle = _this.text()
                    _this.parents('.filter-tab-wrapper').find( '.active-tab' ).text( activeTabTitle )
                    _this.parents('.tab-title-wrap').hide()
                }
                var widgetMainClass = _this.parents( ".nekit-filter-widget" )
                if( _this.hasClass('active-tab') ) return
                if( _this.hasClass( 'isActive' ) ) return
                var classToCheck = '.tab-'+dataTab
                if( dataTab == 'news-elementor-filter-all' ) classToCheck = '.tab-all'
                if( dataTab == 'nekit-filter-all' ) {
                    widgetMainClass.find( '.tab-all' ).show().addClass('isActive').siblings( '.news-filter-post-wrap' ).hide().removeClass('isActive')
                    _this.addClass('isActive').siblings().removeClass('isActive')
                    return
                }
                var widgetId = _this.parents( '.elementor-widget' ).data( 'id' )
                var widgetLayout = _this.parents( '.nekit-filter-widget' ).data('widgetlayout')
                if( widgetMainClass.find( classToCheck ).length < 1 ) {
                    $.ajax({
                        type: 'POST',
                        url: ajaxUrlA,
                        data: {
                            action: 'nekit_news_filter_tab_content_change',
                            options: JSON.stringify( nekitWidgetData[ widgetId ] ),
                            category: JSON.stringify(dataTab),
                            widgetCount: JSON.stringify(widgetLayout),
                            _wpnounce: nonceA
                        },
                        beforeSend: function() {
                            $scope.find( '.news-filter-post-wrap.isActive' ).addClass( 'retrieving-posts' )
                            $scope.find( '.news-filter-post-wrap.isActive' ).append(loaderElm)
                        },
                        success: function(result) {
                            widgetMainClass.append( result )
                        },
                        complete: function() {
                            $scope.find( '.news-filter-post-wrap.isActive' ).removeClass( 'retrieving-posts' )
                            widgetMainClass.find( classToCheck ).show().siblings('.news-filter-post-wrap').hide().removeClass('isActive')
                            _this.addClass('isActive').siblings().removeClass('isActive')
                            $scope.find( '.nekit-loader' ).remove()
                        }
                    }) 
                } else {
                    widgetMainClass.find( classToCheck ).show().addClass('isActive').siblings('.news-filter-post-wrap').hide().removeClass('isActive')
                    _this.addClass('isActive').siblings().removeClass('isActive')
                }
            })
        })
    }

    // handle the section custom properties
    var stickySections = $(".nekit-section--sticky")
    if( stickySections.length > 0 ) {
        stickySections.each(function() {
            var thisSection = $(this), position = thisSection.data("nekit-sticky-position"), condition = thisSection.data("nekit-sticky-condition"), sectionScrollHeight = thisSection.offset().top
            $(window).on( "scroll", function() {
                if( $(window).scrollTop() > sectionScrollHeight ) {
                    if( ! thisSection.hasClass( "nekit-section--sticky-active-" + position ) ) thisSection.addClass("nekit-section--sticky-active-" + position)
                } else {
                    if( thisSection.hasClass( "nekit-section--sticky-active-" + position ) ) thisSection.removeClass("nekit-section--sticky-active-" + position)
                }
            })
        })
    }

    // ticker news two handlers
    var tnTwoSectionContainer = $('.nekit-ticker-news-two')
    if( tnTwoSectionContainer.length > 0 ) {
        tnTwoSectionContainer.each(function() {
            var _this = $(this)
            var classToAddSlick = _this.find('.ticker-item-wrap')
            var arrow = _this.data('arrows')
            var autoplay = _this.data('autoplay')
            var autoplaySpeed = _this.data('autoplay-speed')
            var speed = _this.data('speed')
            var fade = _this.data('fade')
            var infinite = _this.data('infinite')
            var sliderNextArrow = _this.data('nextarrow')
            var sliderPreviousArrow = _this.data('previousarrow')
            var nextArrow = ''
            var previousArrow = ''
            var sliderVertical = ( fade == true ) ? false : _this.data('vertical')
            nextArrow = ( _this.data('nextarrow') == '' ) ? '' : `<button type="button" class="slick-next"><i class="` + sliderNextArrow + `"></i></button>` 
            previousArrow = ( _this.data('previousarrow') == '' ) ? '' : `<button type="button" class="slick-prev"><i class="` + sliderPreviousArrow + `"></i></button>` 
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
        })
    }

    // archive post handlers
    var apSectionContainer = $('.nekit-archive-posts-wrap')
    if( apSectionContainer.length > 0 ) {
        var ajaxLoadMoreButton = apSectionContainer.find('.nekit-load-more')
        var classToAppendTo = apSectionContainer.find('.posts-inner-wrap')
        var maxNumberOfPage = apSectionContainer.data('max-num-page')
        var noPostsFound = apSectionContainer.data('no-posts-found')
        var noPostsFoundDivIncluded = '<div class="no-posts-found">'+ noPostsFound +'</div>'
        var pagination = apSectionContainer.data('page')
        var maxNumPage = maxNumberOfPage
        ajaxLoadMoreButton.click(function() {
            if( maxNumberOfPage >= pagination ) {
                var _this = $(this)
                var elementorParentClass = _this.parents('.elementor-widget')
                var widgetId = elementorParentClass.data('id')
                pagination++
                $.ajax({
                    type: 'POST',
                    url: ajaxUrlA,
                    data: {
                        action: 'nekit_archive_posts_ajax_load_more',
                        options: JSON.stringify( nekitWidgetData[widgetId] ),
                        pagination: JSON.stringify( pagination ),
                        maxNumPage: JSON.stringify( maxNumPage ),
                        _wpnounce: nonceA
                    },
                    beforeSend: function() {
                        _this.parent().addClass( 'retrieving-posts' )
                    },
                    success: function( result ) {
                        if( result == '' ) {
                            _this.parent().remove()
                            apSectionContainer.append( noPostsFoundDivIncluded )
                        }
                        classToAppendTo.append( result )
                    },
                    complete: function() {
                        _this.parent().removeClass( 'retrieving-posts' )
                    }
                })
            }
        })
    }
    
    // mega menu width handlers
    var nekit_megamenu_width = $('.orientation--horizontal .nekit-megamenu-fit-to-screen');
    nekit_megamenu_width.each(function() {
        var parent_elm = $(this).parents('.news-elementor-nav-mega-menu')
        $(this).css({'width' : $(window).width() +'px','left' : - parent_elm.offset().left +'px'})
    })
    var nekit_megamenu_section_width = $('.orientation--horizontal .nekit-megamenu-fit-to-section');
    nekit_megamenu_section_width.each(function() {
        if( $(this).parents('.elementor-container').length > 0 ) {
            var elementor_container = $(this).parents('.elementor-container')
        } else {
            var parentSection = $(this).parents('.e-parent')
            if( parentSection.hasClass( 'e-con-boxed' ) ) {
                var elementor_container = parentSection.find( '.e-con-inner' );
            } else {
                var elementor_container = parentSection;
            }
        }
        var parent_sec_elm = elementor_container.offset().left;
        var inner_parent_sec_elm = $(this).parents('.news-elementor-nav-mega-menu').offset().left;
        var left_val = Math.abs(parent_sec_elm - inner_parent_sec_elm);
        var section_width = elementor_container.width();
        $(this).css({'width' : section_width +'px','left' : - left_val +'px'})
    });
    $(window).resize(function() {
        var nekit_megamenu_width = $('.orientation--horizontal .nekit-megamenu-fit-to-screen');
        nekit_megamenu_width.each(function(){
            var parent_elm = $(this).parents('.news-elementor-nav-mega-menu')
            $(this).css({'width' : $(window).width() +'px','left' : - parent_elm.offset().left +'px'})
        })
        
        var nekit_megamenu_section_width = $('.orientation--horizontal .nekit-megamenu-fit-to-section');
        nekit_megamenu_section_width.each(function(){
            if( $(this).parents('.elementor-container').length > 0 ) {
                var elementor_container = $(this).parents('.elementor-container')
            } else {
                var parentSection = $(this).parents('.e-parent')
                if( parentSection.hasClass( 'e-con-boxed' ) ) {
                    var elementor_container = parentSection.find( '.e-con-inner' );
                } else {
                    var elementor_container = parentSection;
                }
            }
            var parent_sec_elm = elementor_container.offset().left;
            var inner_parent_sec_elm = $(this).parents('.news-elementor-nav-mega-menu').offset().left;
            var left_val = Math.abs(parent_sec_elm - inner_parent_sec_elm);
            $(this).css({'left' : - left_val +'px'})
        });
    });

    // social share widget
    var socialShareContainer = $( '.nekit-social-share' )
    if( socialShareContainer.length > 0 ) {
        socialShareContainer.each(function(){
            if( $(this).hasClass( 'social-share--on' ) ) {
                var socialSharePrefix = $(this).find( '.social-share-prefix' )
                socialSharePrefix.on( 'click', function(){
                    var _this = $(this)
                    _this.siblings().toggleClass( 'isactive' )
                })
            }
            var printButton = socialShareContainer.find( '.print' )
            printButton.on( 'click', function(){ 
                printButton.find( 'a' ).removeAttr( 'href' )
                window.print()
            })
            var copyLinkButton = socialShareContainer.find( '.copy_link' )
            copyLinkButton.on( 'click', function( event ) { 
                event.preventDefault()
                var copyLinkButtonAnchor = copyLinkButton.find( 'a' )
                var linkToCopy = copyLinkButtonAnchor.attr( 'href' )
                navigator.clipboard.writeText( linkToCopy )
            })
        })
    }

    // canvas menu
    var canvasMenuContainer = $( '.news-elementor-canvas-menu' )
    if( canvasMenuContainer.length > 0 ) {
        canvasMenuContainer.each(function() {
            var _this = $(this)
            _this.on( "click", ".canvas-content-trigger", function() {
                var _innerThis = $(this)
                _innerThis.next().toggleClass( "isShow" )
                $('body').toggleClass("nekit-canvas-menu-overlay")
            })
            scriptHandlers.onElementOutsideClick(_this.find( ".canvas-menu-content" ), function() {
                _this.find( ".canvas-menu-content" ).removeClass("isShow")
                $('body').removeClass("nekit-canvas-menu-overlay")
            })
        })
    }

    /**
     * Nekit Popup Builder
     * MARK: Popup Builder
     */
    const NekitPopupBuilder = {
        nekitPopupSelector: $( '.nekit-popup-wrapper' ),
        nekitTemplateIdPrefix: 'nekit-popup-post-',
        init: function(){
            if( this.nekitPopupSelector.length > 0 ) {
                this.loadNekitLocalStorageVariables()
                this.setTimer()
                this.closeButton()
                this.closePopupOnESCPress()
                this.showPopup()
                this.closeAutomaticallyAfter()
                this.handleOutsideClicks()
                this.closeButtonDelay()
            }
        },
        /* Close Button Handle */
        closeButton: function(){
            let self = this
            this.nekitPopupSelector.each(function(){
                let _this = $(this),
                    closeButton = _this.find( '.nekit-popup-close' ),
                    settings = _this.data( 'settings' ),
                    templateId = self.getPopupId( _this ),   /* Popup Id */
                    _thisControlValues = self.getControlValuesById( templateId ),
                    { nekit_show_again_delay: delay, nekit_open_popup: openPopup } = settings;
                
                /* Close Button click event */
                closeButton.on('click', function(){
                    if( delay.select !== 'none' && openPopup !== 'custom-trigger' ) {
                        _thisControlValues[ 'nekit_show_popup_again_timestamp' ] = Date.now() + self.convertToMiliseconds( delay )    /* Determine whether to show popup again or not */
                    }
                    if( delay.select === 'none' ) {
                        _thisControlValues[ 'nekit_show_again' ] = false
                    }
                    localStorage.setItem( 'nekitPopupSettings', JSON.stringify({ ...self.getLocalStorageVariables(), [ templateId ]: _thisControlValues }) ) /* Update the local storage variables */
                    self.nekitRemoveClass( _this )
                })
            })
        },
        /* Close Popup on ESC Button Press */
        closePopupOnESCPress: function(){
            let self = this
            $(document).on( 'keydown', function( event ) {
                let nekitPopupcount = $( '.nekit-popup-wrapper.is-open' ).length
                if( nekitPopupcount > 0 && event.key === "Escape" ) {
                    let nekitPopup = $( '.nekit-popup-wrapper.is-open' )[ nekitPopupcount - 1 ],   /* Always the last one. */
                        settings = $( nekitPopup ).data( 'settings' ),
                        { nekit_popup_close_on_esc: isOkToCloseOnESC, nekit_show_again_delay: delay, nekit_open_popup: openPopup } = settings;

                    if( isOkToCloseOnESC ) {
                        let templateId = self.getPopupId( $( nekitPopup ) ),    /* Popup Id */
                            _thisControlValues = self.getControlValuesById( templateId )

                        if( delay.select !== 'none' && openPopup !== 'custom-trigger' ) {
                            _thisControlValues[ 'nekit_show_popup_again_timestamp' ] = Date.now() + self.convertToMiliseconds( delay )    /* Determine whether to show popup again or not */
                        }
                        if( delay.select === 'none' ) {
                            _thisControlValues[ 'nekit_show_again' ] = false
                        }
                        localStorage.setItem( 'nekitPopupSettings', JSON.stringify({ ...self.getLocalStorageVariables(), [ templateId ]: _thisControlValues }) ) /* Update the local storage variables */
                        self.nekitRemoveClass( $( nekitPopup ) )
                    }
                }
            });
        },
        /* Close Automatically After */
        closeAutomaticallyAfter: function(){
            let self = this
            this.nekitPopupSelector.each(function(){
                let _this = $(this), 
                    settings = _this.data( 'settings' ),    /* Popup Settings */
                    { nekit_popup_enable_automatic_closing: enableAutomaticClosing, nekit_delay_close_automatically_after: secondsToCloseAfter } = settings,
                    milisecondsToCloseAfter = secondsToCloseAfter * 1000;

                if( enableAutomaticClosing ) {
                    setTimeout(function(){
                        self.nekitRemoveClass( _this )
                    }, milisecondsToCloseAfter )
                }
            })
        },
        /* Show popup after how many seconds */
        delayPopupShow: function( popupElement, delay ){
            let self = this
            setTimeout(function(){
                self.nekitAddClass( popupElement )
            }, delay )
        },
        /* When to Show popup */
        showPopup: function(){
            let self = this
            this.nekitPopupSelector.each(function(){
                let _this = $(this), 
                    templateId = self.getPopupId( _this ),
                    settings = _this.data( 'settings' ),
                    templateValues = self.getControlValuesById( templateId ),   /* Popup Id */
                    { nekit_show_again: isShowAgain, nekit_show_popup_again_timestamp: showAgainTimestamp } = templateValues,
                    { nekit_open_popup: openPopup, nekit_delay_after_page_load: seconds, nekit_element_id: element, nekit_popup_on_scroll: showOnScroll } = settings

                if( ( isShowAgain && Date.now() > showAgainTimestamp || openPopup === 'custom-trigger' ) ) {
                    switch( openPopup ) {
                        case 'page-scroll' :
                            let { nekit_to_show_after_scroll: scroll } = settings,
                                documentHeight = $(document).height(),
                                calculatedScroll = documentHeight * ( scroll / 100 ),    /* Getting specific height from the total document height. */
                                isPopupShown = false

                            $( document ).on( 'scroll', function(){
                                if( $(this).scrollTop() > calculatedScroll && ! isPopupShown ) {
                                    isPopupShown = true
                                    self.nekitAddClass( _this )
                                }
                            });
                            break;
                        case 'scroll-to-element' :
                            /* Detect the element only once. */
                            let hasBeenSeen = false
                            $( document ).on( 'scroll', function(){
                                if( ! hasBeenSeen ) {
                                    let inViewPort = self.isInViewport( $( element ) )
                                    if( inViewPort ) {
                                        if( showOnScroll !== 'every' ) hasBeenSeen = true
                                        self.nekitAddClass( _this )
                                    }
                                }
                            });
                            break;
                        case 'custom-trigger' :
                            $( element ).on( 'click', function(){
                                self.nekitAddClass( _this )
                            });
                            break;
                        default :   /* page-load */
                            let miliseconds = seconds * 1000
                            self.delayPopupShow( _this, miliseconds )
                            break;
                    }
                }
            })
        },
        /* Check if element in viewport */
        isInViewport: function( element ) {
            let elementTop = element.offset().top;
            let elementBottom = elementTop + element.outerHeight();
            let viewportTop = $( window ).scrollTop();
            let viewportBottom = viewportTop + $( window ).height();
        
            return elementBottom > viewportTop && elementTop < viewportBottom;
        },
        /* Load Local Storage Variables */
        loadNekitLocalStorageVariables: function() {
            let self = this, localStorageData = {}
            this.nekitPopupSelector.each(function(){
                let _this = $(this),
                    settings = _this.data( 'settings' ),
                    { nekit_show_again_delay: newDelay } = settings,
                    templateId = self.getPopupId( _this ),   /* Popup Id */
                    defaultTemplateData = {
                        nekit_show_popup_again_timestamp: 0,
                        nekit_show_again: true,
                        nekit_show_again_delay: newDelay
                    },
                    localStorageVariables = self.getLocalStorageVariables();

                /* Execute if local storage is not set. */
                if( localStorageVariables === null ) {
                    localStorageData = { 
                        ...localStorageData, 
                        [ templateId ]: defaultTemplateData
                    }
                } else {
                    /* Update local storage value if changed. */
                    if( templateId in localStorageVariables ) {
                        let { nekit_show_again_delay: oldDelay = '' } = self.getControlValuesById( templateId )
                        if( newDelay.select !== oldDelay.select || newDelay.number !== oldDelay.number ) {
                            localStorageData = { 
                                ...localStorageData, 
                                [ templateId ]: defaultTemplateData
                            }
                        } else {
                            /* Don't change local storage values if not changed. */
                            localStorageData = { 
                                ...localStorageData, 
                                [ templateId ]: self.getControlValuesById( templateId )
                            }
                        }
                    } else {
                        /* Add new data if template id not exists */
                        localStorageData = { 
                            ...localStorageData, 
                            [ templateId ]: defaultTemplateData
                        }
                    }
                }

            })
            localStorage.setItem( 'nekitPopupSettings', JSON.stringify( localStorageData ) )
        },
        /* Calculate to milliseconds */
        convertToMiliseconds: function( delay ) {
            if( delay === undefined || delay === null ) return 0
            let { number, select } = delay
            switch( select ) {
                case 'second':
                    return number * 1000
                    break;
                case 'minute':
                    return number * 60 * 1000
                    break;
                case 'hour':
                    return number * 60 * 60 * 1000
                    break;
                case 'day':
                    return number * 24 * 60 * 60 * 1000
                    break;
            }
        },
        /* Get local storage variables */
        getLocalStorageVariables: function(){
            let nekitLocalStorageVariables = localStorage.getItem( 'nekitPopupSettings' )   /* Access Local Storage */
            let parsedVariables = JSON.parse( nekitLocalStorageVariables )  /* Parsing the local storage value */
            return parsedVariables
        },
        /* Get Control values by Id */
        getControlValuesById: function( id ){
            let nekitVariables = this.getLocalStorageVariables()
            return nekitVariables[ id ]
        },
        /* Get local storage variables */
        getPopupId: function( element ){
            let _thisIdAttribute = element.attr( 'id' )  /* Fetch Id Attribute of Popup */
            let templateId = _thisIdAttribute.split( this.nekitTemplateIdPrefix )[1]    /* Split the id and get its template id */
            return parseInt( templateId )
        },
        /* Set timer */
        setTimer: function(){
            let self = this
            setTimeout(function(){
                Object.entries( self.getLocalStorageVariables() ).map(([ templateId, templateValues ]) => {
                    let templateTimestamp = templateValues[ 'nekit_show_popup_again_timestamp' ],
                        popupIdAttribute = $( '#' + self.nekitTemplateIdPrefix + templateId ),    /* Popup Element */
                        popupSettings = popupIdAttribute.data( 'settings' ),
                        { nekit_show_again_delay: delay, nekit_open_popup: openPopup } = popupSettings
                    /* Show popup again */
                    if( ( delay.select !== 'none' ) && ( Date.now() >= templateTimestamp ) && ( templateTimestamp !== 0 ) && ( openPopup !== 'custom-trigger' ) ) {
                        self.nekitAddClass( popupIdAttribute )
                        let newLocalStorageData = { 
                            ...self.getLocalStorageVariables(),
                            [ templateId ]: { 
                                ...self.getLocalStorageVariables()[ templateId ],
                                nekit_show_popup_again_timestamp: 0 
                            }
                        }
                        localStorage.setItem( 'nekitPopupSettings', JSON.stringify( newLocalStorageData ) ) /* Update the local storage variables */
                    }
                })
            }, 1000)
        },
        /* Handle Outside click */
        handleOutsideClicks: function(){
            let self = this
            $( document ).mouseup(function ( e ) {
                let nekitPopupcount = $( '.nekit-popup-wrapper.is-open' ).length
                if( nekitPopupcount > 0 ) {
                    let nekitPopup = $( '.nekit-popup-wrapper.is-open' )[ nekitPopupcount - 1 ],   /* Always the last one. */
                    settings = $( nekitPopup ).data( 'settings' ),
                    { nekit_popup_enable_closing_on_overlay_click: enableOverlayClick, nekit_show_again_delay: delay, nekit_open_popup: openPopup } = settings;

                    if( enableOverlayClick ) {
                        if( $( e.target ).is( $( '.nekit-popup-overlay' ) ) ) {
                            let templateId = self.getPopupId( $( nekitPopup ) ),    /* Popup Id */
                            _thisControlValues = self.getControlValuesById( templateId )
    
                            if( delay.select !== 'none' && openPopup !== 'custom-trigger' ) {
                                _thisControlValues[ 'nekit_show_popup_again_timestamp' ] = Date.now() + self.convertToMiliseconds( delay )    /* Determine whether to show popup again or not */
                            }
                            if( delay.select === 'none' ) {
                                _thisControlValues[ 'nekit_show_again' ] = false
                            }
                            localStorage.setItem( 'nekitPopupSettings', JSON.stringify({ ...self.getLocalStorageVariables(), [ templateId ]: _thisControlValues }) ) /* Update the local storage variables */
                            self.nekitRemoveClass( $( nekitPopup ) )
                        }
                    }
                }
            })
        },
        /* Add class */
        nekitAddClass: function( element ){
            element.addClass( 'is-open' )
            element.parents( 'body' ).addClass( 'nekit-popup-open' )
            let settings = element.data( 'settings' ),  /* Popup Settings */
                { nekit_display_as: displayAs, nekit_popup_disable_page_scroll: disablePageScroll } = settings

            if( displayAs === 'top-bar' ) {
                element.parents( 'body' ).addClass( 'as-' + displayAs )
                $( 'body' ).prepend( element )
            }
            if( disablePageScroll && ( displayAs !== 'top-bar' ) ) element.parents( 'body' ).addClass( 'nekit-scroll--disabled' )
        },
        /* Remove class */
        nekitRemoveClass: function( element ){
            let settings = element.data( 'settings' ),  /* Popup Settings */
                { nekit_popup_disable_page_scroll: disablePageScroll } = settings

            element.removeClass( 'is-open' )
            if( $( '.nekit-popup-wrapper.is-open' ).length <= 0 ) {
                element.parents( 'body' ).removeClass( 'nekit-popup-open' )
            }

            if( disablePageScroll ) element.parents( 'body' ).removeClass( 'nekit-scroll--disabled' )
        },
        /* Close button Delay */
        closeButtonDelay: function(){
            this.nekitPopupSelector.each(function(){
                let _this = $( this ),
                    settings = _this.data( 'settings' ),    /* Popup Settings */
                    { nekit_popup_close_button_display_delay: closeButtonDelay } = settings,
                    miliseconds = closeButtonDelay * 1000;

                setTimeout(function(){
                    _this.find( '.nekit-popup-close' ).show()
                }, miliseconds )
            })
        }
    }
    NekitPopupBuilder.init()

    /* Sticky Post Handle */
    let stickyPostContainer = $( '.nekit-sticky-posts' )
    if( stickyPostContainer.length > 0 ) {
        stickyPostContainer.on( 'click', '.indicator.active', function(){
            let _this = $( this ),
                hiddenPosts = _this.parent().siblings( '.post.hide' ),
                postsToShow = _this.parent().siblings( '.post.show' );

            _this.removeClass( 'active' ).siblings().addClass( 'active' )
            hiddenPosts.removeClass( 'hide' ).addClass( 'show' )
            postsToShow.removeClass( 'show' ).addClass( 'hide' )
        })

        /* Adding z-index */
        let initialZindex = stickyPostContainer.find( '.post' ).length
        stickyPostContainer.find( '.post' ).each(function(){
            let _this = $( this )
            _this.css({
                'z-index': initialZindex--
            })
        })
    }

    /* Nekit Stories */
    const NekitStories = {
        container: null,
        containerIndex: null,
        storyModalContainer: null,
        mainSwiperInstance: null,
        allInnerSwipers: {},
        nextSlideTimeout: null,
        modalCloseTimeout: null,
        widgetId: null,
        widgetSettings: null,
        init: function(){
            this.openModal()
        },
        /* Open Story Modal */
        openModal: function(){
            let self = this
            $( '.nekit-stories .stories' ).on( 'click', '.story:not(".no-gallery")', function(){
                let _this = $( this ),
                    _thisIndex = _this.parent().children( '.story:not(".no-gallery")' ).index( _this );
                self.container = _this.parents( '.nekit-stories' )
                self.storyModalContainer = self.container.find( '.stories-modal' )
                self.widgetId = self.container.parents( '.elementor-widget[data-element_type="widget"]' ).data( "id" )
                self.widgetSettings = nekitWidgetData[ self.widgetId ]

                console.log( _thisIndex )
                self.storyModalContainer.addClass( 'show' )
                self.mainSwiper();
                self.initializeInnerSwiper( _thisIndex );
                self.mainSwiperInstance.slideTo( _thisIndex, 0, false );
                $( 'body' ).addClass( 'story-modal--on' )
                self.pauseStoryModal()
                self.handleCrossButton()
            })
        },
        /* Handle cross button click in story modal */
        handleCrossButton: function(){
            let self = this
            this.storyModalContainer.on( 'click', '.close-modal', function(){
                self.closeModal()
            })
        },
        /* Close Story Modal */
        closeModal: function(){
            this.storyModalContainer.removeClass( 'show' )
            Object.values( this.allInnerSwipers ).forEach( swiper => swiper.destroy( true, true ) )
            this.allInnerSwipers = {}
            this.mainSwiperInstance.destroy( true, true )
            this.storyModalContainer.find( '.pause-story' ).removeClass( 'paused' ).addClass( 'playing' )
            clearTimeout( this.nextSlideTimeout );
            clearTimeout( this.modalCloseTimeout );
            $( 'body' ).removeClass( 'story-modal--on' )
        },
        /* Pause Story Modal */
        pauseStoryModal: function(){
            let self = this,
                playIcon = this.widgetSettings[ 'play_icon' ],
                pauseIcon = this.widgetSettings[ 'pause_icon' ];
            this.storyModalContainer.on( 'click', '.pause-story', function(){
                let _this = $( this ),
                    index = _this.parents( '.swiper-slide' ).index();
                
                _this.toggleClass( 'playing paused' )
                if( _this.hasClass( 'paused' ) ) {
                    _this.find( 'i' ).removeClass().addClass( playIcon.value )
                    self.allInnerSwipers[ index ].autoplay.pause()
                } else {
                    _this.find( 'i' ).removeClass().addClass( pauseIcon.value )
                    self.allInnerSwipers[ index ].autoplay.resume()
                }
            })
        },
        /* Initialize Swiper JS in .main-swiper */
        mainSwiper: function(){
            let self = this,
                { effect, speed } = this.widgetSettings[ 'main_swiper_settings' ];
            this.mainSwiperInstance = new Swiper( this.container.find( ".main-swiper" )[0], {
                effect,
                speed,
                grabCursor: false,
                loop: false,
                allowTouchMove: true,
                cubeEffect: {
                    shadow: false,
                    slideShadows: false
                },
                navigation: {
                    nextEl: this.container.find( ".swiper-arrow.next" )[ 0 ],
                    prevEl: this.container.find( ".swiper-arrow.prev" )[ 0 ]
                },
                on: {
                    slideChange: function( swiper ) {
                        let { activeIndex, params } = swiper
                        clearTimeout( self.nextSlideTimeout );
                        self.initializeInnerSwiper( activeIndex );
                        setTimeout(() => {
                            self.destroyInnerSwipersExceptActive( activeIndex );
                        }, 500);
                    }
                }
            });
        },
        /* Initialize Swiper JS in .inner-swiper */
        initializeInnerSwiper: function( innerSwiperIndex ){
            if( this.allInnerSwipers[ innerSwiperIndex ] ) return   /* Prevent re-initialization */
            let self = this,
                innerSwiper = null,
                { effect, speed, direction, autoplay_speed: autoplaySpeed } = this.widgetSettings[ 'inner_swiper_settings' ];

            innerSwiper = new Swiper( this.storyModalContainer.find( '.inner-swiper' )[ innerSwiperIndex ], {
                direction,
                speed,
                effect,
                loop: false,
                allowTouchMove: false,
                autoplay: {
                    delay: autoplaySpeed,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: false
                },
                pagination: {
                    el: ".inner-swiper .swiper-pagination",
                    clickable: true,
                    renderBullet: function(index, className) {
                        return `<span class="${ className }"><span class="progress-bar"></span></span>`;
                    }
                },
                navigation: {
                    nextEl: ".inner-swiper-arrow.next",
                    prevEl: ".inner-swiper-arrow.prev"
                },
                on: {
                    init: function( swiper ) {
                        self.disableNavigationButtons( swiper );
                        self.addAmbient( swiper )
                    },
                    autoplayTimeLeft: self.storyProgress,
                    reachEnd: function( swiper ) {
                        if ( self.mainSwiperInstance.activeIndex === self.mainSwiperInstance.slides.length - 1 ) {
                            /* Close Story modal if last story is showing */
                            self.modalCloseTimeout = setTimeout(() => {
                                if( swiper.autoplay ) swiper.autoplay.stop();
                                self.closeModal();
                            }, 2300 );
                        } else {
                            /* Show next story */
                            self.nextSlideTimeout = setTimeout(() => {
                                self.mainSwiperInstance.slideNext();
                            }, 2300 );
                        }
                    },
                    slideChange: function( swiper ){
                        let { activeIndex, slides } = swiper
                        self.disableNavigationButtons( swiper )
                        if( self.modalCloseTimeout !== null && ( activeIndex !== slides.length - 1 ) ) {
                            clearTimeout( self.modalCloseTimeout )
                        }
                        if( activeIndex !== slides.length - 1 ) {
                            clearTimeout( self.nextSlideTimeout )
                        }
                        if( activeIndex !== 0 ) self.addAmbient( swiper )
                    }
                }
            });
            this.allInnerSwipers[ innerSwiperIndex ] = innerSwiper
        },
        /* Disable .main-swiper navigation buttons */
        disableNavigationButtons: function( swiperInstance ){
            let { activeIndex, slides } = swiperInstance
            // if last slide
            if( activeIndex - slides.length - 1 ) {
                this.storyModalContainer.find( '.main-swiper .swiper-arrow.next' ).removeClass( 'disabled' )
            } else {
                this.storyModalContainer.find( '.main-swiper .swiper-arrow.next' ).addClass( 'disabled' )
            }

            // if first slide
            if( activeIndex === 0 ) {
                this.storyModalContainer.find( '.main-swiper .swiper-arrow.prev' ).removeClass( 'disabled' )
            } else {
                this.storyModalContainer.find( '.main-swiper .swiper-arrow.prev' ).addClass( 'disabled' )
            }
        },
        /* Destroy all instances of .inner-swiper except active one */
        destroyInnerSwipersExceptActive: function( activeIndex ){
            let self = this
            Object.keys( this.allInnerSwipers ).forEach(( index ) => {
                let parsedIndex = parseInt( index )
                if( activeIndex !== parsedIndex ) {
                    self.allInnerSwipers[ parsedIndex ].destroy( true, true )
                    delete self.allInnerSwipers[ parsedIndex ];
                }
            })
        },
        /* Story Progress */
        storyProgress: function( swiper, time, progress ){
            let { pagination } = swiper,
                activeBullet = $( pagination.el ).find( '.swiper-pagination-bullet-active' );
            let widthPercent = Math.floor( ( 1 - progress ) * 100 )
            activeBullet.find( '.progress-bar' ).css({
                width: widthPercent + '%'
            })
            activeBullet.prevAll( '.swiper-pagination-bullet' ).find( '.progress-bar' ).css({
                'width': '100%'
            })
            activeBullet.nextAll( '.swiper-pagination-bullet' ).find( '.progress-bar' ).css({
                'width': '0%'
            })
        },
        /* Add ambient */
        addAmbient: function( swiper ) {
            let { activeIndex, slides } = swiper,
                currentSlide = $( slides[ activeIndex ] ),
                storyImage = currentSlide.find( '.story-image' ).attr( 'src' );

            this.container.find( '.ambient-wrapper' ).css({
                'background-image': 'url('+ storyImage +')'
            })
        }
    }
    
    NekitStories.init()
})