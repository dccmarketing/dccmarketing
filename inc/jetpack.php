<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package DCC Marketing
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 * 
 * @uses 	add_theme_support()
 */
function dccmarketing_jetpack_setup() {

	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );

} // dccmarketing_jetpack_setup()
add_action( 'after_setup_theme', 'dccmarketing_jetpack_setup' );
