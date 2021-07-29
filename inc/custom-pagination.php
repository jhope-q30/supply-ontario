<?php
/* PAGINATION ( credit to twentynineteen ) */
if ( ! function_exists( '_supply_ontario_the_posts_navigation' ) ) :
	function _supply_ontario_the_posts_navigation() {
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => sprintf(
					'%s <span class="nav-prev-text">%s</span>',
					'',
					__( 'Prev', '_supply_ontario' )
				),
				'next_text' => sprintf(
					'<span class="nav-next-text">%s</span> %s',
					__( 'Next', '_supply_ontario' ),
					''
				),
			)
		);
    }
endif;