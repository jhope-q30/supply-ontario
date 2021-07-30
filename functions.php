<?php
/**
 * _supply_ontario functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _supply_ontario
 */

if ( ! defined( '_SUPPLY_ONTARIO_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_SUPPLY_ONTARIO_VERSION', '1.0.0' );
}

if ( ! function_exists( '_supply_ontario_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function _supply_ontario_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on _supply_ontario, use a find and replace
		 * to change '_supply_ontario' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( '_supply_ontario', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary-menu'   => __( 'Primary Menu', '_supply_ontario' ),
				'secondary-menu' => __( 'Secondary Menu', '_supply_ontario' ),
				'social-menu'    => __( 'Social Menu', '_supply_ontario' ),
				'footer-menu'    => __( 'Footer Menu', '_supply_ontario' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'_supply_ontario_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', '_supply_ontario_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _supply_ontario_content_width() {
	$GLOBALS['content_width'] = apply_filters( '_supply_ontario_content_width', 640 );
}
add_action( 'after_setup_theme', '_supply_ontario_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function _supply_ontario_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Header Search', '_supply_ontario' ),
			'id'            => 'header-search',
			'description'   => esc_html__( 'Add search widget to header.', '_supply_ontario' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<span class="d-none">',
			'after_title'   => '</span>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Site info', '_supply_ontario' ),
			'id'            => 'footer-site-info',
			'description'   => esc_html__( 'Add site info to footer.', '_supply_ontario' ),
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<span class="d-none">',
			'after_title'   => '</span>',
		)
	);
}
add_action( 'widgets_init', '_supply_ontario_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function _supply_ontario_scripts() {
	wp_enqueue_style( '_supply_ontario-style', get_stylesheet_uri(), array(), _SUPPLY_ONTARIO_VERSION );
	wp_enqueue_script( '_supply_ontario-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _SUPPLY_ONTARIO_VERSION, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', '_supply_ontario_scripts' );

/**
 * Implement the Custom Header, Navigation, Breadcrumb, Pagination.
 */
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/custom-navigation.php';
require get_template_directory() . '/inc/custom-breadcrumb.php';
require get_template_directory() . '/inc/custom-pagination.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';
