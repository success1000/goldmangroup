<?php
/**
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
.postbox-all {clear: both; border-bottom: 3px rgb(206, 206, 206) solid; padding-bottom: 37px; display: inline-table; margin-bottom: 33px;}
.postbox-one {clear: both; border-bottom: 3px rgb(206, 206, 206) solid; padding-bottom: 37px; display: inline-table; margin-bottom: 33px;}
.postbox-two {clear: both; border-bottom: 3px rgb(206, 206, 206) solid; padding-bottom: 37px; display: inline-table; margin-bottom: 33px;}
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
width: 75.999167%;
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
                          <?php while ( have_posts() ) : the_post(); ?>
                                      <div style="font-size:36px;color:#7da700;border-bottom: 1px solid #7da700;padding-bottom: 10px;"> <?php the_title() ?> </div>
                                           <?php endwhile; ?>
	<br/><br/><br/>
<?php //the_content(); ?>


<div id="industry-company">
<div class="feat" style=" padding-bottom: 15px; "><span  style=" display: inline-block; "><h1 style="font-size: 24px;font-weight:normal ">Featured Company </h1></span><span calss="alllink" style=" display: inline-block; float: right; "><p><a href="?link=1" name="link1">View all companies</a></p></span></div>
   <?php
        $link=$_GET['link'];
        if ($link == '1'){

// Find connected companies
$connected = new WP_Query( array(
  'connected_type' => 'industry to company',
  'connected_items' => get_queried_object(),
  'posts_per_page' => 10,

) );

// Display connected pages

 while ( $connected->have_posts() ) : $connected->the_post(); ?>

			<div class="postbox-all">

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

?>
<style>
  .feat{display:none}
  .alllink{display:none}
  </style>
  <?php } else { ?>
  <?php
  // Find connected companies
$connected = new WP_Query( array(
  'connected_type' => 'industry to company',
  'connected_items' => get_queried_object(),
  'nopaging' => false,
  'posts_per_page' => 1,

) );

// Display connected pages
while ( $connected->have_posts() ) : $connected->the_post(); ?>

			<div class="postbox-one">

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

?>

<?php
// Find connected incubators
$connected = new WP_Query( array(
  'connected_type' => 'industry to incubators',
  'connected_items' => get_queried_object(),
  'nopaging' => false,
  'posts_per_page' => 1,
) );

// Display connected pages
?>
      
<div id="industry-incubators" >
<div class="feat" style=" padding-bottom: 15px; "><span  style=" display: inline-block; "><h1 style="font-size: 24px;font-weight:normal  ">Featured Incubators</h1></span><span calss="alllink" style=" display: inline-block; float: right; "><p><a href="?link=2" name="link2">View All Incubators</a></p></span></div>
<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>


			<div class="postbox-two">

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
wp_reset_postdata(); ?>


                <?php } ?>

<?php
        $link=$_GET['link'];
        if ($link == '2'){

          // Find connected incubators
$connected = new WP_Query( array(
  'connected_type' => 'industry to incubators',
  'connected_items' => get_queried_object(),
  'nopaging' => false,
  'posts_per_page' => 10,
) );

// Display connected pages
?>
  <style>
    .postbox {display:none}
    .postbox-one {display:none}
    .postbox-two {display:none}
    .feat{display:none}
    .allink{display:none}
</style>    
<div id="industry-incubators" >
<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>


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
wp_reset_postdata(); ?>


                <?php } ?>


<div id="search-form" style=" background-color: #535353; display: inline-table; padding: 21px; color: white; " >

<p style="font-size: 19px; padding-bottom: 20px; ">Search Industry Further:</p>
 

<form role="search" action="<?php echo home_url( '/' ); ?>" method="get">

<div style="display:inline-block; max-width:300px;float:left ">
Business Type (Company/Incubator)<br /><br />
<select name="business" id="busines" onchange="changeHiddenInput(this)"  style=" height: 31px;  min-width: 242px;  ">
<option value="">Both</option>
<option value="company">Comapnies</option>
<option value="incubators">Incubators</option>
</select>
</div>
<div  style="display: inline-block;float:left; max-width:300px; padding-left: 20px;  ">
Location<br /><br />
<input type="search" class="search-field" value="" name="s" size="70" maxlength="88" style=" max-width: 200px; ">
</div>
<div  style="display: inline-block;float:left; max-width:300px; padding-left: 20px; ">
<br /><br />
<select name="miles" style=" height: 31px;  min-width: 242px; ">
<option value="Whole Site">Select Distance From (Miles)</option>
<option value="Pages">10</option>
<option value="Pages">20</option>
<option value="Pages">30</option>
<option value="Pages">40</option>
<option value="Pages">50</option>
<option value="Blog">100</option>
</select>
</div>
<div>
<input type="hidden" name="post_type" id="postype" value= ""/> <!-- // hidden 'your_custom_post_type' value -->
<span style="float:right; padding-top: 15px; padding-bottom: 20px;" ><input name="myBtn" type="submit"></span>
</div>
</form>

<script>
  function changeHiddenInput (objDropDown)
{
   document.getElementById("postype").value = objDropDown.value; 
}
  </script>
          </div>
          
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>