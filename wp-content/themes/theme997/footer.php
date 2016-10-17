					</div>	
					
				</div>
				
				
				<?php if (is_home()) : ?>
					
				<div class="custom">
					<div class="indent">
					
						<div class="custom-box box01">
							<div class="title">
								<h2>cinema</h2>
								<span>Maecenas tristique orci ac sem</span>
							</div>
							<div class="img"><img alt="" src="<?php bloginfo('stylesheet_directory'); ?>/images/1page-img3.jpg" /></div>
							<div class="list">
								<a href="#">Lorem ipsum dolor</a>
								<a href="#">Sit amet consectetuer </a>
								<a href="#">Adipiscing elit</a> 
								<a href="#">Praesent vestibulum moles</a>
							</div>
						</div>
						
						<div class="custom-box box02">
							<div class="title">
								<h2>theatre</h2>
								<span>Proin ullamcorper urna</span>
							</div>
							<div class="img"><img alt="" src="<?php bloginfo('stylesheet_directory'); ?>/images/1page-img4.jpg" /></div>
							<div class="list">
								<a href="#">Aenean nonummy hendrerit</a>
								<a href="#">Phasellus porta</a></li>
								<a href="#">Fusce suscipit varius mi</a>
								<a href="#">Cum sociis natoque</a>
							</div>
						</div>
						
						<div class="custom-box box03">
							<div class="title">
								<h2>sports</h2>
								<span>Donec eget tellus non erat lacinia </span>
							</div>
							<div class="img"><img alt="" src="<?php bloginfo('stylesheet_directory'); ?>/images/1page-img5.jpg" /></div>
							<div class="list">
								<a href="#">Cum sociis natoque penatibus</a>
								<a href="#">Magnis dis parturient</a>
								<a href="#">Montes nascetur ridiculus</a>
							</div>
						</div>
						
						<div class="custom-box box04">
							<div class="title">
								<h2>Clubs</h2>
								<span>Maecenas tristique orci ac sem</span>
							</div>
							<div class="img"><img alt="" src="<?php bloginfo('stylesheet_directory'); ?>/images/1page-img6.jpg" /></div>
							<div class="list">
								<a href="#">Neque porro quisquam</a>
								<a href="#">Qui dolorem ipsum</a>
								<a href="#">Quia dolor sit amet consect</a>
								<a href="#">Etur adipisci velit sed quia non</a>
							</div>
						</div>
					
					</div>
				</div>
				
				<?php endif; ?>
					
			</div>
			
		</div>
			
		<div class="footer">
			<div class="width">
				
				<div class="indent">
					
					<?php 
						wp_page_menu('show_home=0&sort_column=menu_order, post_title&link_before=<span><span>&link_after=</span></span>');
					?>
					
					<p><?php bloginfo('name'); ?> is proudly powered by <a href="http://www.wordpress.org" target="_blank">WordPress</a><br />
					<a href="<?php bloginfo('rss2_url'); ?>">Entries (RSS)</a> and <a href="<?php bloginfo('comments_rss2_url'); ?>">Comments (RSS)</a>
					<!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->
					<a rel="nofollow" href="http://www.templatemonster.com/wordpress-themes.php" target="_blank">TemplateMonster</a>Design. </p>
					
				</div>
				
			</div>
		</div>
		
	</div>
	
	<?php wp_footer(); ?>
	
	<script type="text/javascript">Cufon.now();</script>
	
</body></html>