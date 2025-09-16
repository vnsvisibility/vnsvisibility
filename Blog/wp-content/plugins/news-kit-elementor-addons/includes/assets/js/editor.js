// Handles the event in editor panel
(function( $ ) {//TODO: manage comments
	"use strict";

	const NekitPanelHandler = {
		init: function() {
			// add upsell button to pro widgets
			$(document).on( "click", "#elementor-panel .nekit-icon-pro", function() {
				$("body").find(".dialog-widget .dialog-buttons-wrapper").append( '<a class="elementor-button go-pro dialog-button dialog-action dialog-buttons-action nekit-upsell-button" href="https://blazethemes.com/news-kit-elementor-addons/" target="_blank">Upgrade To Pro</a>' )
			})

			// Helper to get the control by id
			const getEditorControlView = function( id ) {
				const editor = elementor.getPanelView().getCurrentPageView();
				var model = editor.content.currentView.collection.findWhere({
					name: id
				});
				return editor.content.currentView.children.findByModelCid( model.cid );
			};

			$e.routes.on('run:after', (component, route) => {
				if( 'panel/global/nekit-settings-preloader' == route ) {
					const preloaderOptionControlView = getEditorControlView( 'nekit_preloader_option' );
					const preloaderIconControlView = getEditorControlView( 'nekit_preloader_icon' );
					const preloaderAnimationTypeControlView = getEditorControlView( 'nekit_preloader_image_icon_animation_type' );
					const preloaderCustomAnimationTypeControlView = getEditorControlView( 'nekit_preloader_animation_type' );
					const preloaderImageControlView = getEditorControlView( 'nekit_preloader_image' );
					const elementorPreviewContainer = elementor.$previewContents
					const preloaderPreviewContainer = elementorPreviewContainer.find("#nekit-preloader-elm")
					if( ! preloaderPreviewContainer.hasClass( "nekit-preloader-animation-type--none" ) ) {
						preloaderPreviewContainer.show()
					}
					// Attach your listeners
					preloaderOptionControlView.on( "settings:change", function() {
						// on control value change
						const newValue = this.getControlValue()
						switch(newValue) {
							case 'animation': preloaderPreviewContainer.removeClass( "nekit-preloader-animation-type--icon nekit-preloader-animation-type--image" )
												preloaderPreviewContainer.addClass( "nekit-preloader-animation-type--animation" )
												preloaderPreviewContainer.show()
												break;
							case 'icon': preloaderPreviewContainer.removeClass( "nekit-preloader-animation-type--animation nekit-preloader-animation-type--image" )
											preloaderPreviewContainer.addClass( "nekit-preloader-animation-type--icon" )
											preloaderPreviewContainer.show()
												break;
							case 'image': preloaderPreviewContainer.removeClass( "nekit-preloader-animation-type--icon nekit-preloader-animation-type--animation" )
											preloaderPreviewContainer.addClass( "nekit-preloader-animation-type--image" )
											preloaderPreviewContainer.show()
												break;
							default:
									preloaderPreviewContainer.removeClass( "nekit-preloader-animation-type--icon nekit-preloader-animation-type--image nekit-preloader-animation-type--animation" )
									preloaderPreviewContainer.addClass( "nekit-preloader-animation-type--none" )
									preloaderPreviewContainer.hide()
						}
					})

					// on icon picker change
					preloaderIconControlView.on( "settings:change", function(model) {
						// on control value change
						const newIconValue = this.getControlValue()
						preloaderPreviewContainer.find(".preloader-item.preloader-icon").removeClass().addClass( "preloader-item preloader-icon " + newIconValue.value )
					})

					// on animation type change
					preloaderAnimationTypeControlView.on( "settings:change", function(model) {
						// on control value change
						const newTypeValue = this.getControlValue()
						preloaderPreviewContainer.removeClass(function (index, css) {
							return (css.match (/\bnekit-preloader-icon-image-animation--\S+/g) || []).join(' '); // removes anything that starts with "page-"
						});
						preloaderPreviewContainer.addClass( "nekit-preloader-icon-image-animation--" + newTypeValue )
					})

					// on image 
					preloaderImageControlView.on( "settings:change", function(model) {
						// on control value change
						const newTypeValue = this.getControlValue()
						preloaderPreviewContainer.find(".preloader-item.preloader-image").attr("src",newTypeValue.url)
					})

					// on custom animation type change
					preloaderCustomAnimationTypeControlView.on( "settings:change", function(model) {
						// on control value change
						const newCustomTypeValue = this.getControlValue()
						preloaderPreviewContainer.find(".preloader-item.preloader-custom").remove()
						switch(newCustomTypeValue) {
							case 'packman': preloaderPreviewContainer.append('<div class="preloader-item preloader-custom nekit-packman"><div class="packman-wrap"></div><div class="dots"><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div></div></div>');
										break;
							case 'dot-loader': preloaderPreviewContainer.append('<div class="preloader-item preloader-custom nekit-dot-loading-area"><div class="nekit-dot-loader"><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
										break;
							case 'bar-loader': preloaderPreviewContainer.append('<div class="preloader-item preloader-custom nekit-bar-loader"><div class="nekit-bar-center nekit-bar-loading"></div></div>');
										break;
							case 'circle-loader-new': preloaderPreviewContainer.append('<div class="preloader-item preloader-custom nekit-circle-loading-new-wrap"><div class="nekit-circle-loading-new">Loading<span></span></div></div>');
										break;
							case 'progress-bar': preloaderPreviewContainer.append('<div class="preloader-item preloader-custom nekit-bar-loader-new"><span class="nekit-bar-loader-new nekit-bar-inner-loader"></span></div>');
												break;
							case 'dot-wave': preloaderPreviewContainer.append('<div class="preloader-item preloader-custom nekit-dot-wave-wrap"><span class="nekit-dot-wave"></span><span class="nekit-dot-wave"></span><span class="nekit-dot-wave"></span><span class="nekit-dot-wave"></span></div>');
											break;
							case 'gooey-effect': preloaderPreviewContainer.append('<div class="preloader-item preloader-custom nekit-gooey-wrap"><div class="nekit-gooey-ball nekit-gooey-ball-1"></div><div class="nekit-gooey-ball nekit-gooey-ball-2"></div><div class="nekit-gooey-ball nekit-gooey-ball-3"></div></div>');
											break;
							case 'cardle-loader': preloaderPreviewContainer.append('<div class="preloader-item preloader-custom nekit-newtons-cradle"><div class="nekit-newtons-cradle__dot"></div><div class="nekit-newtons-cradle__dot"></div><div class="nekit-newtons-cradle__dot"></div><div class="nekit-newtons-cradle__dot"></div></div>');
											break;
							default: preloaderPreviewContainer.append('<div class="preloader-item preloader-custom nekit-preload-circle"></div>');
						}
					})
				} else {
					elementor.$previewContents.find("#nekit-preloader-elm").hide()
				}
			})
			
			elementor.channels.editor.on( "nekitPreloader:preview", function() {
				console.log( 'previewLoader' )
				elementor.$previewContents.find("#nekit-preloader-elm").hide()
				setTimeout(function() {
					elementor.$previewContents.find("#nekit-preloader-elm").show()
				}, 1000)
			})

			// Make our custom css visible in the panel's front-end
			elementor.hooks.addFilter( 'editor/style/styleText', function( css, context ) {
				if ( ! context ) {
					return;
				}
				var model = context.model,
					customCSS = model.get('settings').get('nekit_custom_css');
				var selector = '.elementor-element.elementor-element-' + model.get('id');
				
				if ( 'document' === model.get('elType') ) {
					selector = elementor.config.document.settings.cssWrapperSelector;
				}

				if ( customCSS ) {
					css += customCSS.replace(/selector/g, selector);
				}
				return css;
			});

			for (const [key, value] of Object.entries(editorObject.registered_modules)) {
				elementor.hooks.addAction( 'panel/open_editor/widget/nekit-'+ key, function( panel, model, view ) {
					openPedefinedStyles( panel.$el, view.$el, value );
				});
			}
			NekitPanelHandler.addPanelHandlers()
		},
		addPanelHandlers: function() {
			elementor.on( 'preview:loaded', function() {
				NekitPanelHandler.savePreviewSettings()
			})
		},
		savePreviewSettings: function() {
			elementor.panel.$el.on( 'click', '.nekit-button-actions .nekit-save-preview-settings', function() {
				$e.run('document/save/auto', {
					force: true,
					onSuccess: function onSuccess() {
						elementor.dynamicTags.cleanCache();
						const isInitialDocument = elementor.config.initial_document.id === elementor.documents.getCurrentId();
						if (isInitialDocument) {
							// Page templates (e.g. single) with header/footer requires a full reload in order
							// to change the main query also for them.
							elementor.reloadPreview();
						} else {
							$e.internal('editor/documents/attach-preview');
						}
					}
				})
			});
		}
	}
	
	// get popup content
	function openPedefinedStyles(panel, previewContainer, value) {
		panel.on( 'click.viewDemo', '.elementor-control-widget_actions .preview-library-button', function(e) {
			e.preventDefault()
			previewContainer.closest("body").find("#nekit-library-btn").attr( "data-demo", "blocks" )
			previewContainer.closest("body").find("#nekit-library-btn").attr( "data-filter", value.category )
			previewContainer.closest("body").find("#nekit-library-btn").trigger("click")
			panel.off( 'click.viewDemo' )
		});
	}

	/**
	 * MARK: NEKIT POPUP
	 */
	const NekitPopupHandler = {
		init: function(){
			/* On Preview Load */
			window.elementor.on( 'preview:loaded', this.previewLoad );

			/* On Congrol change */
			elementor.settings.page.model.on( 'change', this.onControlChange );
		},
		/* Called when preview is loaded */
		previewLoad: function(){
			if( window.elementorFrontend && elementorFrontend.hooks !== undefined ) {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function( $scope ) {
					let popup = $scope.closest( '.nekit-template-popup' ),
						currentSettings = elementor.settings.page.model.attributes
					
					/* Add as-top-bar class */
					if( 'nekit_display_as' in currentSettings ) popup.addClass( 'as-' + currentSettings[ 'nekit_display_as' ] )
				});
			}
		},
		/* Called when control values changes */
		onControlChange: function( model ){
			let iframe = document.getElementById( 'elementor-preview-iframe' ),
				iframeContent = iframe.contentDocument || iframe.contentWindow.document,
				isPopupBuilder = $( '.nekit-popover-preview', iframeContent );

			if( isPopupBuilder.length > 0 ) {
				let popup = $( '.nekit-template-popup', iframeContent );
				
				/* Display As */
				if ( model.changed.hasOwnProperty( 'nekit_display_as' ) ) {
					popup.removeClass( 'as-modal as-top-bar' ).addClass( 'as-' + model.changed[ 'nekit_display_as' ] )
				}
	
				/* Entrance animation */
				if ( model.changed.hasOwnProperty( 'nekit_popup_entrance_animation' ) ) {
					popup.find( '.nekit-popup-inner-container' ).addClass( 'animated ' + model.changed[ 'nekit_popup_entrance_animation' ] )
				}
			}
		}
	}

	/**
	 * MARK: INIT
	 */
	$(window).on( 'elementor:init', function(){
		NekitPanelHandler.init()
		NekitPopupHandler.init()
	});
}(jQuery));