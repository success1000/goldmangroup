<?php
/**
 * Template Name: incubators
 *
 * Description: Twenty Twelve loves the no-sidebar look as much as
 * you do. Use this page template to remove the sidebar from any page.
 *
 * Tip: to remove the sidebar from all posts and pages simply remove
 * any active widgets from the Main Sidebar area, and the sidebar will
 * disappear everywhere.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
<style>
#title {	background: #0a0702; /* Old browsers */
background: -moz-linear-gradient(left,  #0a0702 0%, #dddddd 98%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, right top, color-stop(0%,#0a0702), color-stop(98%,#dddddd)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(left,  #0a0702 0%,#dddddd 98%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(left,  #0a0702 0%,#dddddd 98%); /* Opera 11.10+ */
background: -ms-linear-gradient(left,  #0a0702 0%,#dddddd 98%); /* IE10+ */
background: linear-gradient(to right,  #0a0702 0%,#dddddd 98%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0a0702', endColorstr='#dddddd',GradientType=1 ); /* IE6-9 */

}


#title p {
    font-size: 28px;
    color: white;
    font-style: italic;
    padding: 9px;
    margin-bottom: 30px;
}	

.read-more { display:none;   }
.postcontent {max-width: 463px; float: right;  margin-left: 20px; } 
.postpicture {float: left;width:320px; }
.postbox {clear: both; border-bottom: 3px rgb(206, 206, 206) solid; padding-bottom: 37px; display: inline-table; margin-bottom: 33px;}
#fincubators {display:none; }
#spotlights {display:none; }

.readp { clear:both; padding: 10px;  width: 165px; height: 17px; padding-top: 7px; padding-left: 0; padding-right: 0; display: inline-block; margin-right: 40px;
background: #eeeeee; /* Old browsers */
background: -moz-linear-gradient(#f6f6f6 20%, #e1e1e1 50%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, right top, color-stop(0%,#eeeeee), color-stop(100%,#cccccc)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(#f6f6f6 20%, #e1e1e1 50%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(#f6f6f6 20%, #e1e1e1 50%); /* Opera 11.10+ */
background: -ms-linear-gradient(#f6f6f6 20%, #e1e1e1 50%); /* IE10+ */
background: linear-gradient(#f6f6f6 20%, #e1e1e1 50%;) /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#eeeeee', endColorstr='#cccccc',GradientType=1 ); /* IE6-9 */
border: 1px solid #e9eaeb;
}
.readp a {text-decoration: none; border-left: 1px solid #027dd4; padding-left: 38px; border-right: 1px solid #027dd4; border-width: 5px; color: black; text-decoration:capitalize;font-size:15px;  padding-right: 40px;}


.postcontent h1 {  font-size: 25px; font-weight: normal;  padding-bottom:10px; }

.postcontent p {  line-height: 20px; font-size: 17px; }

.topictag {
    border-top: 1px solid gray;
    padding-top: 10px;
    border-bottom: 1px solid gray;
    padding-bottom: 10px;
}

.entry-content img, .comment-content img, .widget img, img.header-image, .author-avatar img, img.wp-post-image {
 min-width:321px; border-radius: 3px; }

.thumbtext {   padding: 15px;
background-color: #b6b6b1;
color: #3f3f3f;
font-size: 12px;
min-height: 28px; 
min-width:291px;  } 

@media screen and (min-width: 600px) {
.site-content {
/*width: 75.999167%;*/
width: 75%;
}
    .widget-area {
		float: left;
		width: 21.041666667%;
	}
	

}


</style>


<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
		<div id="tertiary" class="widget-area" role="complementary">
      <?php dynamic_sidebar( 'sidebar-5' ); ?>
			<?php dynamic_sidebar( 'sidebar-4' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
<?php 

$args = array(
	'post_type' => 'incubators'
);
$the_query = new WP_Query( $args ); ?>

<?php if ( $the_query->have_posts() ) : ?>

  <!-- pagination here -->

  <!-- the loop -->
  

<div id="industry-company">
<div class="" style=" padding-bottom: 15px; "></div>
<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			<div class="postbox">
				
				<div class="postpicture">									
		<?php the_post_thumbnail(); ?>
		<div class="thumbtext"><p><?php echo wp_trim_words( get_the_content(), 12 ); ?></p></div>						   
						
				</div>
				
		
				<div class="postcontent">
					
			
					<p><?php echo content('55'); ?></p>
					
					<br>
					
					
					
					<br>
					<div style=" border-top: 3px rgb(206, 206, 206) solid; padding-top: 15px; " >
					<p class="readp"><a href="<?php echo get_permalink(); ?>" >Read more </a></p>	
 <!-- AddThis Button BEGIN -->	
					<p class="readp"><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=300&amp;pubid=ra-50016afb26a6af04" style=" padding-right: 43px;" >Share This</a></p>
                    <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50016afb26a6af04"></script>
<!-- AddThis Button END -->
					</div>
						

			
		</div>			
					
					
				</div>
				
				
<?php endwhile; ?>
</div>

<?php 
// Prevent weirdness
wp_reset_postdata();

endif;

?>


		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>