<?php

/**

 * The Template for displaying all single-company posts

 *

 * @package WordPress

 * @subpackage Twenty_Twelve

 * @since Twenty Twelve 1.0

 */



get_header(); ?>

<style>


  @media screen and (min-width: 600px) {

	

	.site-content {

		float: left;

		width: 75%;

		padding-left: 20px;

	}

    }

#fincubators { display:none !important;  }
#spotlights {display:none !important; }

  </style>

<div style=" padding-top: 10px;  padding-bottom: 10px; ">



<ul style="text-align:left;">

	  <?php query_posts( 'post_type=industry&posts_per_page=6' ); ?>

    <?php while ( have_posts() ) : the_post(); ?>



    <li id="post-<?php the_ID(); ?>" class="industry" >

   <a href="<?php echo get_permalink(); ?>" ><p style="text-align:center; margin:0 auto; "><?php the_post_thumbnail(); ?></p></a>

 

</li>



    	

    	<?php endwhile; ?>

    <?php wp_reset_query(); ?> 



</ul>

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



				<?php get_template_part( 'content-company', get_post_format() ); ?>



			<?php endwhile; // end of the loop. ?>



		</div><!-- #content -->

	</div><!-- #primary -->



<?php //get_sidebar(); ?>

<?php get_footer(); ?>