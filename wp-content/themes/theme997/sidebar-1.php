<div class="column-left">
	
	<?php 	/* Widgetized sidebar, if you have the plugin installed. */ ?>
		
		<!-- Author information is disabled per default. Uncomment and fill in your details if you want to use it.
			<li><h2>Author</h2>
			<p>A little something about you, the author. Nothing lengthy, just an overview.</p>
		</li>
		-->
		<?php if ( is_404() || is_category() || is_day() || is_month() ||
					is_year() || is_search() || is_paged() ) {
		?>
	
			<?php /* If this is a 404 page */ if (is_404()) { ?>
			<?php /* If this is a category archive */ } elseif (is_category()) { ?>
				<p class="info-sidebar">You are currently browsing the archives for the <?php single_cat_title(''); ?> category.</p>
			<?php /* If this is a yearly archive */ } elseif (is_day()) { ?>
				<p class="info-sidebar">You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
					for the day <?php the_time('l, F jS, Y'); ?>.</p>
			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				<p class="info-sidebar">You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
					for <?php the_time('F, Y'); ?>.</p>
			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				<p class="info-sidebar">You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
					for the year <?php the_time('Y'); ?>.</p>
			<?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
				<p class="info-sidebar">You have searched the <a href="<?php echo bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
					for <strong>'<?php the_search_query(); ?>'</strong>. If you are unable to find anything in these search results, you can try one of these links.</p>
			<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
				<p class="info-sidebar">You are currently browsing the <a href="<?php echo bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives.</p>
	
		<?php } ?>
	
	<?php }?>
	
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(__('Left Sidebar','theme997')) ) : else : ?>
		
		<div class="widget widget_categories">
			<div class="widget-bgr"><div class="bgr">
				<div class="title">
					<div><div>
						<h2><?php _e('Categories','theme997'); ?></h2>
					</div></div>
				</div>
			
				<ul>
					<?php wp_list_categories('show_count=&title_li='); ?>
				</ul>
		
			</div>
		</div></div>
		
		
		<div class="widget widget_archive">
			<div class="widget-bgr"><div class="bgr">
				<div class="title">
					<div><div>
						<h2><?php _e('Archives','theme997'); ?></h2>
					</div></div>
				</div>
				<ul>
					<?php wp_get_archives('show_count=1&type=monthly'); ?>
				</ul>
			</div></div>
		</div>
		
	<?php endif; ?>
	
</div>




