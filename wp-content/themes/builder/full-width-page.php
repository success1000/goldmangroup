<?php
/**
 * Full Content Template
 *
   Template Name:  Full Width Page
 *
 */
?>
<?php get_header(); ?>

		<div class="container">

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

						<div id="full-width" class="clearfix" role="main">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					        <?php if (function_exists("builder_breadcrumb_lists")) { ?>
							<?php builder_breadcrumb_lists(); ?>
							<?php } ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">


								</header> <!-- end article header -->

								<section class="entry-content clearfix" itemprop="articleBody">
									<?php the_content(); ?>
							</section> <!-- end article section -->

								<footer class="article-footer">
									<?php the_tags( '<span class="tags">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ' ', '' ); ?>

								</footer> <!-- end article footer -->

								<?php comments_template(); ?>

							</article> <!-- end article -->

							<?php endwhile; else : ?>

									<article id="post-not-found" class="hentry clearfix">
										<header class="article-header">
											<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the page.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div> <!-- end #main -->

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

			</div> <!-- end .container -->


<?php get_footer(); ?>
