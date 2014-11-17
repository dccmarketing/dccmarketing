<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package DCC Marketing
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">

		<div class="footer-wrap">

			<div class="footer-left"><?php

				do_action( 'footer_left' );

			?></div><!-- .footer_left -->
			<div class="site-info"><?php

				do_action( 'site_info' );

			?></div><!-- .site-info -->
			<div class="footer-right"><?php

				do_action( 'footer_right' );

			?></div><!-- .site-info -->
		
		</div><!-- .footer-wrap -->

	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>