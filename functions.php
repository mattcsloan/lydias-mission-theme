<?php
	function load_theme_styles() {
	    wp_enqueue_style( 'lm-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get('Version') );
	    wp_enqueue_style( 'lm-responsive',
	        get_stylesheet_directory_uri() . '/styles/responsive.css',
	        array( 'lm-style' ),
	        wp_get_theme()->get('Version')
	    );
	    wp_enqueue_style( 'icomoon',
	        get_stylesheet_directory_uri() . '/fonts/icomoon/icomoon.css',
	        array( 'lm-style', 'lm-responsive' ),
	        1.0.0
	    );
	}
	add_action( 'wp_enqueue_scripts', 'load_theme_styles' );

	//Load jQuery and all external scripts
	function load_my_scripts() {
		wp_enqueue_script('jquery');
		$templatedir = get_bloginfo('template_directory');
		wp_register_script('myscript', $templatedir.'/scripts/interaction.js', array('jquery'), '1.0.0', true);
		wp_enqueue_script('myscript');
	}
	add_action('init', 'load_my_scripts');

	// Make Wordpress Admin content area use theme stylesheet
	add_editor_style('style.css');

	// Get the page number
	function get_page_number() {
	    if ( get_query_var('paged') ) {
	        print ' | ' . __( 'Page ' , 'lydias-mission-theme') . get_query_var('paged');
	    }
	} // end get_page_number

	// add more link to excerpt
	function custom_excerpt_more($more) {
	return ' ...';
	}
	add_filter('excerpt_more', 'custom_excerpt_more');

	//Prevent <p> and <br> tags from being added to posts
	//remove_filter( 'the_content', 'wpautop' );
	remove_filter( 'the_excerpt', 'wpautop' );

	// For tag lists on tag archives: Returns other tags except the current one (redundant)
	function tag_ur_it($glue) {
	    $current_tag = single_tag_title( '', '',  false );
	    $separator = "n";
	    $tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
	    foreach ( $tags as $i => $str ) {
	        if ( strstr( $str, ">$current_tag<" ) ) {
	            unset($tags[$i]);
	            break;
	        }
	    }
	    if ( empty($tags) )
	        return false;
	 
	    return trim(join( $glue, $tags ));
	} // end tag_ur_it

	//create support for menus
	function register_my_menus() {
	  register_nav_menus(
	    array(
	      'main-navigation' => __( 'Main Navigation' )
	    )
	  );
	}
	add_action( 'init', 'register_my_menus' );

	//prevent Wordpress from wrapping loose images in a p tag
	function filter_ptags_on_images($content){
	   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
	}
	add_filter('the_content', 'filter_ptags_on_images');

	//add support for image thumbnails on posts
	add_theme_support('post-thumbnails'); 

	//tells wordpress to crop image to set size so that it can be used in the main feature or a partner logo
	add_image_size('large_square', 960, 960, true);
	add_image_size('vertical_feature', 400, 500, true);
	add_image_size('horizontal_feature', 800, 500, true);
	add_image_size('hero', 1500, 1100, true);

	function custom_image_sizes( $sizes ) {
	    return array_merge( $sizes, array(
	        'large_square' => __( 'Large Square' ),
	        'vertical_feature' => __( 'Vertical Feature' ),
	        'horizontal_feature' => __( 'Horizontal Feature' ),
	        'hero' => __( 'Hero' )
	    ) );
	}
	add_filter( 'image_size_names_choose', 'custom_image_sizes' );

    //Remove width and height attributes from thumbnail images
    function remove_thumbnail_dimensions( $html ) {
        $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
        return $html;
    }
    add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
    add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

    function posts_link_attributes() {
        return 'class="btn btn-blue"';
    }
    add_filter( 'next_posts_link_attributes', 'posts_link_attributes' );
    add_filter( 'previous_posts_link_attributes', 'posts_link_attributes' );
?>