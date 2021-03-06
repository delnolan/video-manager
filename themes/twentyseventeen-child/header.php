<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentyseventeen' ); ?></a>

	<header id="masthead" class="site-header" role="banner">

		<div class="above-the-fold">
			<div class="overlay"></div>
			<video id="intro_video" loop muted autoplay">
				<source src="<?php echo get_stylesheet_directory_uri() ?>/assets/Vift.mp4" type="video/mp4">
				<source src="<?php echo get_stylesheet_directory_uri() ?>/assets/Vift.ogg" type="video/ogg">
				Your browser does not support the video tag.
			</video>
			<div class="hero">
				<h1>Vift</h1>
				<div>Making Video Real</div>
				<a href="<?php echo get_permalink(5);?>">Create Your Video</a>
			</div>
		</div>
		
		<script>
		var video = document.getElementById("intro_video");
		video.oncanplaythrough = function() {
			video.muted = true;
			video.play();
		}
		</script>

		<?php if ( has_nav_menu( 'top' ) ) : ?>
			<div class="navigation-top">
				<div class="wrap">
					<?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>
				</div><!-- .wrap -->
			</div><!-- .navigation-top -->
		<?php endif; ?>

	</header><!-- #masthead -->
