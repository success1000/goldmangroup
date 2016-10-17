<?php /* Static Name: Footer text */ ?>
<div id="footer-text" class="footer-text">
	<?php $myfooter_text = of_get_option('footer_text'); ?>
	
	<?php if($myfooter_text){?>
		<?php echo of_get_option('footer_text'); ?>
	<?php } else { ?>
		&copy; <?php echo date('Y'); ?> <a href="<?php echo home_url(); ?>/privacy-policy/" title="Privacy Policy"><?php _e('Privacy Policy', CURRENT_THEME); ?></a>
	<?php } ?>
	<?php if( is_front_page() ) { ?>
		More IT WordPress Themes at <a rel="nofollow" href="http://www.templatemonster.com/category/it-wordpress-themes/" target="_blank">TemplateMonster.com</a>
	<?php } ?>
</div>