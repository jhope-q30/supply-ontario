<?php
/* BREADCRUMB NAVIGATION FUNCTION */
function breadcrumb_navigation( $page, $ref = array() ){
	$breadcrumb = $ref;
	if( !count( $breadcrumb ) ){
		array_unshift( $breadcrumb, array( $page->post_title ) );
	} else {
		array_unshift( $breadcrumb, array( $page->post_title, get_permalink( $page->ID ) ) );
	}
	if( $page->post_parent ){
		breadcrumb_navigation( get_page( $page->post_parent ), $breadcrumb );
		return;
	} else {
		/// process the breadcrumb
		$output = '<li class="home"><a href="' . get_home_url() . '">' . __( 'Home', '_supply_ontario' ) . '</a></li>';
		for( $q = 0; $q < count( $breadcrumb ); ++$q ){
			if( count( $breadcrumb[$q] ) > 1 ){
				$output .= '<li><a href="' . $breadcrumb[$q][1] . '">' . $breadcrumb[$q][0] . '</a></li>';
			} else {
				$output .= '<li class="current">' . $breadcrumb[$q][0] . '</li>';
			}
		}
		echo '<ul class="breadcrumb">' . $output . '</ul>';
	}
}