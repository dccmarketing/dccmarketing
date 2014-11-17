<?php
/**
 * @package DCC Marketing
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header"><?php
		
		the_title( '<h1 class="entry-title">', '</h1>' );

		?><div class="entry-meta"><?php
	
			dccmarketing_posted_on();
	
		?></div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content"><?php
	
		the_content();
		
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'dccmarketing' ),
			'after'  => '</div>',
		) );
	
	?></div><!-- .entry-content -->

	<footer class="entry-footer"><?php

		dccmarketing_entry_footer();
	
	?></footer><!-- .entry-footer -->
</article><!-- #post-## -->