<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div><!-- #main .wrapper -->
<div id="fincubators" >

    <div>
        <?php 
         // Custom widget Area Start
         if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Resource Widget Area') ) : ?>
        <?php endif;
        // Custom widget Area End
        ?>
    </div>
    
</div>

<div id="spotlights">

 <?php echo do_shortcode('[xyz-ips snippet="latestnews"]'); ?>
  
<!--
  <div style="  max-width: 700px; display: inline-block; ">
	<form name="newsFilter" method="post" id="newsFilter">
	<p style="color:#00a7c5;  font-size: 20px; font-weight: bold; padding-bottom: 14px;font-family: 'Exo 2', sans-serif;  ">LATEST NEWS FROM OUR CHANNELS 
		<select name="SW_btype" style="height: 30px;width: 145px; margin-top: 0px; margin-left: 10px; background: #fff;">
		<option value="0">Filter By Channel</option>
		<option value="1">All</option>
		<option value="2">Toys</option>
		<option value="3">Energy</option>
		<option value="4">Entertainment</option>
		<option value="5">Fashion</option>
		<option value="6">Food</option>
		<option value="7">Healthcare</option>
		<option value="8">Mobile App</option>
		</select>
		<input class="reg-button small" name="Filter_submit" type="submit" value="Go">
	</p>
	</form>
	
	<div class="als-container" id="demo1" style="width: 695px; border: 0; background: none;">
	<span class="als-prev" style="top: 34px;"><img src="<?php get_option( 'siteurl' );?> /wp-content/uploads/sites/2/2014/06/arrow-left.png" alt="prev" title="previous" /></span>
  		<div class="als-viewport">
	<ul style="text-align:left;" class="als-wrapper">
		  <?php query_posts( 'category_name=channel news&posts_per_page=10' ); ?>
	    <?php while ( have_posts() ) : the_post(); ?>

   		 <li id="post-<?php the_ID(); ?>" class="industry als-item" style="margin-left: 10px; margin-right:0;">
   			<div class="rotateImage" style="float: left; margin-top: 2px;">
            <a href="<?php echo get_permalink(); ?>" ><?php the_post_thumbnail(); ?></a>
			</div>
            <div style="max-width: 380px; margin-left: 20px; margin-right: 20px; float: left;line-height: 1.5em; text-align: left;">
				<span style="font-weight: bold; text-transform: uppercase;"><?php echo get_the_title(); ?></span><br/>
				<?php the_excerpt(); ?>
				<?php //the_content('Read more...'); ?>
			</div>
         </li>
    		<?php endwhile; ?>
    		<?php wp_reset_query(); ?> 
	</ul>
</div>

	<span class="als-next" style="height: 110px; background: #fff; right: 25px; top: 0;"><img src="<?php get_option( 'siteurl' );?>/wp-content/uploads/sites/2/2014/06/arrow-right.png" alt="next" title="next" style="margin-top: 34px;"/></span>
	</div>
</div>
-->

 <?php echo do_shortcode('[xyz-ips snippet="socialmedia"]'); ?>

  
<!--
<div style="  max-width: 400px; display: inline-block; float: right; ">
<p style="color:#b9166e;  font-size: 20px; font-weight: bold; padding-bottom: 14px;font-family: 'Exo 2', sans-serif; ">FOLLOW S2W.COM ON SOCIAL MEDIA</p>
<div style="max-width: 245px; margin: 0 auto; text-align:center; ">
<img src="<?php get_option( 'siteurl' );?>/wp-content/uploads/sites/2/2014/03/social.png" /><br>
<p><h3 style="color:gray; "><strong>STAY INFORMED</strong></p>
<span  style=" font-weight: normal; " >Keep up to date on all our happenings.  Join us on social media for instant updates.</span> </div>
</div>





</div>
-->

	<footer id="colophon" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'twentytwelve_credits' ); ?>
			<nav id="site-navigation" class="main-navigation" role="navigation">
			<h3 class="menu-toggle"><?php _e( 'Menu', 'twentytwelve' ); ?></h3>
			<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentytwelve' ); ?>"><?php _e( 'Skip to content', 'twentytwelve' ); ?></a>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
		</nav><!-- #site-navigation -->
<p>Copyright 2014.  Get Successful, Inc.  All Rights Reserved. </p>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->



<?php wp_footer(); ?>
</body>
</html>