<?php
function crpw_stylesheet() {
  	$plugin_dir = 'custom-recent-posts-widget';
		if ( @file_exists( STYLESHEETPATH . '/custom-recent-posts-widget.css' ) )
			$crpwcss_file = get_stylesheet_directory_uri() . '/custom-recent-posts-widget.css';
		elseif ( @file_exists( TEMPLATEPATH . '/custom-recent-posts-widget.css' ) )
			$crpwcss_file = get_template_directory_uri() . '/custom-recent-posts-widget.css';
		else
			$crpwcss_file = plugins_url( 'css/custom-recent-posts-widget.css',dirname(__FILE__) );
			
	    
	        wp_register_style( 'wp-crpw-css', $crpwcss_file );
	        wp_enqueue_style( 'wp-crpw-css' );
	   
}
add_action('wp_print_styles', 'crpw_stylesheet');
?>