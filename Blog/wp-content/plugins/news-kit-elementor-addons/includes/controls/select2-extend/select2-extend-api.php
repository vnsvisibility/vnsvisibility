<?php
/**
 * Endpoints for custom control
 * 
 * @since 1.0.0
 * @package News Kit Elementor Addons
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Nekit_Select2_Extend_Api {
    /**
     * Define the api route for the select2 extend control
     * 
     */
    protected $api_route = 'nekit/v1/select2extend';
    
    /**
     * Constructor
     * 
     * @access public
     */
	public function __construct() {
		$this->init();
	}

    /**
	 * Initialize class
	 *
	 * Fired by `elementor/init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {
		add_action( 'rest_api_init', function() {
			register_rest_route(
				$this->api_route,
				'/(?P<action>\w+)/',
				[
					'methods' => 'GET',
					'callback' =>  [$this, 'callback'],
					'permission_callback' => '__return_true'
				]
			);
		} );
	}

	// route callback function
	public function callback($request) {
		return $this->{$request['action']}($request);
	}

	/**
	 * MARK: Post Type
	 */
	public function get_posts_by_post_type($request) {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;   
		}
		
		$post_type = isset($request['query_slug']) ? $request['query_slug'] : '';
		$args = [
			'post_type' => $post_type,
			'post_status' => 'publish',
			'posts_per_page' => 10,
		];

		if ( isset( $request['ids'] ) ) {
			$ids = explode( ',', $request['ids'] );
			$args['post__in'] = $ids;
		}
		
		if ( isset( $request['s'] ) ) {
			$args['s'] = esc_html( $request['s'] );
		}

		if ( 'attachment' === $post_type ) {
			$args['post_status'] = 'any';
		}

		$options = [];
		$query = new \WP_Query( $args );

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$options[] = [
					'id' => get_the_ID(),
					'text' => html_entity_decode(get_the_title()),
				];
			}
		}

		wp_reset_postdata();

		return [ 'results' => $options ];
	}

	/**
	 * MARK: Taxonomies
	 */
	public function get_taxonomies( $request ) {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;   
		}
		$tax = isset($request['query_slug']) ? $request['query_slug'] : null;
		$args = [
			'taxonomy'	=> $tax,
			'orderby' => 'name', 
			'order' => 'DESC',	
			'hide_empty' => false,
			'number' => 10,
		];

		if ( isset( $request['ids'] ) ) {
			$request['ids'] = ('' !== $request['ids']) ? $request['ids'] : '99999999'; // Query Hack
			$ids = explode( ',', $request['ids'] );
			$args['include'] = $ids;
		}
		
		if ( isset( $request['s'] ) ) {
			$args['search'] = esc_html( $request['s'] );
		}
		
		$options = [];
		$terms = get_terms( $args );

		if ( ! empty($terms) ) {
			foreach ( $terms as $term ) {
				$options[] = [
					'id'   => $term->term_id,
					'text' => $term->name
				];
			}
		}

		wp_reset_postdata();

		return [ 'results' => $options ];
	}

	/**
	 * MARK: Users
	 */
	public function get_users( $request ) {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;   
		}

		$args = [
			'number' => '10'
			// 'blog_id' => 0
		];

		if ( isset( $request['ids'] ) ) {
			$ids = array_map('intval', explode(',', $request['ids'] ));
			$args['include'] = $ids;
		}

		if ( isset( $request['s'] ) ) {
			$args['search'] = '*'. esc_html( $request['s'] ) .'*';
		}

		$options = [];
		$user_query = new \WP_User_Query( $args );

		if ( ! empty( $user_query->get_results() ) ) {
			foreach ( $user_query->get_results() as $user ) {
				$options[] = [
					'id' => $user->ID,
					'text' => $user->display_name,
				];
			}
		}
		wp_reset_postdata();
		return [ 'results' => $options ];
		wp_die();
	}

	/**
	 * MARK: Custom Post Types
	 */
	public function get_custom_post_types() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;   
		}
		$all_post_types = get_post_types([
			'_builtin'	=>	false,
			'public'	=>	true,
			'exclude_from_search'	=>	false
		], 'objects' );
		$options = [
			[
				'id'	=>	'post',
				'text'	=>	esc_html__( 'Post', 'news-kit-elementor-addons' )
			]
		];
		if( count( $all_post_types ) > 0 ) :
			foreach( $all_post_types as $slug => $object ) :
				$options[] = [
					'id'	=>	$slug,
					'text'	=>	$object->label
				];
			endforeach;
		endif;
		return [ 'results' => $options ];
	}

	/**
	 * MARK: Custom Taxonomies
	 */
	public function get_custom_taxonomies( $request ) {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;   
		}
		$post_type = isset($request['query_slug']) ? $request['query_slug'] : 'post';
		/* If select taxonomies control is independent of select post type control */
		if( $post_type === 'any' ) :
			$taxonomies = get_taxonomies([], 'objects');
		else:
			$taxonomies = get_object_taxonomies( $post_type, 'objects' );
		endif;
		$options = [];
		if( count( $taxonomies ) > 0 ) :
			foreach( $taxonomies as $slug => $object ) :
				if( ! in_array( $slug, [ 'post_tag' ] ) ) :
					$options[] = [
						'id'	=>	$slug,
						'text'	=>	$object->label
					];
				endif;
			endforeach;
		endif;
		return [ 'results' => $options ];
	}
}
new Nekit_Select2_Extend_Api();