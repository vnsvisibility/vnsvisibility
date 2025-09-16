/** Meta Boxes - Widgets **/
jQuery(function($){
	"use strict";
	
	$(document).on('click', '.blogone_meta_box_upload_button', function(){
		var button = $(this);
		var clear_button = button.siblings('.blogone_meta_box_clear_image_button');
		var input_field = button.siblings('.upload_field');   
		wp.media.editor.send.attachment = function(props, attachment){
			var attachment_url = '';
			attachment_url = attachment.sizes[props.size].url;
			input_field.val(attachment_url);
			if( input_field.siblings('.preview-image').length > 0 ){
				input_field.siblings('.preview-image').attr('src', attachment_url);
			}
			else{
				var img_html = '<img class="preview-image" src="' + attachment_url + '" />';
				input_field.parent().append(img_html);
			}
			clear_button.attr('disabled', false);
			input_field.trigger('change'); /* For widget */
		}
		wp.media.editor.open(button);
	}); 
	
	$(document).on('click', '.blogone_meta_box_clear_image_button', function(){
		var button = $(this);
		button.attr('disabled', true);
		button.siblings('.upload_field').val('');
		button.siblings('.preview-image').fadeOut(250, function(){
			button.siblings('.preview-image').remove();
		});
		button.siblings('.upload_field').trigger('change'); /* For widget */
	});
	
	$(document).on('change', '.blogone-meta-box-field .upload_field, .widget .upload_field', function(){
		var input_field = $(this);
		var input_value = input_field.val().trim();
		if( input_value == '' ){
			input_field.siblings('.blogone_meta_box_clear_image_button').trigger('click'); /* don't loop because button is disabled */
		}
		else{
			if( input_field.siblings('.preview-image').length > 0 ){
				input_field.siblings('.preview-image').attr('src', input_value);
			}
			else{
				var img_html = '<img class="preview-image" src="' + input_value + '" />';
				input_field.parent().append(img_html);
			}
			input_field.siblings('.blogone_meta_box_clear_image_button').attr('disabled', false);
		}
	});
	
	/* Gallery */
	var file_frame;
	var _add_img_button;
	$('.blogone-gallery-box .add-image').on('click', function(event){
		event.preventDefault();
		_add_img_button = jQuery(this);
        
        if ( file_frame ) {
            file_frame.open();
            return;
        }

        var _states = [new wp.media.controller.Library({
            filterable: 'uploaded',
            title: blogone_admin_texts.select_images,
            multiple: true,
            priority:  20
        })];
			 
        file_frame = wp.media.frames.file_frame = wp.media({
            states: _states,
            button: {
                text: blogone_admin_texts.use_images
            }
        });

        file_frame.on( 'select', function() {
			var object = file_frame.state().get('selection').toJSON();
			
			var img_html = '';
			if( object.length > 0 ){
				for( var i = 0; i < object.length; i++ ){
					var image_url = object[i].url;
					if( typeof object[i].sizes.thumbnail != "undefined" ){
						image_url = object[i].sizes.thumbnail.url;
					}
					img_html += '<li class="image"><span class="del-image"></span><img src="'+image_url+'" alt="" data-id="'+object[i].id+'"/></li>';
				}
			}
			
			_add_img_button.siblings('ul.images').append(img_html);
			
			var arr_ids = new Array();
			_add_img_button.siblings('ul.images').find('li img').each(function(index, ele){
				arr_ids.push( $(ele).data('id') );
			});
			
			_add_img_button.siblings('.meta-value').val(arr_ids.join(','));
        });
		 
        file_frame.open();
	});
	
	$(document).on('click', '.blogone-gallery-box .del-image', function(){
		var image = $(this).parent('.image');
		var container = $(this).parents('.blogone-gallery-box');
		image.fadeOut(300, function(){
			image.remove();
			update_gallery_ids_field( container );
		});
	});
	
	if( typeof $.fn.sortable == 'function' ){
		$('.blogone-gallery-box .images').sortable({revert: true, update: function(e, ui){ update_gallery_ids_field($(ui.item).parents('.blogone-gallery-box')); }});
		$('.blogone-gallery-box .images').disableSelection();
	}
	
	function update_gallery_ids_field(container){
		var arr_ids = new Array();
		container.find('.images img').each(function(index, ele){
			arr_ids.push( $(ele).data('id') );
		});
		container.find('.meta-value').val( arr_ids.join(',') );
	}
	
	/* Colorpicker */
	if( typeof $.fn.wpColorPicker == 'function' ){
		var params = {
			change: function(e, ui){
				$(e.target).val( ui.color.toString() );
				$(e.target).trigger('change');
			}
		};
		$('.blogone-meta-box-field .colorpicker, #widgesc-right .colorpicker').wpColorPicker( params );
		$(document).on('widget-updated widget-added', function(e, widget){
			widget.find('.colorpicker').wpColorPicker( params );
		});
	}
	
	/* Table */
	$(document).on('click', '.blogone-meta-box-field.table .table-button', function(e){
		e.preventDefault();
		var table = $(this).closest('table');
		var action = $(this).attr('class').replace('table-button', '').replace(' ', '');
		switch( action ){
			case 'add-col':
				if( table.find('thead td').length > 20 ){
					return;
				}
				var col = $(this).parent('td');
				var index = col.parent().children('td').index(col);
				var tbody = $(this).closest('thead').siblings('tbody');
				col.after( col.clone() );
				tbody.find('tr').each(function(i, e){
					var row = $(e);
					var col = row.find('td').eq(index);
					var new_col = col.clone();
					new_col.find('input').val('');
					col.after( new_col );
				});
			break;
			case 'del-col':
				if( table.find('thead td').length == 2 ){
					return;
				}
				var col = $(this).parent('td');
				var index = col.parent().children('td').index(col);
				var tbody = $(this).closest('thead').siblings('tbody');
				col.remove();
				tbody.find('tr').each(function(i, e){
					$(e).find('td').eq(index).remove();
				});
			break;
			case 'add-row':
				var row = $(this).closest('tr');
				var new_row = row.clone();
				new_row.find('input').val('');
				row.after( new_row );
			break;
			case 'del-row':
				if( table.find('tbody tr').length == 1 ){
					return;
				}
				$(this).closest('tr').remove();
			break;
		}
		update_table_value( table );
	});
	
	$(document).on('change', '.blogone-meta-box-field.table table input', function(){
		update_table_value( $(this).closest('table') );
	});
	
	if( $('.blogone-meta-box-field.table').length ){
		$('.blogone-meta-box-field.table table').each(function(){
			update_table_value( $(this) );
		});
	}
	
	function update_table_value( table ){
		var value = new Array();
		table.find('tbody tr').each(function(){
			var row_val = new Array();
			$(this).find('input').each(function(i, e){
				row_val.push( $(e).val() );
			});
			value.push( row_val );
		});
		table.siblings('.table-value').val( JSON.stringify(value) );
	}
	
	/* Multi Select */
	$('.blogone-meta-box-field.multi-select select').on('change', function(){
		$(this).siblings('.select-value').val( $(this).val() );
	});
	
	$('.blogone-meta-box-field.multi-select select').trigger('change');
	
	if( typeof $.fn.selectWoo == 'function' ){
		$('.blogone-meta-box-field.multi-select select').selectWoo();
	}
});
/** End Meta Boxes **/

