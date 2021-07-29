<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _supply_ontario
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="profile" href="https://gmpg.org/xfn/11">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700&display=swap" rel="stylesheet">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', '_supply_ontario' ); ?></a>
<header id="masthead" class="site-header">
	<div class="site-banner">
		<div class="site-branding">
			<div class="site-branding-banner">
				<?php the_custom_logo(); ?>
				<button class="menu-toggle" id="toggler" aria-controls="site-navigation" aria-expanded="false"><span class="screen-reader-text"><?php esc_html_e( 'Primary Menu', '_supply_ontario' ); ?></span></button>
			</div>
		</div>
		<nav id="site-secondary-menu" class="secondary-menu" aria-label="<?php esc_html_e( 'Careers and Contact', '_supply_ontario' ); ?>"><?php
			wp_nav_menu(
				array(
					'theme_location'  => 'secondary-menu',
					'container_class' => 'menu-container',
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				)
			);
			wp_nav_menu(
				array(
					'theme_location'  => 'social-menu',
					'link_before'     => '<span class="icon">%s</span><span class="screen-reader-text">',
					'link_after'      => '</span>',
					'container_class' => 'menu-container',
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'walker'          => new AddMarkup_Nav_Social()
				)
			);
		?></nav>
		<?php if( is_active_sidebar( 'header-search' ) ): ?><div id="header-search" class="header-search"><?php dynamic_sidebar( 'header-search' ); ?></div><?php endif; ?>
		<nav id="site-navigation" class="main-navigation" role="navigation"><?php
			wp_nav_menu(
				array(
					'theme_location'  => 'primary-menu',
					'container_class' => 'menu-container',
					'items_wrap'      => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
					'walker'          => new AddMarkup_Nav_Main()
				)
			);
		?></nav>
	</div>
</header><!-- #masthead -->