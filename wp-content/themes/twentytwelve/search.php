<?php
/**
 * Template Name: Company Search Template
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
 /*min-width:321px;*/ border-radius: 3px; }

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
                                      <div style="font-size:36px;color:#7da700; padding-bottom: 10px;">Search</div>



<div id="search-form" style=" background-color: #535353; display: inline-table; padding: 21px; color: white; margin-bottom: 20px;" >

<p style="font-size: 19px; padding-bottom: 20px; ">Search Industry Further:</p>

<form role="search" action="<?php echo home_url( '/' ); ?>" method="get">
<div  style="margin-bottom:15px; ">
Keywords<br /><br />
<input type="search" class="search-field" value="" name="s" size="70" maxlength="88" style=" max-width: 350px; background-color: white; ">
</div>

<div style="float: left; ">
Industry<br /><br />
<select name="business"  style=" height: 31px;  min-width: 242px;  ">
<option value="Whole Site">Energy</option>
<option value="Pages">Entertainment</option>
<option value="Blog">Fashion</option>
  <option value="Blog">Food</option>
  <option value="Blog">Healthcare</option>
  <option value="Pages">Mobile Application</option>

<option value="Pages">Mobile Game</option>

<option value="Pages">Music</option>

<option value="Pages">Pharma</option>

<option value="Pages">Real Estate</option>

<option value="Pages">Retail</option>
</select>
</div>

<div style="float: left;margin-left:10px; ">
Business Type (Company/Incubator)<br /><br />
<select name="business" onchange="changeHiddenInput(this)"  style=" height: 31px;  min-width: 242px;  ">
<option value="Whole Site">Both</option>
<option value="Pages">Companies</option>
<option value="Blog">Incubators</option>
</select>
</div>
<div  style="display: inline-block;float:left; max-width:300px; padding-left: 20px;  ">
Stage<br /><br />
  <select name="business" id="busines" onchange="changeHiddenInput(this)"  style=" height: 31px;  min-width: 242px;  ">
<option value="">All</option>
<option value="nod">Noodling-(Thinking about an idea)</option>
<option value="dev">Developing-(Building-Testing)</option>
<option value="sell">Selling-(Initial Proof of Concept)</option>
<option value="grow">Growing-(Annualized Sales $1.0m+))</option>
 </select> 
</div> 
  <br/>
  <div style="float:left;margin-top:15px;">
<div  style="display: inline-block;float:left; max-width:300px; padding-left: 0px; ">Location
<br /><br />
<input type="text" size="28" value="state" style="background:white;padding-top:5px;padding-bottom:5px;"></div>
    
<div  style="display: inline-block;float:left; max-width:300px; padding-left: 10px; ">
Filter by region<br /><br />
<select name="business"  style=" height: 31px;  min-width: 242px;  ">
<option value="Whole Site">USA-All</option>
<option value="Pages">USA-Northeast</option>
<option value="Blog">USA-Southeast</option>
  <option value="Blog">USA-Midwest</option>
  <option value="Blog">USA-Northwest</option>
  <option value="Blog">USA-Southwest</option>
  <option value="Blog">Canada</option>
  <option value="Blog">Mexico</option>
  <option value="Blog">South America</option>
  <option value="Blog">Europe</option>
</select>
</div>
<div  style="display: inline-block;float:left; max-width:300px; padding-left: 10px; ">Zip Code
<br /><br />
<input type="text" size="28" value="zip" style="background:white;padding-top:5px;padding-bottom:5px;"></div>
</div>
<div>
<input type="hidden" name="post_type" id="postype" value= ""/> <!-- // hidden 'your_custom_post_type' value -->
<span style="float:right; padding-top: 15px; padding-bottom: 20px;" ><input name="myBtn" type="submit"></span>
  <span style="float:left; padding-top: 15px; padding-bottom: 20px;" ><a href="http://www.startupstowatch.com/search-advance/">Advance Search</a></span>
</div>
</form>
<script>
  function changeHiddenInput (objDropDown)
{
   document.getElementById("postype").value = objDropDown.value; 
}
  </script>

          </div>
          

			  <?php query_posts( 'post_type=company&posts_per_page=3' ); ?>
    <?php while ( have_posts() ) : the_post(); ?>
    	
        		<div class="postbox-two">

				<div class="postpicture">


		<?php the_post_thumbnail(); ?>

				</div>


				<div class="postcontent">
   <p style="font-size:30px;color:#7da700; padding-bottom: 10px;"> <?php the_title() ?> </p>

					<p><?php echo content('55'); ?></p>

					<br>




		</div>


				</div>




        
    	<?php endwhile; ?>
    <?php wp_reset_query(); ?> 

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>