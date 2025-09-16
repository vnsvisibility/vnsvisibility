/**
 * Pre-made block
 * 
 * MARK: PRE-MADE BLOCKS
 */
(function( $ ) {
    /**
     * MARK: GLOBAL
     */
    const GLOBAL = {
        /* Outside click */
        onElementOutsideClick: function( currentElement, callback ) {
            currentElement.parents( 'body' ).mouseup(function ( event ) {
                let container = $( currentElement ),
                    target = event.target;

                if ( ! container.is( target ) && ( container.has( target ).length === 0 ) ) callback();
            })
        },
        /* Initialize Masonry */
        initMasonry: function( masonryObject = {} ) {
            let { element, selector } = masonryObject
            let masonryInstance = element.masonry({
                itemSelector: selector,
                horizontalOrder: true,
                gutter: 30,
                columnWidth: '.grid-sizer'
            });
            return masonryInstance
        }
    }

    /**
     * MARK: PRE-MADE BLOCKS
     */
    window.filterTabHeader = {
        container: $( '#nekit-sub-admin-page .widgets-category-title-filter' ),
        activeFreePro: 'both',
        activeFilter: 'all',
        isSearch: false,
        searchField: '',
        preMadeBlocks: '',
        masonryInstance: '',
        freeProButtons: '',
        init: function() {
            if( this.container.length > 0 ) {
                this.searchField = this.container.siblings( '.search-wrapper' ).find( 'input[type="search"]' );
                this.preMadeBlocks = this.container.parent().siblings();
                this.freeProButtons = this.container.siblings( '.free-pro-filter-tabs' );
    
                this.activeFilterHandle();
                this.handleFilterClick();
                this.handleFreeProClick();
                this.addFilterCount();
                this.searchHandle();
                this.addMasonry();
            }
        },
        /* Handle active filter click */
        activeFilterHandle: function(){
            this.container.on( 'click', '.active-filter', function(){
                let _this = $(this)
                _this.siblings().toggleClass( 'open' )
                GLOBAL.onElementOutsideClick( _this, function(){
                    _this.siblings().removeClass( 'open' )
                })
            })
        },
        /* Filter block when active filter changes */
        handleFilterClick: function(){
            let self = this
            this.container.on( 'click', '.filter-tab', function(){
                if( ! $( this ).hasClass( 'active' ) ) {
                    let _this = $( this ),
                        filterValue = _this.data('value'),
                        label = _this.find( '.tab-label' ).text()

                    _this.addClass( 'active' ).siblings().removeClass( 'active' )
                    _this.parent().siblings( '.active-filter' ).find( '.filter-text' ).text( label )
                    self.activeFilter = filterValue
                    self.activeFreePro = 'both'
                    self.freeProButtons.find( '.filter-tab' ).removeClass( 'active' )
                    self.freeProButtons.find( '.filter-tab.both' ).addClass( 'active' )
                    self.searchField.val( '' )
                    self.isSearch = false
                    self.filterBlocks()
                }
            })
        },
        /* Handle free pro button clicks */
        handleFreeProClick: function(){
            let self = this
    
            this.freeProButtons.on( 'click', '.filter-tab', function(){
                if( ! $( this ).hasClass( 'active' ) ) {
                    let _this = $( this ),
                        isFree = _this.hasClass( 'free' ),
                        isPro = _this.hasClass( 'pro' ),
                        isUpgrade = _this.hasClass( 'upgrade' ),
                        isBoth = _this.hasClass( 'both' );
                    
                    _this.addClass( 'active' ).siblings().removeClass( 'active' )
                    if( isFree ) self.activeFreePro = 'free'
                    if( isPro ) self.activeFreePro = 'pro'
                    if( isUpgrade ) self.activeFreePro = 'upgrade'
                    if( isBoth ) self.activeFreePro = 'both'
                    self.filterBlocks()
                }
            })
        },
        /* Filter pre-made blocks */
        filterBlocks: function() {
            let findingSelectedPreviews = '',
                findingUnSelectedPreviews = '';
    
            if( this.activeFreePro === 'both' && ! this.isSearch ) {
    
                findingSelectedPreviews = this.preMadeBlocks.find( '.' + this.activeFilter ),    /* Matched Items */
                findingUnSelectedPreviews = this.preMadeBlocks.find( '.template-item' ).not( '.' + this.activeFilter );  /* Unmatched Items */
    
            } else {
                if( this.isSearch && this.activeFreePro !== 'both' ) {  /* Search is active and free / pro is not */
    
                    findingSelectedPreviews = this.preMadeBlocks.find( '.active.' + this.activeFreePro ),    /* Matched Items */
                    findingUnSelectedPreviews = this.preMadeBlocks.find( '.template-item' ).not( '.active.' + this.activeFreePro );  /* Unmatched Items */
    
                } else if( this.isSearch && this.activeFreePro === 'both' ) {   /* Search is active and free / pro is also active */
    
                    findingSelectedPreviews = this.preMadeBlocks.find( '.template-item.active' );  /* Matched Items */
                    findingUnSelectedPreviews = this.preMadeBlocks.find( '.template-item' ).not( '.active' );  /* Unmatched Items */
    
                } else {
    
                    findingSelectedPreviews = this.preMadeBlocks.find( '.' + this.activeFilter + '.' + this.activeFreePro ),    /* Matched Items */
                    findingUnSelectedPreviews = this.preMadeBlocks.find( '.template-item' ).not( '.' + this.activeFilter + '.' + this.activeFreePro );  /* Unmatched Items */
    
                }
            }
            
            findingSelectedPreviews.show()
            findingUnSelectedPreviews.hide()
            if( this.activeFilter === 'all' ) findingSelectedPreviews.show()
            this.reCalculateMasonry()
        },
        /* Add filter count */
        addFilterCount: function(){
            let filterList = this.container.find( '.filter-list .filter-tab' ),
                preMadeBlocksWrapper = this.preMadeBlocks;
    
            if( filterList.length > 0 ) {
                filterList.each(function(){
                    let _this = $(this),
                        tab = _this.data( 'value' ),
                        freeCount = preMadeBlocksWrapper.find( '.' + tab + '.free' ).length,
                        proCount = preMadeBlocksWrapper.find( '.' + tab + '.pro' ).length,
                        upgradeCount = preMadeBlocksWrapper.find( '.' + tab + '.upgrade' ).length;

                    _this.find( '.free-count' ).html( freeCount )
                    _this.find( '.pro-count' ).html( proCount > 0 ? proCount : upgradeCount  )
                })
            }
        },
        /* Handle Search */
        searchHandle: function() {
            let self = this

            this.searchField.on( 'change keyup', function() {
                let searchField = $(this), 
                    searched = searchField.val(),
                    preMadeBlocksWrapper = self.preMadeBlocks.find( '.template-item' );     /* Defined here because .template-item are added dynamically in preview */

                if( searched !== '' ) {
                    self.isSearch = true
                    preMadeBlocksWrapper.each(function() {
                        let _this = $(this),
                            label = _this.find( '.block-label' ).text().toLowerCase();
                        
                        if( label.includes( searched.toLowerCase() ) ) {
                            _this.addClass( 'active' )
                        } else {
                            _this.removeClass( 'active' )
                        }
                    })
                    /* Reset to all in Dropdown */
                    self.activeFilter = 'all'
                    self.container.find( '.filter-tab' ).removeClass( 'active' )
                    self.container.find( '.active-filter .filter-text' ).text( 'All' )
                } else {
                    self.isSearch = false
                    preMadeBlocksWrapper.show()
                    preMadeBlocksWrapper.removeClass( 'active' )
                    self.reCalculateMasonry()
                }
                if( self.isSearch ) self.filterBlocks()
            })
        },
        /* Add masonry effect */
        addMasonry: function(){
            let masonryInstance = GLOBAL.initMasonry({
                element: this.preMadeBlocks,
                selector: '.template-item'
            })
            this.masonryInstance = masonryInstance
    
            this.preMadeBlocks.find( 'img[loading="lazy"]' ).not( '.loaded' ).on( 'load', function(){
                masonryInstance.masonry( "layout" );
                $( this ).addClass( 'loaded' )
            });
        },
        /* Recalculate masonry */
        reCalculateMasonry: function(){
            if( this.masonryInstance !== '' ) this.masonryInstance.masonry( 'layout' )
        },
        /* Destroy Masonry */
        destroyMasonry: function(){
            if( this.masonryInstance !== '' ) this.masonryInstance.masonry( 'destroy' )
        },
        /* Make filter tab header sticky */
        filterTabHeaderSticky: function() {
            let container = this.container.parent(),
                containerEndsAt = container.offset().top + container.height() - 25;

            $( document ).on( 'scroll', function(){
                let _this = $( this ),
                    scrollTop = _this.scrollTop();

                if( scrollTop >= containerEndsAt ) {
                    container.addClass( 'is-sticky' )
                } else {
                    container.removeClass( 'is-sticky' )
                }
            })
        }
    }   /* End of PreMadeBlocks */
}(jQuery));