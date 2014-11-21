<?php
/**
 * The homepage template file.
 *
 * @package DCC Marketing
 */

get_header();

	?><div id="primary" class="content-area">
		<main id="main" class="site-main" role="main"><?php

$locations 	= get_nav_menu_locations();
$menu 		= wp_get_nav_menu_object( $locations['primary'] );
$menu_items = wp_get_nav_menu_items( $menu->term_id );
$include 	= array();

foreach( $menu_items as $item ) {
	
	if ( $item->object == 'page') {

		$include[] = $item->object_id;

	}

} // foreach

$args['orderby'] 		= 'post__in';
$args['post__in'] 		= '$include';
$args['posts_per_page'] = count( $include );
$args['post_type'] 		= 'page';

query_posts( $args );
    
$i = 1;

while( have_posts() ) : the_post();

	$bg = get_thumbnail_url( $post->ID, 'full' );
	$id = strtolower( $post->post_name );

	?><div id="home-<?php echo $id; ?>">
		<div class="wrap">
			<h2><?php echo $post->post_name; ?></h2>
			<div class="home-content"><?php

				the_content();

			?></div><!-- .home-content -->
		</div><!-- .wrap -->
	</div><!-- #home-<?php echo $id; ?> -->
	<div id="sep<?php echo $i; ?>" class="separator" style="background-image: url(<?php echo $bg; ?>);">
	</div><!-- #sep<?php echo $i; ?> --><?php

	$i++; 

endwhile; 

wp_reset_query();

		?></main><!-- #main -->
	</div><!-- #primary --><?php

get_footer();
?>