<?php /* Wrapper Name: Header */ ?>
<div class="row">
	<div class="span6 hidden-phone" data-motopress-type="static" data-motopress-static-file="static/static-search.php">
		<?php get_template_part("static/static-search"); ?>
	</div>
	<div class="span3" data-motopress-type="static" data-motopress-static-file="static/static-logo.php">
		<?php get_template_part("static/static-logo"); ?>
	</div>
	<div class="span9" data-motopress-type="static" data-motopress-static-file="static/static-nav.php">
		<?php get_template_part("static/static-nav"); ?>
	</div>
</div>
<div class="row">
	<div class="offset1 span10">
		<?php if ( is_page_template('page-home.php') ) { ?>
			<div data-motopress-type="static" data-motopress-static-file="static/static-slider.php">
				<?php get_template_part("static/static-slider"); ?>
			</div>
		<?php }  ?>
	</div>
</div>