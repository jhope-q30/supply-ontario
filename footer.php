<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _supply_ontario
 */

?>

<footer id="colophon" class="site-footer">
	<div class="container">
		<div class="site-links">
			<!-- newsletter signup -->
			<a href="#" class="btn btn-primary">Recieve Updates</a>
			<!-- / newsletter signup -->
			<nav class="footer-menu" aria-label="<?php esc_html_e( 'Careers, Contact, and Socials', '_supply_ontario' ); ?>"><?php
				wp_nav_menu(
					array(
						'theme_location'  => 'footer-menu',
						'container_class' => 'menu-container',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					)
				);
			?></nav>
		</div>
		<div class="site-info">
			<div class="row">
				<div class="col-md"><?php if( is_active_sidebar( 'footer-site-info' ) ): ?><div id="footer-site-info" class="footer-site-info"><?php dynamic_sidebar( 'footer-site-info' ); ?></div><?php endif; ?></div>
				<div class="col-md-3">
					<img src="<?php echo get_template_directory_uri(); ?>/img/ontario-logo.png" class="img-fluid" alt="<?php _e( 'Ontario logo', '_supply_ontario' ); ?>" />
				</div>
			</div>
		</div>
	</div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

<!-- bootstrap 4.60 -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<!-- / bootstrap 4.60 -->

</body>
</html>

