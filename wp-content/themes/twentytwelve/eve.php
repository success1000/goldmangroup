<?php
/**
 * Template Name: Eve
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Twelve already
 * has tag.php for Tag archives, category.php for Category archives, and
 * author.php for Author archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
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

.postpicture {float: left; }

.postbox {clear: both; border-bottom: 3px rgb(206, 206, 206) solid; padding-bottom: 37px; display: inline-table; margin-bottom: 33px;}

#fincubators {display:none; }

#spotlights {display:none; }



.readp { clear:both; padding: 10px;  width: 165px; height: 17px; padding-top: 7px; padding-left: 0; padding-right: 0; display: inline-block; margin-right: 40px;

background: #eeeeee; /* Old browsers */

background: -moz-linear-gradient(left,  #eeeeee 0%, #cccccc 100%); /* FF3.6+ */

background: -webkit-gradient(linear, left top, right top, color-stop(0%,#eeeeee), color-stop(100%,#cccccc)); /* Chrome,Safari4+ */

background: -webkit-linear-gradient(left,  #eeeeee 0%,#cccccc 100%); /* Chrome10+,Safari5.1+ */

background: -o-linear-gradient(left,  #eeeeee 0%,#cccccc 100%); /* Opera 11.10+ */

background: -ms-linear-gradient(left,  #eeeeee 0%,#cccccc 100%); /* IE10+ */

background: linear-gradient(to right,  #eeeeee 0%,#cccccc 100%); /* W3C */

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#eeeeee', endColorstr='#cccccc',GradientType=1 ); /* IE6-9 */

}

.readp a {text-decoration: none; border-left: 1px solid gray; padding-left: 40px; border-right: 1px solid gray; border-width: 5px; color: black; font-size: 13px;

font-size:15px;  padding-right: 40px;}





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

			<?php dynamic_sidebar( 'sidebar-4' ); ?>

		</div><!-- #secondary -->

	<?php endif; ?>



	<div id="primary" class="site-content">

		<div id="content" role="main">



			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>



<div id="search-form" style=" background-color: #535353; display: inline-table; padding: 21px; color: white; " >

<p style="font-size: 19px; padding-bottom: 20px; ">Search Event Further:</p>


<form role="search" action="<?php echo home_url( '/' ); ?>" method="get">

<div style="display:inline-block; max-width:300px;float:left ">
Business Type (Company/Incubator)<br /><br />
<select name="business" id="busines" onchange="changeHiddenInput(this)"  style=" height: 31px;  min-width: 242px;  ">
<option value="">Both</option>
<option value="company">Comapnies</option>
<option value="incubators">Incubators</option>
</select>
</div>
<div  style="display: inline-block;float:left; max-width:300px; padding-left: 20px; ">
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



<?php // get_sidebar(); ?>

<?php get_footer(); ?>