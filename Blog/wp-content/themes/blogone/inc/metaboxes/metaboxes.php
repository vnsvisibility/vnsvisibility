<?php 
/*** Metaboxes class ***/
class Blogone_Metaboxes{
	function __construct(){
		if( is_admin() ){
			add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
			add_action('save_post', array($this, 'save_meta_boxes'));
		}
	}
	
	function add_meta_boxes(){
		$datas = array(
					array(
						'id' 			=> 'post_options'
						,'label' 		=> esc_html__('Post Options', 'blogone')
						,'post_type'	=> 'post'
					),
					array(
						'id'			=> 'post_gallery'
						,'label'		=> esc_html__('Post Gallery', 'blogone')
						,'post_type'	=> 'post'
						,'context'		=> 'side'
						,'priority'		=> 'low'
					)
				);
		$this->add_meta_box($datas);
	}
	
	function add_meta_box( $datas ){
		foreach( $datas as $data ){
			$context = 'normal';
			$priority = 'high';
			if( isset($data['context']) ){
				$context = $data['context'];
			}
			if( isset($data['priority']) ){
				$priority = $data['priority'];
			}
			add_meta_box($data['id'], $data['label'], array($this, 'meta_box_callback'), $data['post_type'], $context, $priority, array('file_name'=>$data['id']));
		}
	}
	
	function save_meta_boxes( $post_id ){
		if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
			return;
		}
		
		if( wp_is_post_revision($post_id) ){
			return;
		}
		
		if( isset($_POST['post_type']) ){
			if ( 'page' == $_POST['post_type'] ) {
				if ( !current_user_can('edit_page', $post_id) ) {
					return $post_id;
				}
			} else {
				if ( !current_user_can('edit_post', $post_id) ) {
					return $post_id;
				}
			}
		}

