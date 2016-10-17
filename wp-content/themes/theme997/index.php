<?php get_header(); ?>

	<?php get_sidebar(1); ?><?php get_sidebar(2); ?>
	
	<?php if (is_home()) : ?>
		<div class="welcome">
				<div class="title">
					<h2><span>Welcome</span>to our city portal!</h2>
				</div>
				<div class="text-box">
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent vestibulum molestie lacus.
					Aenean nonummy hendrerit mauris. Phasellus porta. Fusce suscipit varius mi. Cum sociis natoque
					penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla dui. Fusce feugiat
					malesuada odio. Morbi nunc odio, gravida at, cursus nec, luctus a, lorem.
					<a class="more-link" href="#">Read more</a></p>
				</div>
			</div>
		<?php endif; ?>
		
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
					
					<div class="indent">
						
						<div class="title">

							<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
							
							<div class="date">
								<?php the_time('l, F j, Y') ?> @ <span><?php the_time('h:m A') ?></span>
							</div>
							
							<div class="author">
								posted by <?php the_author_link() ?>
							</div>
							
						</div>
						
						<div class="text-box">
							<?php the_content('Read the rest of this page'); ?>
						</div>
						
						<div class="comments">
							<?php comments_popup_link('0 Comments', '1 Comment', '% Comments', '' , 'off'); ?>
						</div>
						
						<div class="link-edit"><?php edit_post_link('Edit Post', ''); ?></div>	
						
					</div>
					
				</div>
			<?php endwhile; ?>
		
			<div class="navigation nav-top">
				<div class="alignleft"><?php next_posts_link('Oldser entries') ?></div>
				<div class="alignright"><?php previous_posts_link('Newer Entries') ?></div>
			</div>
		
		<?php else : ?>
			<h2 class="pagetitle">Not Found</h2>
			<p class="center">Sorry, but you are looking for something that isn't here.</p>
			<?php get_search_form(); ?>
		<?php endif; ?>
		

<?php get_footer(); ?>