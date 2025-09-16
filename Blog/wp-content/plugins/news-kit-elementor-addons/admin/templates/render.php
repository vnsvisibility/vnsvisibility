<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Nekit_Render_Templates setup
 *
 * @since 1.0
 */
class Nekit_Render_Templates_Html {
	/**
	** Current Builder Id.
	*/
	private $current_builder_id;

	function set_current_builder_id($id) {
		$this->current_builder_id = $id;
	}

	public function get_current_builder_id() {
		return $this->current_builder_id;
	}
    /**
    ** Check if a Template has Conditions
    */
	public function is_template_available($type) {
		if( is_page() ) {
			if( $type == 'header' ) {
				$child_page = is_front_page() ? 'singular-frontpage' : 'singular-page';
				$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => $child_page]);
				if( $page_header ) {
					if( get_post_status($page_header) ) {
						$this->current_builder_id = $page_header;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'footer' ) {
				$child_page = is_front_page() ? 'singular-frontpage' : 'singular-page';
				$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => $child_page]);
				if( $page_footer ) {
					if( get_post_status($page_footer) ) {
						$this->current_builder_id = $page_footer;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'single' ) {
				$child_page = is_front_page() ? 'frontpage' : 'pages-nekitallnekit';
				$single_template = nekit_get_conditions_settings_builder_id(['parent' => 'single-builder','child' => $child_page]);
				if( $single_template ) {
					if( get_post_status($single_template) ) {
						$this->current_builder_id = $single_template;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'popup' ) {
				$child_page = is_front_page() ? 'singular-frontpage' : 'singular-page';
				$popup_templates = nekit_get_conditions_settings_builder_id([ 'parent' => 'popup-builder', 'child' => $child_page ]);
				if( ! empty( $popup_templates ) && is_array( $popup_templates ) ) :
					foreach( $popup_templates as $popup_template_id ) :
						if( get_post_status( $popup_template_id ) ) :
							$this->current_builder_id[] = $popup_template_id;
						else :
							continue;
						endif;
					endforeach;
					return ( ! empty( $this->current_builder_id ) ) ? true : false;
				else:
					return false;
				endif;
			}
		} else if( is_single() ) {
			if( $type == 'header' ) {
				$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => ( ( 'post' === get_post_type() ) ? 'singular-post' : 'singular-all' ) ]);
				if( $page_header ) {
					if( get_post_status($page_header) ) {
						$this->current_builder_id = $page_header;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'footer' ) {
				$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => ( ( 'post' === get_post_type() ) ? 'singular-post' : 'singular-all' ) ]);
				if( $page_footer ) {
					if( get_post_status($page_footer) ) {
						$this->current_builder_id = $page_footer;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'single' ) {
				$single_template = nekit_get_conditions_settings_builder_id(['parent' => 'single-builder','child' => ( ( 'post' === get_post_type() ) ? 'posts-nekitallnekit' : 'singular-all' ) ]);
				if( $single_template ) {
					if( get_post_status($single_template) ) {
						$this->current_builder_id = $single_template;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'popup' ) {
				$popup_templates = nekit_get_conditions_settings_builder_id([ 'parent' => 'popup-builder', 'child' => ( ( 'post' === get_post_type() ) ? 'singular-post' : 'singular-all' )  ]);
				if( ! empty( $popup_templates ) && is_array( $popup_templates ) ) :
					foreach( $popup_templates as $popup_template_id ) :
						if( get_post_status( $popup_template_id ) ) :
							$this->current_builder_id[] = $popup_template_id;
						else :
							continue;
						endif;
					endforeach;
					return ( ! empty( $this->current_builder_id ) ) ? true : false;
				else:
					return false;
				endif;
			}
		} else if( is_home() ) {
			if( $type == 'header' ) {
				$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => 'home']);
				if( $page_header ) {
					if( get_post_status($page_header) ) {
						$this->current_builder_id = $page_header;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'footer' ) {
				$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => 'home']);
				if( $page_footer ) {
					if( get_post_status($page_footer) ) {
						$this->current_builder_id = $page_footer;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'archive' ) {
				$archive_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'archiveposts']);
				if( $archive_template ) {
					if( get_post_status($archive_template) ) {
						$this->current_builder_id = $archive_template;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'popup' ) {
				$popup_templates = nekit_get_conditions_settings_builder_id([ 'parent' => 'popup-builder', 'child' => 'home' ]);
				if( ! empty( $popup_templates ) && is_array( $popup_templates ) ) :
					foreach( $popup_templates as $popup_template_id ) :
						if( get_post_status( $popup_template_id ) ) :
							$this->current_builder_id[] = $popup_template_id;
						else :
							continue;
						endif;
					endforeach;
					return ( ! empty( $this->current_builder_id ) ) ? true : false;
				else:
					return false;
				endif;
			}
		} else if( is_archive() ) {
			if( $type == 'header' ) {
				if( is_category() ) {
					$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => 'archives-category']);
				} else if( is_tag() ) {
					$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => 'archives-tag']);
				} else if( is_author() ) {
					$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => 'archives-author']);
				} else if( is_date() ) {
					$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => 'archives-date']);
				} else if( is_search() ) {
					$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => 'archives-search']);
				} else if( is_tax() ) {
					$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => 'archives-all']);
				}
				if( $page_header ) {
					if( get_post_status($page_header) ) {
						$this->current_builder_id = $page_header;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'footer' ) {
				if( is_category() ) {
					$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => 'archives-category']);
				} else if( is_tag() ) {
					$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => 'archives-tag']);
				} else if( is_author() ) {
					$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => 'archives-author']);
				} else if( is_date() ) {
					$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => 'archives-date']);
				} else if( is_search() ) {
					$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => 'archives-search']);
				} else if( is_tax() ) {
					$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => 'archives-all']);
				}
				if( $page_footer ) {
					if( get_post_status($page_footer) ) {
						$this->current_builder_id = $page_footer;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'archive' ) {
				if( is_category() ) {
					$archive_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'archivepostcategories-nekitallnekit']);
				} else if( is_tag() ) {
					$archive_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'archiveposttags-nekitallnekit']);
				} else if( is_author() ) {
					$archive_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'archiveauthor-nekitallnekit']);
				} else if( is_date() ) {
					$archive_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'datearchive']);
				}  else if( is_tax() ) {
					$archive_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'archives-all']);
				}
				if( $archive_template ) {
					if( get_post_status($archive_template) ) {
						$this->current_builder_id = $archive_template;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'popup' ) {
				if( is_category() ) {
					$popup_templates = nekit_get_conditions_settings_builder_id(['parent' => 'popup-builder','child' => 'archives-category']);
				} else if( is_tag() ) {
					$popup_templates = nekit_get_conditions_settings_builder_id(['parent' => 'popup-builder','child' => 'archives-tag']);
				} else if( is_author() ) {
					$popup_templates = nekit_get_conditions_settings_builder_id(['parent' => 'popup-builder','child' => 'archives-author']);
				} else if( is_date() ) {
					$popup_templates = nekit_get_conditions_settings_builder_id(['parent' => 'popup-builder','child' => 'archives-date']);
				} else if( is_search() ) {
					$popup_templates = nekit_get_conditions_settings_builder_id(['parent' => 'popup-builder','child' => 'archives-search']);
				} else if( is_tax() ) {
					$popup_templates = nekit_get_conditions_settings_builder_id(['parent' => 'popup-builder','child' => 'archives-all']);
				}
				if( ! empty( $popup_templates ) && is_array( $popup_templates ) ) :
					foreach( $popup_templates as $popup_template_id ) :
						if( get_post_status( $popup_template_id ) ) :
							$this->current_builder_id[] = $popup_template_id;
						else :
							continue;
						endif;
					endforeach;
					return ( ! empty( $this->current_builder_id ) ) ? true : false;
				else:
					return false;
				endif;
			}
		} else if( is_search() ) {
			if( $type == 'header' ) {
				$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => 'archives-search']);
				if( $page_header ) {
					if( get_post_status($page_header) ) {
						$this->current_builder_id = $page_header;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'footer' ) {
				$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => 'archives-search']);
				if( $page_footer ) {
					if( get_post_status($page_footer) ) {
						$this->current_builder_id = $page_footer;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'archive' ) {
				$archive_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'searchresultsarchive']);
				if( $archive_template ) {
					if( get_post_status($archive_template) ) {
						$this->current_builder_id = $archive_template;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'popup' ) {
				$popup_templates = nekit_get_conditions_settings_builder_id([ 'parent' => 'popup-builder', 'child' => 'archives-search' ]);
				if( ! empty( $popup_templates ) && is_array( $popup_templates ) ) :
					foreach( $popup_templates as $popup_template_id ) :
						if( get_post_status( $popup_template_id ) ) :
							$this->current_builder_id[] = $popup_template_id;
						else :
							continue;
						endif;
					endforeach;
					return ( ! empty( $this->current_builder_id ) ) ? true : false;
				else:
					return false;
				endif;
			}
		} else if( is_404() ) {
			if( $type == 'header' ) {
				$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => 'singular-404page']);
				if( $page_header ) {
					if( get_post_status($page_header) ) {
						$this->current_builder_id = $page_header;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'footer' ) {
				$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => 'singular-404page']);
				if( $page_footer ) {
					if( get_post_status($page_footer) ) {
						$this->current_builder_id = $page_footer;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == '404' ) {
				$error_page_template = nekit_get_conditions_settings_builder_id(['parent' => '404-builder','child' => '404page']);
				if( $error_page_template ) {
					if( get_post_status($error_page_template) ) {
						$this->current_builder_id = $error_page_template;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			}  else if( $type == 'popup' ) {
				$popup_templates = nekit_get_conditions_settings_builder_id([ 'parent' => 'popup-builder', 'child' => 'singular-404page' ]);
				if( ! empty( $popup_templates ) && is_array( $popup_templates ) ) :
					foreach( $popup_templates as $popup_template_id ) :
						if( get_post_status( $popup_template_id ) ) :
							$this->current_builder_id[] = $popup_template_id;
						else :
							continue;
						endif;
					endforeach;
					return ( ! empty( $this->current_builder_id ) ) ? true : false;
				else:
					return false;
				endif;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

    /**
    ** Current html template
    */
    public function current_builder_template( $template_id = 0 ) {
		// Check if the post can be viewed by all users
		$template_id = ( $template_id != 0 ) ? $template_id : $this->current_builder_id;

		/* Execute only if not array */
		$template = get_post($template_id);
		if ( $template && ($template->post_status === 'publish' || current_user_can('read_post', $template_id)) ) {
			$elementor = \Elementor\Plugin::instance();
			$builder_content = $elementor->frontend->get_builder_content_for_display($template_id);
			return $builder_content;
		} else {
			return '';
		}
    }
}