<?php
/**
 * Template Name: Homepage Template
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
<div class="als-container" id="demo2">
  <span class="als-prev"><img src="http://www.startupstowatch.com/wp-content/uploads/sites/2/2014/06/arrow-left.png" alt="prev" title="previous" /></span>
  	<div class="als-viewport">
	<ul style="text-align:left;" class="als-wrapper">
		  <?php query_posts( 'post_type=Channel&posts_per_page=11' ); ?>
	    <?php while ( have_posts() ) : the_post(); ?>

   		 <li id="post-<?php the_ID(); ?>" class="industry als-item">
   			<a href="<?php echo get_permalink(); ?>" ><p style="text-align:center; margin:0 auto; height: 91px;"><?php the_post_thumbnail(); ?></p><p style="text-align:center; margin:0 auto; height: 22px;background: #b5b6b0; color:#2f2f2f; font-family: 'Exo 2', sans-serif;text-transform: uppercase;font-weight: bold; padding-top: 9px"><?php echo get_the_title(); ?></p></a>
		 </li>

    	
    		<?php endwhile; ?>
    		<?php wp_reset_query(); ?> 
	</ul>
</div>
  <span class="als-next"><img src="http://www.startupstowatch.com/wp-content/uploads/sites/2/2014/06/arrow-right.png" alt="next" title="next" /></span>
</div>

<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
		<div id="tertiary" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-5' ); ?>
			<?php dynamic_sidebar( 'sidebar-4' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>
	
	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>