<?php
/**
 * Template Name: channel Template
 * 
 * 
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<style>
	
	
</style>
	
	<div id="primary" class="site-content">
		<div id="content" role="main">
			  <?php query_posts( 'post_type=channel&posts_per_page=3' ); ?>
    <?php while ( have_posts() ) : the_post(); ?>
    	
    	<?php endwhile; ?>
    <?php wp_reset_query(); ?> 

		</div><!-- #content -->

	</div><!-- #primary -->

<?php get_footer(); ?>