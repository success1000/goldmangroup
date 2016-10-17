<div class="column-right">
	
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(__('Right Sidebar','theme997')) ) : else : ?>
		
		<?php wp_list_bookmarks(
			'title_before=		<div class="title"><div><div><h2>				
			&title_after=		</h2></div></div></div>					
			&category_before=	<div class="widget widget_links %class" id="%id blogroll"><div class="widget-bgr">
			&category_after=	</div></div>
			');
		?>
		
		<?php
			$r = new WP_Query(array('showposts' => 5, 'what_to_show' => 'posts', 'nopaging' => 0, 'post_status' => 'publish', 'caller_get_posts' => 1));
			if ($r->have_posts()) :
		?>
			<div class="widget widget_recent_entries">
				<div class="widget-bg">
					<div class="title">
						<div><div>
							<h2><?php _e('Recent Posts','theme997'); ?></h2>
						</div></div>
					</div>
					<ul>
						<?php  while ($r->have_posts()) : $r->the_post(); ?>
							<li><a href="<?php the_permalink() ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></li>
						<?php endwhile; ?>
					</ul>
				</div>
			</div>
		<?php endif; ?>
		
		<div class="widget widget_meta">
			<div class="widget-bgr">
				<div class="title">
					<div><div>
						<h2><?php _e('Meta','theme997'); ?></h2>
					</div></div>
				</div>
			
				<ul>
					<?php wp_register(); ?>
						<li><?php wp_loginout(); ?></li>
						<li><a href="http://www.w3.org/" title="This page The World Wide Web Consortium (W3C)"><abbr title="World Wide
						Web Consortium">W3C</abbr> Page</a></li>
						<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
						<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic
						personal publishing platform.">WordPress</a></li>
					<?php wp_meta(); ?>
				</ul>
			
			</div>
		</div>
		
		
	<?php endif; ?>
	
</div><div class="column-center">




