( function( $ ) {
	"use strict";

	const { ajaxUrl, _wpnonce, loadingText } = libraryData
	const { filterTabHeader = undefined } = window

	var NekitLibraryTemplateHandler = {
		sectionIndex: null,
		importIntialize: 0,
		contentID: 0,
		
		init: function() {
			window.elementor.on( 'preview:loaded', function() {
				NekitLibraryTemplateHandler.previewLoaded()
			});
		},

		previewLoaded: function() {
			var previewIframe = window.elementor.$previewContents, libraryButton = '<div id="nekit-library-btn" class="elementor-add-section-area-button" data-demo="pages" data-filter="all"></div>';

			// Add Library Button
            var elementorAddSection = $("#tmpl-elementor-add-section"), elementorAddSectionText = elementorAddSection.text();
				elementorAddSectionText = elementorAddSectionText.replace('<div class="elementor-add-section-drag-title', libraryButton +'<div class="elementor-add-section-drag-title');
				elementorAddSection.text(elementorAddSectionText);
				
			$( previewIframe ).on( 'click', '.elementor-editor-section-settings .elementor-editor-element-add', function() {
				var addNewSectionWrap = $(this).closest( '.elementor-top-section' ).prev( '.elementor-add-section' ),
					modelID = $(this).closest( '.elementor-top-section' ).data( 'model-cid' );

				// Add Library Button
				if ( 0 == addNewSectionWrap.find( '#nekit-library-btn' ).length ) {
					setTimeout( function() {
						addNewSectionWrap.find( '.elementor-add-new-section' ).prepend( libraryButton );
					}, 110 );
				}
				
				// Set Section Index
				if ( window.elementor.elements.models.length ) {
					$.each( window.elementor.elements.models, function( index, model ) {
						if ( modelID === model.cid ) {
							NekitLibraryTemplateHandler.sectionIndex = index;
						}
					});
				}
				NekitLibraryTemplateHandler.contentID++;
			});

			NekitLibraryTemplateHandler.renderLibraryPopup( previewIframe )
		},
		renderLibraryPopup: function( previewIframe ) {
			let iBody = previewIframe.find( 'body' ),
				popContainer = previewIframe.find( "#nekit-library-btn" ),
				modalContainer = previewIframe.find( "#nekit-library-popup" ),
				blocksElement = modalContainer.find( '.inner-tab-content.blocks-tab-content' ),
				pagesElement = modalContainer.find( '.inner-tab-content.pages-tab-content' );

			/**
			 * MARK: BLOCKS TAB
			 */
			const BlocksTab = {
				mainParent: previewIframe.find( ( '.nekit-library-popup.library-popup-inner' ) ),
				blocksFilterTabHeaderInstance: { ...filterTabHeader },
				init: function() {
					if( this.mainParent.length > 0 ) {
						this.blocksFilterTabHeaderInstance.container = this.mainParent.find( '.blocks-tab-content .widgets-category-title-filter' )
						this.blocksFilterTabHeaderInstance.searchField = this.blocksFilterTabHeaderInstance.container.siblings( '.search-wrapper' ).find( 'input[type="search"]' );
						this.blocksFilterTabHeaderInstance.preMadeBlocks = this.blocksFilterTabHeaderInstance.container.parent().siblings();
						this.blocksFilterTabHeaderInstance.freeProButtons = this.blocksFilterTabHeaderInstance.container.siblings( '.free-pro-filter-tabs' );
		
						this.blocksFilterTabHeaderInstance.activeFilterHandle();
						this.blocksFilterTabHeaderInstance.handleFilterClick();
						this.blocksFilterTabHeaderInstance.handleFreeProClick();
						this.blocksFilterTabHeaderInstance.searchHandle();
					}
				}
			}   /* End of BlocksTab */
			BlocksTab.init()

			/**
			 * MARK: PAGES TAB
			 */
			const PagesTab = {
				mainParent: previewIframe.find( ( '.nekit-library-popup.library-popup-inner' ) ),
				pagesFilterTabHeaderInstance: { ...filterTabHeader },
				init: function(){
					if( this.mainParent.length > 0 ) {
						this.pagesFilterTabHeaderInstance.container = this.mainParent.find( '.pages-tab-content .widgets-category-title-filter' )
						this.pagesFilterTabHeaderInstance.searchField = this.pagesFilterTabHeaderInstance.container.siblings( '.search-wrapper' ).find( 'input[type="search"]' );
						this.pagesFilterTabHeaderInstance.preMadeBlocks = this.pagesFilterTabHeaderInstance.container.parent().siblings();
						this.pagesFilterTabHeaderInstance.freeProButtons = this.pagesFilterTabHeaderInstance.container.siblings( '.free-pro-filter-tabs' );
		
						this.pagesFilterTabHeaderInstance.activeFilterHandle();
						this.pagesFilterTabHeaderInstance.handleFilterClick();
						this.pagesFilterTabHeaderInstance.handleFreeProClick();
						this.pagesFilterTabHeaderInstance.searchHandle();
					}
				}
			}   /* End of PagesTab */
			PagesTab.init()

			/**
			 * MARK: LIBRARY
			 */
			const Library = {
				mainParent: previewIframe.find( ( '.nekit-library-popup.library-popup-inner' ) ),
				init: function() {
					if( this.mainParent.length > 0 ) {
						this.handleTabsClick()
						this.closeLibrary()
					}
				},
				/* Handle Tab click "Blocks" Or "Pages" */
				handleTabsClick: function(){
					let self = this
					this.mainParent.find( '.templates-tabs .tab-title' ).on( 'click', function(){
						let _this = $( this ),
							tab = _this.data( 'tab' )

						_this.addClass( 'isActive' ).siblings().removeClass( 'isActive' )
						if( tab === 'blocks' ) {
							self.mainParent.find( '.inner-tab-content.blocks-tab-content' ).show().siblings().hide()
							BlocksTab.blocksFilterTabHeaderInstance.reCalculateMasonry()
						} else {
							self.mainParent.find( '.inner-tab-content.pages-tab-content' ).show().siblings().hide()
							PagesTab.pagesFilterTabHeaderInstance.reCalculateMasonry()
						}
					})
				},
				/* Close Library Model */
				closeLibrary: function(){
					this.mainParent.find( '.popup-close-trigger' ).on( 'click', function(){
						let _this = $( this )
						_this.parents( "#nekit-library-popup" ).removeClass( "modal-active" )
						iBody.removeClass( 'nekit-library-active' )
						$e.run( 'panel/open' );
					})
				},
			}   /* End of PreMadeBlocks */
			Library.init();

			/**
			 * MARK: PREVIEW NEKIT LOGO
			 */
			previewIframe.on( "click", "#nekit-library-btn", function(e) {
				e.preventDefault()
				$e.run( 'panel/close' );
				iBody.addClass( 'nekit-library-active' )

				let popContainer = window.elementor.$previewContents.find("#nekit-library-btn"), 
					demo = popContainer[0].attributes['data-demo'].value, 	/* blocks || pages */
					filter = popContainer[0].attributes['data-filter'].value;	/* widget categories */
				Library.mainParent.find( `.templates-tabs .tab-title[data-tab="${ demo }"]` ).addClass( 'isActive' ).siblings().removeClass( 'isActive' )

				if( iBody.hasClass( 'nekit-library-added' ) ) {
					/* Prevent ajax call to execute a second time. */
					iBody.find( "#nekit-library-popup" ).addClass( "modal-active" )
					previewIframe.find( ( `.nekit-library-popup.library-popup-inner .inner-tab-content.${ demo }-tab-content` ) ).show().siblings().hide()
					if( demo === 'blocks' ) {
						blocksElement.find( `.widgets-category-title-filter .filter-list .filter-tab[data-value="${ filter }"]` ).trigger( 'click' )
					} else {
						pagesElement.find( `.widgets-category-title-filter .filter-list .filter-tab[data-value="${ filter }"]` ).trigger( 'click' )
					}
				} else {
					/* Ajax call */
					$.ajax({
						method: 'POST',
						url: ajaxUrl,
						data: {
							action: 'nekit_render_popup_modal',
							_wpnonce: _wpnonce
						},
						beforeSend: function() {
							popContainer.attr( "disabled", true )
							modalContainer.addClass( "modal-active" )
							modalContainer.find( "#nekit-elementor-loading" ).show()
						},
						success : function( response ) {
							let { data, success } = response
							if( success && data.loaded ) {

								modalContainer.find( "#nekit-elementor-loading" ).hide()

								let nekitData = data.nekitData,
									{ blocks, pages } = nekitData,
									{ filterList: blocksFilterList, demos: blocksDemos } = blocks,
									{ filterList: pagesFilterList, demos: pagesDemos } = pages;

								blocksElement.find( '.widgets-category-title-filter .filter-list' ).append( blocksFilterList )
								pagesElement.find( '.widgets-category-title-filter .filter-list' ).append( pagesFilterList )

								blocksElement.find( '.tab-content-wrap' ).append( $( blocksDemos ) )
								pagesElement.find( '.tab-content-wrap' ).append( $( pagesDemos ) )

								PagesTab.pagesFilterTabHeaderInstance.addFilterCount();
								BlocksTab.blocksFilterTabHeaderInstance.addFilterCount();

								BlocksTab.blocksFilterTabHeaderInstance.preMadeBlocks = blocksElement.find( '.tab-content-wrap' )
								BlocksTab.blocksFilterTabHeaderInstance.addMasonry()
								PagesTab.pagesFilterTabHeaderInstance.preMadeBlocks = pagesElement.find( '.tab-content-wrap' )
								PagesTab.pagesFilterTabHeaderInstance.addMasonry()

								iBody.addClass( 'nekit-library-added' )

								previewIframe.find( ( `.nekit-library-popup.library-popup-inner .inner-tab-content.${ demo }-tab-content` ) ).show().siblings().hide()
								if( demo === 'blocks' ) {
									blocksElement.find( `.widgets-category-title-filter .filter-list .filter-tab[data-value="${ filter }"]` ).trigger( 'click' )
								} else {
									pagesElement.find( `.widgets-category-title-filter .filter-list .filter-tab[data-value="${ filter }"]` ).trigger( 'click' )
								}
								if( NekitLibraryTemplateHandler.importIntialize == 0 ) import_data( previewIframe )
							}
						},
						complete: function( res ) {
							console.log( 'completed' )
						}
					})
				}

				window.elementor.$previewContents.find("#nekit-library-btn").attr( "data-demo", "pages" )
				window.elementor.$previewContents.find("#nekit-library-btn").attr( "data-filter", "all" )
			})
		}
	};

	/**
	 * MARK: import widget data ajax action
	 */
	function import_data(container) {
		var popupCloseElem = container.find( ".popup-close-trigger" )
		container.on( "click", ".template-item .insert-data", function(e) {
			e.preventDefault()
			NekitLibraryTemplateHandler.importIntialize = 1
			var button = $(this), demo = button.data("route")
			$.ajax({
                method: 'POST',
                url: ajaxUrl,
                data: {
                    action: 'nekit_import_widget_library_data',
                    demo: demo,
                    _wpnonce: _wpnonce
                },
                beforeSend: function() {
					button.attr( "disabled", true )
					button.addClass( 'loading' )
                },
                success : function(res) {
					if( res.success ) {
						button.removeClass( 'loading' )
						var parsedRes = res.data
						window.elementor.getPreviewView().addChildModel( parsedRes.content, { at: NekitLibraryTemplateHandler.sectionIndex } );
						NekitLibraryTemplateHandler.sectionIndex = null
						// trigger update post button
						window.elementor.panel.$el.find('#elementor-panel-footer-saver-publish button').removeClass('elementor-disabled');
						window.elementor.panel.$el.find('#elementor-panel-footer-saver-options button').removeClass('elementor-disabled');

						popupCloseElem.click()
						$e.run( 'panel/open' );
						button.attr( "disabled", false )
					}
                }
            })
		})
	}

	$( window ).on( 'elementor:init', NekitLibraryTemplateHandler.init );
}( jQuery ) );