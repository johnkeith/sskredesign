<?php
/**
 * Custom amendments for the theme.
 *
 * @category    Foodie
 * @subpackage  Genesis
 * @copyright   Copyright (c) 2013, Shay Bocks
 * @license     GPL-2.0+
 * @link        http://www.shaybocks.com/foodie/
 * @since       1.0.9
 *
 */

add_action( 'genesis_setup', 'foodie_theme_setup', 15 );
/**
 * Theme Setup
 *
 * This setup function attaches all of the site-wide functions
 * to the correct hooks and filters. All the functions themselves
 * are defined below this setup function.
 *
 * @since 1.0.1
 */
function foodie_theme_setup() {

	//* Child theme (do not remove)
	define( 'CHILD_THEME_NAME', __( 'Foodie Theme', 'foodie' ) );
	define( 'CHILD_THEME_VERSION', '1.0.9' );
	define( 'CHILD_THEME_URL', 'http://www.shaybocks.com/foodie/' );
	define( 'CHILD_THEME_DEVELOPER', __( 'Shay Bocks', 'foodie' ) );
	
//* Add viewport meta tag for mobile browsers.
	add_theme_support( 'genesis-responsive-viewport' );
	
//* Add HTML5 markup structure.
	add_theme_support( 'html5' );

	//*	Set content width.
	$content_width = apply_filters( 'content_width', 610, 610, 980 );

	//* Add new featured image sizes.
	add_image_size( 'horizontal-thumbnail', 680, 453, TRUE );
	add_image_size( 'square-thumbnail', 450, 450, TRUE );

	//* JTK EDIT
	add_image_size( 'homepage-thumbnail', 250, 250, TRUE);

	//* Add support for custom background.
	add_theme_support( 'custom-background' );

	//* Unregister header right sidebar.
	unregister_sidebar( 'header-right' );

	//* Create color style options.
	add_theme_support( 'genesis-style-selector', array(
			'theme-citrus'	=> __( 'Citrus', 'foodie' ),
			'theme-earthy'	=> __( 'Earthy', 'foodie' ),
		)
	);
	
	// * Add support for custom header.
	// add_theme_support( 'genesis-custom-header', array(
	// 		'width'  => 960,
	// 		'height' => 160,
	// 		'no_header_text' => true
	// 	)
	// );

	//* Add support for 3-column footer widgets.
	add_theme_support( 'genesis-footer-widgets', 3 );

	//* Enqueue child theme styles.
	add_action( 'wp_enqueue_scripts', 'foodie_enqueue_styles' );

	add_action( 'wp_enqueue_scripts', 'font_awesome_styles');

	//* Enqueue child theme JavaScript.
	add_action( 'wp_enqueue_scripts', 'foodie_enqueue_js' );

	//* Add child theme body class.
	add_filter( 'body_class', 'foodie_add_body_class' );

	//* Add post navigation.
	add_action( 'genesis_after_entry_content', 'genesis_prev_next_post_nav', 5 );

	//* Modify the WordPress read more link.
	add_filter( 'the_content_more_link', 'foodie_read_more_link' );

	//* Add excerpt read more link.
	add_filter( 'excerpt_more', 'get_read_more_link' );
	add_filter( 'the_content_more_link', 'get_read_more_link' );

	//* Modify the speak your mind text.
	add_filter( 'genesis_comment_form_args', 'foodie_comment_form_args' );

	//* Customize the credits.
	add_filter( 'genesis_footer_creds_text', 'foodie_footer_creds_text' );

	//* Load an ad section before .site-inner.
	add_action( 'genesis_before', 'foodie_top_ad' );

	//*	Load theme sidebars.
	foodie_register_sidebars();

	//* Disable the editor for the recipe page template.
	add_action( 'admin_init', 'foodie_remove_widgeted_editor' );

	add_filter( 'genesis_search_text', 'sp_search_text' );

}

/**
 * Load Genesis
 *
 * This is technically not needed.
 * However, to make functions.php snippets work, it is necessary.
 */
require_once( get_template_directory() . '/lib/init.php' );

/**
 * Load all additional stylesheets for the Foodie theme.
 *
 * @since  1.0.0
 */
function foodie_enqueue_syles() {
	wp_enqueue_style( 'foodie-google-fonts', '//fonts.googleapis.com/css?family=Josefin+Sans:400,700|Open+Sans:300,400|Lato:300,400', array(), CHILD_THEME_VERSION );
}

function font_awesome_styles() {
	wp_enqueue_style( 'font-awesome', get_stylesheet_directory_uri().'/css/font-awesome.css', array(), "4.2.0");
}

/**
 * Load all required JavaScript for the Foodie theme.
 *
 * @since 1.0.1
 */
function foodie_enqueue_js() {
	$js_uri = get_stylesheet_directory_uri() . '/lib/js/';
	// Add general purpose scripts.
	wp_enqueue_script( 'foodie-general', $js_uri . 'general.js', array( 'jquery' ), '1.0.0', true );
}

/**
 * Add the theme name class to the body element.
 *
 * @param  string $classes
 * @return string Modified body classes.
 *
 * @since  1.0.0
 */
function foodie_add_body_class( $classes ) {
		$classes[] = 'foodie';
		return $classes;
}

/**
 * Modify the Genesis read more link.
 *
 * @param  string $more
 * @return string Modified read more text.
 *
 * @since  1.0.0
 */
