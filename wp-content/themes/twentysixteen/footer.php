<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

		</div><!-- .site-content -->

			</div><!-- .site-inner -->
<footer id="colophon" class="site-footer" role="contentinfo">
			<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<nav class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Primary Menu', 'twentysixteen' ); ?>">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'primary',
							'menu_class'     => 'primary-menu',
						 ) );
					?>
				</nav><!-- .main-navigation -->
			<?php endif; ?>

			<?php if ( has_nav_menu( 'social' ) ) : ?>
				<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'twentysixteen' ); ?>">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'social',
							'menu_class'     => 'social-links-menu',
							'depth'          => 1,
							'link_before'    => '<span class="screen-reader-text">',
							'link_after'     => '</span>',
						) );
					?>
				</nav><!-- .social-navigation -->
			<?php endif; ?>

			<div class="site-info">
				<?php
					/**
					 * Fires before the twentysixteen footer text for footer customization.
					 *
					 * @since Twenty Sixteen 1.0
					 */
					do_action( 'twentysixteen_credits' );
				?>
				<span class="site-title"> <span style="margin-left:40px;">Follow Us : &nbsp;<img src="http://www.venturelistings.com/assets/img/site/icon_twitter.gif"> &nbsp;<img src="http://www.venturelistings.com/assets/img/site/icon_facebook.gif"> &nbsp;<img src="http://www.venturelistings.com/assets/img/site/icon_goggle.gif"></span><br/><br/><a href="">Home</a> | <a href="">About Us</a> | <a href="">Blog</a> | <a href="">Contact Us </a> | <a href="">Term of Use</a> | <a href="">Sitemap</a><br/><br/><span style="margin-left:40px;">Copyright 2016 Venture Listings.</span></span>
			</div><!-- .site-info -->
		</footer><!-- .site-footer -->

</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>
