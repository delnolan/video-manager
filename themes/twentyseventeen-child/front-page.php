<?php 
/*
 * Template Name: Homepage
*/
get_header();

	if ( have_posts() ) :
		while ( have_posts() ) : the_post();

			//echo the_content();

		endwhile;
	endif;

get_footer();