/* Post View - Edit Link */
jQuery(function($){
	"use strict";
	
	var edit_button_class = 'blogone-post-edit-button';
	var view_button_class = 'blogone-post-view-button';
	
	$(document).on('change initial', 'select.blogone-post-select', function(){
		update_post_edit_view_buttons( $(this) );
	});
	
	$('select.blogone-post-select').trigger('initial');
	
	function update_post_edit_view_buttons( sel ){
		var post_type = get_post_type( sel );
		var val = sel.val();
		
		if( sel.siblings('.select2').length ){
			sel = sel.siblings('.select2');
		}
		
		if( !sel.siblings('.' + edit_button_class).length ){
			sel.after('<a class="' + edit_button_class + '" href="#" target="_blank" style="display: none">' + blogone_admin_texts.edit_post_button_label + '</a>');
		}
		if( !sel.siblings('.' + view_button_class).length ){
			sel.after('<a class="' + view_button_class + '" href="#" target="_blank" style="display: none">' + blogone_admin_texts.view_posts_button_label + '</a>');
		}
		
		if( val != 0 && val != '' ){
			sel.siblings('.' + edit_button_class).attr('href', blogone_admin_texts.edit_post_url_pattern[post_type].replace('[post_id]', val)).show();
			sel.siblings('.' + view_button_class).hide();
		}
		else{
			sel.siblings('.' + view_button_class).attr('href', blogone_admin_texts.view_posts_url_pattern.replace('[post_type]', post_type)).show();
			sel.siblings('.' + edit_button_class).hide();
		}
	}
	
	function get_post_type( sel ){
		var post_type = 'post';
		if( sel.attr('data-post_type') ){
			post_type = sel.attr('data-post_type');
		}
		else{
			var class_str = sel.attr('class');
			var class_arr = class_str.split(' ');
			$.each( class_arr, function( i, v ){
				if( v.indexOf('post_type-') != -1 ){
					post_type = v.replace('post_type-', '');
					return false;
				}
			});
		}
		return post_type;
	}

	function media_upload(button_class) {

        var _custom_media = true,

        _orig_send_attachment = wp.media.editor.send.attachment;



        $('body').on('click', button_class, function(e) {

            var button_id ='#'+$(this).attr('id');

            var self = $(button_id);

            var send_attachment_bkp = wp.media.editor.send.attachment;

            var button = $(button_id);

            var id = button.attr('id').replace('_button', '');

            _custom_media = true;

            wp.media.editor.send.attachment = function(props, attachment){

                if ( _custom_media  ) {

                    $('.custom_media_id').val(attachment.id);                    

                    $('.custom_media_url_info').val(attachment.url);
                    $('.custom_media_url_info').change();
					
					if( $('#custom_media_image_info') ){
						$('#custom_media_image_info').attr('src', attachment.url );
					}

                    $('.custom_media_image_info').attr('src',attachment.url).css('display','block');

                } else {

                    return _orig_send_attachment.apply( button_id, [props, attachment] );

                }

            }

            wp.media.editor.open(button);
			$(this).prev().change();
                return false;

        });

    }

    media_upload('.custom_media_button_info.button');
});

( function( $ ){
    $( document ).ready( function(){
      $( '.blogone-btn-get-started' ).on( 'click', function( e ) {
          e.preventDefault();
          $( this ).html( 'Processing.. Please wait' ).addClass( 'updating-message' );
          $.post( blogone_ajax_object.ajax_url, { 'action' : 'install_act_plugin' }, function( response ){
              location.href = 'customize.php';
          } );
      } );
    } );

    $( document ).on( 'click', '.notice-get-started-class .notice-dismiss', function () {
        // Read the "data-notice" information to track which notice
        // is being dismissed and send it via AJAX
        var type = $( this ).closest( '.notice-get-started-class' ).data( 'notice' );
        // Make an AJAX call
        $.ajax( ajaxurl,
          {
            type: 'POST',
            data: {
              action: 'blogone_dismissed_notice_handler',
              type: type,
            }
          } );
      } );
}( jQuery ) );