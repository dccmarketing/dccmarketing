<?php
/**
 * DCC Marketing functions and definitions
 *
 * @package DCC Marketing
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'dccmarketing_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function dccmarketing_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on _s, use a find and replace
	 * to change 'dccmarketing' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'dccmarketing', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'dccmarketing' ),
		'social' => __( 'Social Links', 'dccmarketing' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	/*add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );*/

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'dccmarketing_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // dccmarketing_setup
add_action( 'after_setup_theme', 'dccmarketing_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function dccmarketing_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'dccmarketing' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'dccmarketing_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function dccmarketing_scripts() {
	wp_enqueue_style( 'dccmarketing-style', get_stylesheet_uri() );

	wp_enqueue_script( 'dccmarketing-navigation', get_template_directory_uri() . '/js/navigation.min.js', array(), '20120206', true );

	wp_enqueue_script( 'dccmarketing-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.min.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dccmarketing_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';



/**
 * Customize footer
 */
function custom_footer_left() {

	//

} // custom_footer_left()
add_action( 'footer_left', 'custom_footer_left' );

function custom_site_info() {

	printf( __( '<div class="copyright">All content &copy %1$s <a href="%2$s" title="Login">%3$s</a></a></div>', 'dccmarketing' ), date( 'Y' ), get_admin_url(), get_bloginfo( 'name' ) );

} // custom_site_info()
add_action( 'site_info', 'custom_site_info' );

function custom_footer_right() {

	// 

} // custom_footer_right()
add_action( 'footer_right', 'custom_footer_right' );


/**
 * Load Fonts
 */
function load_fonts() {

	//wp_register_style( 'et-googleFonts', 'http://fonts.googleapis.com/css?family=Cabin:400,500,600,700' );
	//wp_enqueue_style( 'et-googleFonts' );

} // load_fonts()
add_action( 'wp_print_styles', 'load_fonts' );



/**
 * Prints whatever in a nice, readable format
 */
function pretty( $input ) {

	echo '<pre>'; print_r( $input ); echo '</pre>';

} // pretty()


/**
 * Add Down Caret to Menus with Children
 *
 * @param 	string 		$item_output		//
 * @param 	object 		$item				//
 * @param 	int 		$depth 				//
 * @param 	array 		$args 				//
 * 
 * @return 	string 							modified menu
 */
function dccmarketing_menu_caret( $item_output, $item, $depth, $args ) {

	if ( ! in_array( 'menu-item-has-children', $item->classes ) ) { return $item_output; }

	$output = '<a href="' . $item->url . '">';
	$output .= $item->title;
	$output .= '<span class="children">' . get_svg( 'caret-down' ) . '</span>';
	$output .= '</a>';

	return $output;

} // dccmarketing_menu_caret()

add_filter( 'walker_nav_menu_start_el', 'dccmarketing_menu_caret', 10, 4 );



/**
 * Change Social Menu to Icons Only
 *
 * @link 	http://www.billerickson.net/customizing-wordpress-menus/
 *
 * @param 	string 		$item_output		//
 * @param 	object 		$item				//
 * @param 	int 		$depth 				//
 * @param 	array 		$args 				//
 * 
 * @return 	string 							modified menu
 */
function dccmarketing_social_menu_svgs( $item_output, $item, $depth, $args ) {

	if ( 'social' !== $args->theme_location ) { return $item_output; }

	$host 	= parse_url( $item->url, PHP_URL_HOST );
	$output = '<a href="' . $item->url . '" class="icon-menu">';
	$class 	= get_svg_by_class( $item->classes );

	if ( ! empty( $class ) ) {

		$output .= $class;

	} else {

		$output .= get_svg_by_url( $item->url );

	} // class check

	$output .= '</a>';

	return $output;

} // dccmarketing_social_menu_svgs()

add_filter( 'walker_nav_menu_start_el', 'dccmarketing_social_menu_svgs', 10, 4 );


/**
 * Gets the appropriate SVG based on a menu item class
 * 
 * @param  [type] $url [description]
 * @return [type]      [description]
 */
function get_svg_by_class( $classes ) {

	$output = '';

	foreach ( $classes as $class ) {

		$check = get_svg( $class );

		if ( ! is_null( $check ) ) { $output .= $check; break; }

	} // foreach

	return $output;

} // get_svg_by_class()


/**
 * Gets the appropriate SVG based on a URL
 * 
 * @param  [type] $url [description]
 * @return [type]      [description]
 */
/*function get_svg_by_pageID( $ID ) {

	$output = '';
	$page 	= get_post( $ID );

	switch( $page->post_title ) {

		case 'Calendar' 			: $output .= get_svg( 'calendar' ); break;
		case 'Camping' 				: $output .= get_svg( 'camping' ); break;
		case 'Events & Festivals' 	: $output .= get_svg( 'calendar' ); break;
		case 'Hotels' 				: $output .= get_svg( 'hotel' ); break;
		case 'Motels' 				: $output .= get_svg( 'hotel' ); break;
		case 'Travel Guides' 		: $output .= get_svg( 'map-location' ); break;

	} // switch

	return $output;

} // get_svg_by_pageID()*/



/**
 * Gets the appropriate SVG based on a URL
 * 
 * @param  [type] $url [description]
 * @return [type]      [description]
 */
function get_svg_by_url( $url ) {

	$output = '';
	$host 	= parse_url( $url, PHP_URL_HOST );

	switch( $host ) {

		case 'facebook.com' 	: $output .= get_svg( 'facebook' ); break;
		case 'instagram.com' 	: $output .= get_svg( 'instagram' ); break;
		case 'linked.com' 		: $output .= get_svg( 'linkedin' ); break;
		case 'pinterest.com' 	: $output .= get_svg( 'pinterest' ); break;
		case 'twitter.com' 		: $output .= get_svg( 'twitter' ); break;
		case 'youtube.com' 		: $output .= get_svg( 'youtube' ); break;

	} // switch

	return $output;

} // get_svg_by_url()


/**
 * Returns the requested SVG
 * 
 * @param 	string 		$icon 		The name of the icon to return
 * 
 * @return 	mixed 					The SVG code
 */
function get_svg( $svg ) {

	$output = '';

	switch ( $svg ) {

		case 'caret-down' 	: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="caret-down" viewBox="0 0 100 100" enable-background="new 0 0 100 100"><path d="M96.8 37.7L54.3 80.2C53.1 81.4 51.6 82 50 82c-1.6 0-3.1-0.7-4.3-1.8L3.2 37.7c-1.1-1.1-1.8-2.7-1.8-4.3 0-3.3 2.8-6.1 6.1-6.1h85c3.3 0 6.1 2.8 6.1 6.1C98.6 35.1 97.9 36.6 96.8 37.7z"/></svg>'; break;
		case 'facebook'		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="facebook" viewBox="0 0 113 113" enable-background="new 0 0 113 113"><path d="M82.2 21.1H72.1c-7.9 0-9.4 3.8-9.4 9.2v12.1h18.8l-2.5 19H62.8v48.7H43.1V61.5H26.8v-19h16.4v-14c0-16.2 9.9-25.1 24.5-25.1 6.9 0 12.9 0.5 14.6 0.8V21.1z"/></svg>'; break;
		case 'linkedin' 	: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="linkedin" viewBox="0 0 100 100" enable-background="new 0 0 100 100"><path d="M14.2 25.9H14c-6.8 0-11.2-4.7-11.2-10.5 0-6 4.5-10.5 11.4-10.5 6.9 0 11.2 4.5 11.3 10.5C25.6 21.2 21.2 25.9 14.2 25.9zM24.3 95H4V34.2h20.3V95zM97.1 95H77V62.5c0-8.2-2.9-13.8-10.3-13.8 -5.6 0-8.9 3.7-10.4 7.4 -0.5 1.4-0.7 3.1-0.7 5V95H35.5c0.2-55.1 0-60.8 0-60.8h20.2V43h-0.1c2.6-4.2 7.4-10.3 18.4-10.3 13.3 0 23.3 8.7 23.3 27.4V95z"/></svg>'; break;
		case 'logo' 		: $output .= ''; break;
		case 'pinterest' 	: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="pinterest" viewBox="0 0 100 100" enable-background="new 0 0 100 100"><path d="M50 97c-4.7 0-9.1-0.7-13.4-2 1.8-2.8 3.8-6.4 4.8-10.1 0 0 0.6-2.1 3.3-13 1.6 3.1 6.4 5.9 11.5 5.9 15.2 0 25.5-13.8 25.5-32.4 0-13.9-11.8-27-29.9-27 -22.3 0-33.6 16.1-33.6 29.5 0 8.1 3.1 15.3 9.6 18 1 0.4 2 0 2.3-1.2 0.2-0.8 0.7-2.9 1-3.7 0.3-1.2 0.2-1.6-0.7-2.6 -1.9-2.3-3.1-5.2-3.1-9.3 0-11.9 8.9-22.6 23.2-22.6 12.6 0 19.6 7.7 19.6 18.1 0 13.6-6 25-15 25 -4.9 0-8.6-4.1-7.4-9.1 1.4-6 4.2-12.4 4.2-16.7 0-3.9-2.1-7.1-6.4-7.1 -5 0-9.1 5.2-9.1 12.2 0 0 0 4.5 1.5 7.5 -5.2 21.9-6.1 25.7-6.1 25.7C31 85.7 31 89.7 31.1 93 14.5 85.7 2.9 69.2 2.9 49.8 2.9 23.8 24 2.7 50 2.7c26 0 47.1 21.1 47.1 47.1S76 97 50 97z"/></svg>'; break;
		case 'telephone' 	: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="telephone" viewBox="0 0 100 100" enable-background="new 0 0 100 100"><path d="M95.1 86.5c-1.4 3.3-5.2 5.4-8.2 7.1 -4 2.1-8 3.4-12.5 3.4 -6.2 0-11.9-2.5-17.5-4.6 -4.1-1.5-8-3.3-11.7-5.6 -11.4-7-25.1-20.8-32.1-32.1C10.8 51 9 47 7.5 43c-2.1-5.7-4.6-11.3-4.6-17.5 0-4.5 1.3-8.5 3.4-12.5 1.7-3 3.8-6.8 7.1-8.2 2.2-1 6.9-2.1 9.3-2.1 0.5 0 0.9 0 1.4 0.2C25.5 3.4 27 6.7 27.6 8c2.1 3.8 4.2 7.7 6.4 11.5 1.1 1.7 3.1 3.9 3.1 6 0 4.1-12.1 10-12.1 13.7 0 1.8 1.7 4.2 2.6 5.8C34.4 57 42.8 65.5 55 72.2c1.6 0.9 4 2.6 5.8 2.6 3.6 0 9.6-12.1 13.7-12.1 2.1 0 4.2 2 6 3.1 3.8 2.2 7.6 4.3 11.5 6.4 1.3 0.7 4.6 2.1 5.1 3.5 0.2 0.5 0.2 0.9 0.2 1.4C97.2 79.6 96.1 84.3 95.1 86.5z"/></svg>'; break;
		case 'twitter' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="twitter" viewBox="0 0 113 113" enable-background="new 0 0 113 113"><path d="M101.2 33.6c0.1 1 0.1 2 0.1 3 0 30.5-23.2 65.6-65.6 65.6 -13.1 0-25.2-3.8-35.4-10.4 1.9 0.2 3.6 0.3 5.6 0.3 10.8 0 20.7-3.6 28.6-9.9 -10.1-0.2-18.6-6.9-21.6-16 1.4 0.2 2.9 0.4 4.4 0.4 2.1 0 4.1-0.3 6.1-0.8C12.7 63.7 4.8 54.4 4.8 43.2c0-0.1 0-0.2 0-0.3 3.1 1.7 6.6 2.8 10.4 2.9C9 41.7 4.9 34.6 4.9 26.6c0-4.3 1.1-8.2 3.1-11.6 11.4 14 28.4 23.1 47.6 24.1 -0.4-1.7-0.6-3.5-0.6-5.3 0-12.7 10.3-23.1 23.1-23.1 6.6 0 12.6 2.8 16.9 7.3 5.2-1 10.2-2.9 14.6-5.6 -1.7 5.4-5.4 9.9-10.1 12.7 4.6-0.5 9.1-1.8 13.3-3.6C109.6 26.2 105.7 30.3 101.2 33.6z" fill="#fdbc12"/></svg>'; break;
		case 'youtube' 		: $output .= '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" xml:space="preserve" class="youtube" viewBox="0 0 100 100" enable-background="new 0 0 100 100"><path d="M89.5 90.4c-1 4.4-4.6 7.6-8.8 8 -10.2 1.2-20.4 1.2-30.7 1.2 -10.2 0-20.5 0-30.7-1.2 -4.3-0.4-7.8-3.6-8.8-8 -1.4-6.2-1.4-13-1.4-19.3 0-6.4 0.1-13.2 1.4-19.3 1-4.4 4.6-7.6 8.9-8.1 10.1-1.1 20.4-1.1 30.6-1.1 10.2 0 20.5 0 30.7 1.1 4.3 0.5 7.8 3.7 8.8 8.1 1.4 6.2 1.4 12.9 1.4 19.3C90.9 77.4 90.9 84.2 89.5 90.4zM32.4 57.3v-5.2H15.2v5.2H21v31.4h5.5V57.3H32.4zM41.4 0.5l-6.7 22v15h-5.5v-15c-0.5-2.7-1.6-6.6-3.4-11.7C24.6 7.4 23.4 4 22.3 0.5h5.9L32 15.1l3.8-14.5H41.4zM47.4 88.7V61.4h-4.9v20.9c-1.1 1.5-2.2 2.3-3.1 2.3 -0.7 0-1-0.4-1.2-1.2 -0.1-0.2-0.1-0.8-0.1-1.9V61.4h-4.9V83c0 1.9 0.2 3.2 0.4 4 0.4 1.4 1.6 2 3.2 2 1.8 0 3.6-1.1 5.6-3.4v3H47.4zM56.2 28.6c0 2.9-0.5 5.1-1.5 6.5 -1.4 1.9-3.3 2.8-5.9 2.8 -2.5 0-4.4-0.9-5.8-2.8 -1-1.4-1.5-3.6-1.5-6.5v-9.7c0-2.9 0.5-5.1 1.5-6.5 1.4-1.9 3.3-2.8 5.8-2.8 2.5 0 4.5 0.9 5.9 2.8 1 1.4 1.5 3.5 1.5 6.5V28.6zM51.2 17.9c0-2.5-0.7-3.8-2.4-3.8 -1.6 0-2.4 1.3-2.4 3.8v11.6c0 2.5 0.8 3.9 2.4 3.9 1.7 0 2.4-1.3 2.4-3.9V17.9zM66.1 69.7c0-2.5-0.1-4.4-0.5-5.5 -0.6-2-2-3.1-3.9-3.1 -1.8 0-3.5 1-5.1 3v-12h-4.9v36.6h4.9v-2.7c1.7 2 3.4 3 5.1 3 1.9 0 3.3-1 3.9-3 0.4-1.2 0.5-3 0.5-5.5V69.7zM61.2 80.9c0 2.5-0.7 3.7-2.2 3.7 -0.8 0-1.7-0.4-2.5-1.2V66.8c0.8-0.8 1.7-1.2 2.5-1.2 1.4 0 2.2 1.3 2.2 3.7V80.9zM74.8 37.6h-5v-3c-2 2.3-3.9 3.4-5.7 3.4 -1.6 0-2.8-0.7-3.3-2 -0.3-0.8-0.4-2.2-0.4-4.1V10h5v20.3c0 1.2 0 1.8 0.1 1.9 0.1 0.8 0.5 1.2 1.2 1.2 1 0 2-0.8 3.1-2.4V10h5V37.6zM84.8 79.3h-5c0 2-0.1 3.1-0.1 3.4 -0.3 1.3-1 2-2.2 2 -1.7 0-2.5-1.3-2.5-3.8V76h9.9v-5.7c0-2.9-0.5-5-1.5-6.4 -1.4-1.9-3.4-2.8-5.9-2.8 -2.5 0-4.5 0.9-5.9 2.8 -1 1.4-1.5 3.5-1.5 6.4v9.6c0 2.9 0.6 5.1 1.6 6.4 1.4 1.9 3.4 2.8 6 2.8 2.6 0 4.6-1 6-2.9 0.6-0.9 1-1.9 1.2-3 0.1-0.5 0.1-1.6 0.1-3.2V79.3zM79.9 71.9h-5v-2.5c0-2.5 0.8-3.8 2.5-3.8 1.7 0 2.5 1.3 2.5 3.8V71.9z"/></svg>'; break;

	} // switch

	return $output;

} // get_svg()