		foreach( $_POST as $key => $value ){
			if( strpos($key, 'blogone_') !== false ){
				update_post_meta($post_id, $key, $value);
			}
		}
	}
	
	function meta_box_callback( $post, $para ){
		$file_name = isset($para['args']['file_name'])?$para['args']['file_name']:'';
		$file = $file_name.'.php';
		$options = array();
		include $file;
		$options = apply_filters('blogone_metabox_options_'.$file_name, $options);
		$this->generate_field_html($options);
	}

	function generate_field_html( $options ){
		global $post;
		$defaults = array(
							'id'			=> ''
							,'label' 		=> ''
							,'desc'			=> ''
							,'type'			=> 'text'
							,'options'		=> array() /* Use for select box */
							,'default'		=> ''
							);
		foreach( $options as $option ){
			$option = wp_parse_args($option, $defaults);
			
			if( $option['id'] == '' )
				continue;
			
			$post_meta_value = get_post_meta($post->ID, 'blogone_'.$option['id'], true);
			if( $post_meta_value == '' )
				$post_meta_value = $option['default'];
			$html = '';
			
			switch( $option['type'] ){
				case 'text':
					$html .= '<div class="blogone-meta-box-field">';
						$html .= '<label for="blogone_'.$option['id'].'">'.$option['label'].'</label>';
						$html .= '<div class="field">';
							$html .= '<input type="text" name="blogone_'.$option['id'].'" id="blogone_'.$option['id'].'" value="'.$post_meta_value.'" />';
							if( strlen($option['desc']) > 0 ){
								$html .= '<p class="description">'.$option['desc'].'</p>';
							}
						$html .= '</div>';
					$html .= '</div>';
				break;
				
				case 'select':
					$select_post = isset($option['select_post']) ? $option['select_post'] : '';
				
					$html .= '<div class="blogone-meta-box-field">';
						$html .= '<label for="blogone_'.$option['id'].'">'.$option['label'].'</label>';
						$html .= '<div class="field">';
							$html .= '<select name="blogone_'.$option['id'].'" id="blogone_'.$option['id'].'" '.($select_post ? 'class="blogone-post-select" data-post_type="'.$select_post.'"' : '').'>';
							foreach( $option['options'] as $key => $value ){
								$html .= '<option value="'.$key.'" '.selected($key, $post_meta_value, false).'>'.$value.'</option>';
							}
							$html .= '</select>';
							if( strlen($option['desc']) > 0 ){
								$html .= '<p class="description">'.$option['desc'].'</p>';
							}
						$html .= '</div>';
					$html .= '</div>';
				break;
				
				case 'multi_select':
					wp_enqueue_script('selectWoo');
					if( $post_meta_value ){
						$post_meta_value = explode(',', $post_meta_value);
					}
					if( !is_array($post_meta_value) ){
						$post_meta_value = array();
					}
					$html .= '<div class="blogone-meta-box-field multi-select">';
						$html .= '<label for="blogone_'.$option['id'].'">'.$option['label'].'</label>';
						$html .= '<div class="field">';
							$html .= '<input type="hidden" name="blogone_'.$option['id'].'" class="select-value" value="" />';
							$html .= '<select id="blogone_'.$option['id'].'" multiple="multiple">';
							foreach( $option['options'] as $key => $value ){
								$html .= '<option value="'.$key.'" '. (in_array($key, $post_meta_value)?'selected="selected"':'') .'>'.$value.'</option>';
							}
							$html .= '</select>';
							if( strlen($option['desc']) > 0 ){
								$html .= '<p class="description">'.$option['desc'].'</p>';
							}
						$html .= '</div>';
					$html .= '</div>';
				break;
				
				case 'textarea':
					$html .= '<div class="blogone-meta-box-field">';
						$html .= '<label for="blogone_'.$option['id'].'">'.$option['label'].'</label>';
						$html .= '<div class="field">';
							$html .= '<textarea name="blogone_'.$option['id'].'" id="blogone_'.$option['id'].'">'.$post_meta_value.'</textarea>';
						if( strlen($option['desc']) > 0 ){
							$html .= '<p class="description">'.$option['desc'].'</p>';
						}
						$html .= '</div>';
					$html .= '</div>';
				break;
				
				case 'editor':
					$html .= '<div class="blogone-meta-box-field">';
						$html .= '<label for="blogone_'.$option['id'].'">'.$option['label'].'</label>';
						$html .= '<div class="field">';
							$editor_settings = array(
								'textarea_name' => 'blogone_' . $option['id']
								,'editor_css' 	=> '<style>#wp-blogone_' . $option['id'] . '-editor-container .wp-editor-area{height:175px;}</style>'
							);
							ob_start();
								wp_editor( $post_meta_value, 'blogone_' . $option['id'], $editor_settings );
							$html .= ob_get_clean();
						if( strlen($option['desc']) > 0 ){
							$html .= '<p class="description">'.$option['desc'].'</p>';
						}
						$html .= '</div>';
					$html .= '</div>';
				break;
				
				case 'upload':
					$post_meta_value = trim($post_meta_value);
					$html .= '<div class="blogone-meta-box-field">';
						$html .= '<label for="blogone_'.$option['id'].'">'.$option['label'].'</label>';
						$html .= '<div class="field">';
							$html .= '<input type="text" class="upload_field" name="blogone_'.$option['id'].'" id="blogone_'.$option['id'].'" value="'.$post_meta_value.'" />';
							$html .= '<input type="button" class="blogone_meta_box_upload_button" value="'.esc_attr__('Select Image', 'blogone').'" />';
							$html .= '<input type="button" class="blogone_meta_box_clear_image_button" value="'.esc_attr__('Clear Image', 'blogone').'" '.($post_meta_value?'':'disabled').' />';
						if( strlen($option['desc']) > 0 ){
							$html .= '<p class="description">'.$option['desc'].'</p>';
						}
						if( $post_meta_value ){
							$html .= '<img class="preview-image" src="'.$post_meta_value.'" />';
						}
						$html .= '</div>';
					$html .= '</div>';
				break;
				
				case 'heading':
					$html .= '<div class="blogone-meta-box-field blogone-heading-box">';
						$html .= '<h2 class="blogone-meta-box-heading">'.$option['label'].'</h2>';
						if( strlen($option['desc']) > 0 ){
							$html .= '<p class="description">'.$option['desc'].'</p>';
						}
					$html .= '</div>';
				break;
				
				case 'gallery':
					$attachment_ids = array();
					if( $post_meta_value != '' ){
						$attachment_ids = explode(',', $post_meta_value);
					}
					
					$html .= '<div class="blogone-meta-box-field blogone-gallery-box '.(isset($option['class'])?$option['class']:'').'">';
						$html .= '<ul class="images">';
							foreach( $attachment_ids as $attachment_id ){
							$html .= '<li class="image">';
								$html .= '<span class="del-image"></span>';
								$html .= wp_get_attachment_image( $attachment_id, 'thumbnail', false, array('data-id'=> $attachment_id) );
							$html .= '</li>';
							}
						$html .= '</ul>';
						$html .= '<input type="hidden" class="meta-value" name="blogone_'.$option['id'].'" id="blogone_'.$option['id'].'" value="'.$post_meta_value.'" />';
						$html .= '<a href="#" class="add-image">'.esc_html__('Add Images', 'blogone').'</a>';
					$html .= '</div>';
				break;
				
				case 'colorpicker':
					$html .= '<div class="blogone-meta-box-field">';
						$html .= '<label for="blogone_'.$option['id'].'">'.$option['label'].'</label>';
						$html .= '<div class="field">';
							$html .= '<input type="text" class="colorpicker" name="blogone_'.$option['id'].'" id="blogone_'.$option['id'].'" value="'.$post_meta_value.'" />';
							if( strlen($option['desc']) > 0 ){
								$html .= '<p class="description">'.$option['desc'].'</p>';
							}
						$html .= '</div>';
					$html .= '</div>';
				break;
				
				case 'table':
					if( $post_meta_value ){
						$post_meta_value = json_decode( $post_meta_value, true );
					}
					if( !is_array($post_meta_value) ){
						$post_meta_value = array( array('', ''), array('', '') );
					}
					$number_col = count($post_meta_value[0]);
					$html .= '<div class="blogone-meta-box-field table">';
						$html .= '<label for="blogone_'.$option['id'].'">'.$option['label'].'</label>';
						$html .= '<div class="field">';
							$html .= '<input type="hidden" name="blogone_'.$option['id'].'" class="table-value" value="" />';
							$html .= '<table id="blogone_'.$option['id'].'">';
								$html .= '<thead><tr>';
									for( $i = 0; $i < $number_col; $i++ ){
										$html .= '<td>';
										$html .= '<a href="#" class="add-col table-button">+</a>';
										$html .= '<a href="#" class="del-col table-button">-</a>';
										$html .= '</td>';
									}
									$html .= '<td></td>';
								$html .= '</tr></thead>';
								
								$html .= '<tbody>';
									foreach( $post_meta_value as $row ){
										$html .= '<tr>';
										foreach( $row as $value ){
											$html .= '<td>';
											$html .= '<input type="text" value="'.str_replace('"', '&quot;', $value).'">';
											$html .= '</td>';
										}
											$html .= '<td>';
											$html .= '<a href="#" class="add-row table-button">+</a>';
											$html .= '<a href="#" class="del-row table-button">-</a>';
											$html .= '</td>';
										$html .= '</tr>';
									}
								$html .= '</tbody>';
								
							$html .= '</table>';
							if( strlen($option['desc']) > 0 ){
								$html .= '<p class="description">'.$option['desc'].'</p>';
							}
						$html .= '</div>';
					$html .= '</div>';
				break;
				
				default:
				break;
			}
			
			echo trim($html);
		}
	}	
}

new Blogone_Metaboxes();
?>