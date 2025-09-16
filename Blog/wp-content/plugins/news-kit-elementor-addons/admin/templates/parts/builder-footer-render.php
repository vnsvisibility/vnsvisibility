<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( $footer_rendered ) echo $Nekit_render_templates_html->current_builder_template();

wp_footer();
?>
</body>
</html> 