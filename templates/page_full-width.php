<?php
/**
 * Template Name: Full-width, no sidebar
 * 
 * Description: A full-width template with no sidebar
 *
 * @package DCC Marketing
 */

get_header(); ?>

		<div id="wrap">
			<div id="content" class="full-width"><?php

			while ( have_posts() ) : the_post();

				get_template_part( 'content', 'page' );
				
				// If comments are open or have more than one comment, load comment template
				if ( comments_open() || '0' != get_comments_number() ) {
				
					comments_template();
				
				} // comments check

			endwhile; // loop
				
			?></div><!-- // #content --><?php
				
get_footer(); ?>