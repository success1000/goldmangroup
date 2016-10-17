<?php
/**
 * Template Name: Blog 
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
#title {
	background: rgb(255,255,255); /* Old browsers */
background: -moz-linear-gradient(left,  rgba(255,255,255,1) 0%, rgba(15,9,15,1) 0%, rgba(186,186,186,1) 0%, rgba(15,9,15,1) 85%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(255,255,255,1)), color-stop(0%,rgba(15,9,15,1)), color-stop(0%,rgba(186,186,186,1)), color-stop(85%,rgba(15,9,15,1))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(left,  rgba(255,255,255,1) 0%,rgba(15,9,15,1) 0%,rgba(186,186,186,1) 0%,rgba(15,9,15,1) 85%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(left,  rgba(255,255,255,1) 0%,rgba(15,9,15,1) 0%,rgba(186,186,186,1) 0%,rgba(15,9,15,1) 85%); /* Opera 11.10+ */
background: -ms-linear-gradient(left,  rgba(255,255,255,1) 0%,rgba(15,9,15,1) 0%,rgba(186,186,186,1) 0%,rgba(15,9,15,1) 85%); /* IE10+ */
background: linear-gradient(to right,  rgba(255,255,255,1) 0%,rgba(15,9,15,1) 0%,rgba(186,186,186,1) 0%,rgba(15,9,15,1) 85%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#0f090f',GradientType=1 ); /* IE6-9 */

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
.postpicture {float: left; }
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

.thumbtext {   padding: 15px;
background-color: gray;
color: white;
font-size: 11px;
min-height: 28px;  } 

@media screen and (min-width: 600px) {
.site-content {
width: 75.999167%;
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
			
			
			<div id="title"><p>Today's Featured Member Entries</p></div>
			
			
	
		  <?php query_posts( 'post_type=post&posts_per_page=3' ); ?>
    <?php while ( have_posts() ) : the_post(); ?>
    			
			
			<div class="postbox">
				
				<div class="postpicture">
					
									
		<?php the_post_thumbnail(); ?>
		<div class="thumbtext"><p><?php the_title() ?></p></div>						   
						
				</div>
				
		
				<div class="postcontent">
					
					<h1><?php the_title() ?></h1>
					<p><?php the_excerpt(); ?></p>
					
					<br>
					
					
					<div class="topictag">
					<span> Topics: <?php
$categories = get_the_category();
$separator = ' ';
$output = '';
if($categories){
	foreach($categories as $category) {
		$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
	}
echo trim($output, $separator);
}
?></span><span style=" float: right; "><?php the_tags(); ?></span>
					</div>
					<br>
					<div>
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
    <?php wp_reset_query(); ?> 
			
				
				
				
				
				
				
				
			</div>

	
    	
    	
    	

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>