function foodie_read_more_link() {
	return '<p></p><a class="more-link" href="' . get_permalink() . '">' . __( 'Read More', 'foodie' ) . ' <i class="fa fa-chevron-right"></i></a>';
}

/**
 * Add excerpt read more link.
 *
 * @param  string $more
 * @return string Modified read more text.
 *
 * @since  1.0.0
 */
function get_read_more_link() {
   return '...&nbsp;<p></p><a class="more-link" href="' . get_permalink() . '">' . __( 'Read More', 'foodie' ) . ' <i class="fa fa-chevron-right"></i></a>';
}

/**
 * Modify the speak your mind text.
 *
 * @since  1.0.0
 */
function foodie_comment_form_args( $args ) {
	$args['title_reply'] = __( 'Comments', 'foodie' );
	return $args;
}

/**
 * Customize the footer text
 *
 * @param  string $creds Default credits.
 * @return string Modified Shay Bocks credits.
 *
 * @since  1.0.0
 */
function foodie_footer_creds_text( $creds ) {
	return sprintf(
		'[footer_copyright before="%s "] &middot; [footer_childtheme_link before=""] %s <a href="http://www.shaybocks.com/">%s</a> &middot; %s [footer_genesis_link url="http://www.studiopress.com/" before=""] &middot; [footer_wordpress_link before=" %s"]',
		__( 'Copyright', 'foodie' ),
		__( 'by', 'foodie' ),
		CHILD_THEME_DEVELOPER,
		__( 'Built on the ', 'foodie' ),
		__( 'Powered by ', 'foodie' )
	);
}

/**
 * Load an ad section before .site-inner.
 *
 * @since  1.0.7
 */
add_action( 'genesis_before', 'foodie_top_ad' );
function foodie_top_ad() {
	//* Return early if we have no ad.
	if ( ! is_active_sidebar( 'top-ad' ) ) {
		return;
	}

	echo '<div class="top-ad">';
		dynamic_sidebar( 'top-ad' );
	echo '</div>';
}

/**
 * Register sidebars for Foodie theme.
 *
 * @since  1.0.0
 */
function foodie_register_sidebars() {
	genesis_register_sidebar( array(
		'id'			=> 'top-ad',
		'name'			=> __( 'Top Ad', 'foodie' ),
		'description'	=> __( 'This is the top ad section.', 'foodie' ),
	) );
	genesis_register_sidebar( array(
		'id'			=> 'home-top',
		'name'			=> __( 'Home Top', 'foodie' ),
		'description'	=> __( 'This is the home top section.', 'foodie' ),
	) );
	genesis_register_sidebar( array(
		'id'			=> 'home-middle',
		'name'			=> __( 'Home Middle', 'foodie' ),
		'description'	=> __( 'This is the home middle section.', 'foodie' ),
	) );
	genesis_register_sidebar( array(
		'id'			=> 'home-bottom',
		'name'			=> __( 'Home Bottom', 'foodie' ),
		'description'	=> __( 'This is the home bottom section.', 'foodie' ),
	) );
	genesis_register_sidebar( array(
		'id'			=> 'recipes-top',
		'name'			=> __( 'Recipes Top', 'foodie' ),
		'description'	=> __( 'This is the recipes top section.', 'foodie' ),
	) );
	genesis_register_sidebar( array(
		'id'			=> 'recipes-bottom',
		'name'			=> __( 'Recipes Bottom', 'foodie' ),
		'description'	=> __( 'This is the recipes bottom section.', 'foodie' ),
	) );
}

/**
 * Perform a check to see whether or not a widgeted page template is being used.
 *
 * @since   1.0.0
 * @return  bool
 */
function foodie_using_widgeted_template( $templates = '' ) {
	// Return false if we have post data.
	if ( ! isset( $_REQUEST['post'] ) ) {
		return false;
	}

	// If no widgeted templates are passed in, check only the default recipes.php.
	if ( empty( $templates ) ) {
		$templates = array( 'recipes.php' );
	}

	foreach ( $templates as $template ) {
		// Return true for all widgeted templates
		if ( get_page_template_slug( $_REQUEST['post'] ) === $template ) {
			return true;
		}
	}

	// Return false for other templates.
	return false;
}

/**
 * Check to make sure a widgeted page template is is selected and then disable 
 * the default WordPress editor.
 *
 * @since  1.0.0
 */
function foodie_remove_widgeted_editor() {
	// Return early if a widgeted template isn't selected.
	if ( ! foodie_using_widgeted_template() ) {
		return;
	}

	// Disable the standard WordPress editor.
	remove_post_type_support( 'page', 'editor' );

	//* Add an admin notice for the recipe page template.
	add_action( 'admin_notices', 'foodie_widgeted_admin_notice' );
}

/**
 * Check to make sure a widgeted page template is is selected and then show a 
 * notice about the editor being disabled.
 *
 * @since  1.0.0
 */
function foodie_widgeted_admin_notice() {
	// Display a notice to users about the widgeted template.
	echo '<div class="updated"><p>';
		printf (
			__( 'The normal editor is disabled because you\'re using a widgeted page template. You need to <a href="%s">use widgets</a> to edit this page.', 'foodie' ),
			'widgets.php'
		);
	echo '</p></div>';
}

function sp_search_text( $text ) {
	return esc_attr( 'Search the site...' );
}
