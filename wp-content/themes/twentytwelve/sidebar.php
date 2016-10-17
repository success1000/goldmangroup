<?php
/**
 * The sidebar containing the main widget area
 *
 * If no active widgets are in the sidebar, hide it completely.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

<style>
.widget-title-black {    margin-bottom: 0 !important;
    font-size: 20px !important;
    background-color: #fff!important;
    color: #333333 !important;
    padding-left: 15px !important;
    line-height: 2.18182;
font-weight: bold;
text-transform: uppercase;
font-family: 'Exo 2', sans-serif;
}
.widgetblack {background:#fff;margin-bottom: 1.5rem; border: 1px #ccc solid;}
</style>
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>