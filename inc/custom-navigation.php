<?php
/**
 * Added markup to default wordpress markup
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package _supply_ontario
 */

/* ADD ARIA CONTROLS TO TOP LEVEL LINKS */
function _supply_ontario_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
	// Add [aria-haspopup] and [aria-expanded] to menu items that have children.
	$item_has_children = in_array( 'menu-item-has-children', $item->classes, true );
	if ( $item_has_children ) {
		$atts['aria-haspopup'] = 'true';
		$atts['aria-expanded'] = 'false';
		$atts['aria-controls'] = !empty( $item->slug ) ? $item->slug : get_post_field( 'post_name', $item->object_id );
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', '_supply_ontario_nav_menu_link_attributes', 10, 4 );
/* ADD SECTION NAME TO CLASSES */
function _supply_ontario_add_section_class( $classes, $item, $args, $depth ) {
    if ( 0 === $depth && in_array( 'menu-item-has-children', $item->classes, true ) ) {
		$slug = !empty( $item->slug ) ? $item->slug : get_post_field( 'post_name', $item->object_id );
        array_push( $classes, $slug );
    }
    return $classes;
}
add_filter( 'nav_menu_css_class' , '_supply_ontario_add_section_class' , 10, 4 );
/* ADD WALKER FOR ARIA CONTROLS */
class AddMarkup_Nav_Main extends Walker_Nav_Menu {
	/// <li> items
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		parent::start_el( $output, $item, $depth, $args, $id );
		if ( 0 === $depth && in_array( 'menu-item-has-children', $item->classes, true ) ) {
			// Add toggle button for mobile.
			$classes     = array( 'sub-menu' );
			$class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
			$slug        = !empty( $item->slug ) ? $item->slug : get_post_field( 'post_name', $item->object_id );
			$title       = !empty( $item->title ) ? $item->title : get_post_field( 'post_title', $item->object_id );
			$label       = __( 'Open menu', '_supply_ontario' );
			$output     .= '<button class="sub-menu-toggle" aria-expanded="false" aria-haspopup="true" aria-controls="' . $slug . '" aria-label="' . $label . '">';
			$output     .= '<span class="screen-reader-text">' . $label . '</span>';
			$output     .= '</button>';
			$output     .= "\n<ul$class_names role=\"menu\" aria-hidden=\"true\" id=\"$slug\">\n";
		}
	}
	/// <ul> items
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$ouput .= $depth === 0 ? "" : $output;
	}
}
/* SOCIAL MEDIA MENU IN HEADER */
/* ADD SLUG TO CLASSES */
class AddMarkup_Nav_Widget extends Walker_Nav_Menu {
	/// <li> items
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$slug = !empty( $item->slug ) ? $item->slug : get_post_field( 'post_name', $item->object_id );
		array_push( $item->classes, $slug );
		parent::start_el( $output, $item, $depth, $args, $id );
		/// add image
		$image_file_local = get_template_directory() . '/img/' . $slug . '.svg';
		$image = '';
		if ( @file_get_contents( $image_file_local, 0, NULL, 0, 1 ) ){
			$image = '<img src="' . get_template_directory_uri() . '/img/' . $slug . '.svg" alt="' . $title . '" />';
		}
		$output = sprintf( $output, $image );
	}
}
add_filter( 'widget_nav_menu_args', function( $nav_menu_args, $nav_menu, $args, $instance ) {
	if ( $args[ 'id' ] == 'footer-social' ) {
		$nav_menu_args[ 'link_before' ] = '<span class="icon">%s</span><span class="screen-reader-text">';
		$nav_menu_args[ 'link_after' ]  = '</span>';
		$nav_menu_args[ 'walker' ]      = new AddMarkup_Nav_Widget();
	}
	return $nav_menu_args;
}, 10, 4 );

