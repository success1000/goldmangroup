<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
  <div style="width:100%;background:#dfdfdf">
	<div class="site-inner">
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentysixteen' ); ?></a>

		<header id="masthead" class="site-header" role="banner">
			<div class="site-header-main">
				<div class="site-branding">
					<?php if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php endif;

					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; ?></p>
					<?php endif; ?>
				</div><!-- .site-branding -->

				<?php if ( has_nav_menu( 'primary' ) || has_nav_menu( 'social' ) ) : ?>
					<button id="menu-toggle" class="menu-toggle"><?php _e( 'Menu', 'twentysixteen' ); ?></button>

					<div id="site-header-menu" class="site-header-menu">
						<?php if ( has_nav_menu( 'primary' ) ) : ?>
							<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'twentysixteen' ); ?>">
								<?php
									wp_nav_menu( array(
										'theme_location' => 'primary',
										'menu_class'     => 'primary-menu',
									 ) );
								?>
               
							</nav><!-- .main-navigation -->
            
						<?php endif; ?>

						<?php if ( has_nav_menu( 'social' ) ) : ?>
							<nav id="social-navigation" class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'twentysixteen' ); ?>">
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
             
					</div><!-- .site-header-menu -->
				<?php endif; ?>
				
			</div><!-- .site-header-main -->

			<?php if ( get_header_image() ) : ?>
				<?php
					/**
					 * Filter the default twentysixteen custom header sizes attribute.
					 *
					 * @since Twenty Sixteen 1.0
					 *
					 * @param string $custom_header_sizes sizes attribute
					 * for Custom Header. Default '(max-width: 709px) 85vw,
					 * (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px'.
					 */
					$custom_header_sizes = apply_filters( 'twentysixteen_custom_header_sizes', '(max-width: 709px) 85vw, (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px' );
				?>
				<div class="header-image">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" style="float:left">
						<img src="<?php header_image(); ?>" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_custom_header()->attachment_id ) ); ?>" sizes="<?php echo esc_attr( $custom_header_sizes ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
					</a>
          <?php
if ( ! is_user_logged_in() ) {
          $args = array(
	'echo'           => true,
	'remember'       => true,
	'redirect'       => 'http://23.253.119.145/naveed/venturelistings.com/',
	'form_id'        => 'loginform',
	'id_username'    => 'user_login',
	'id_password'    => 'user_pass',
	'id_remember'    => 'rememberme',
	'id_submit'      => 'wp-submit',
	'label_username' => __( 'Username' ),
	'label_password' => __( 'Password' ),
	'label_remember' => __( 'Remember Me' ),
	'label_log_in'   => __( 'Log In' ),
	'value_username' => '',
	'value_remember' => false
);
?>
          <div style="float:left;width: 469px;margin-left: 155px;"><?php wp_login_form($args); ?>
            <img src="http://www.venturelistings.com/assets/img/site/btn_login_facebook.gif"><br/>
<a href="http://23.253.119.145/naveed/venturelistings.com/wp-login.php?action=register" style="color:black">Don't have an account?</a><a style="color:black" href="http://23.253.119.145/naveed/venturelistings.com/wp-login.php?action=lostpassword"> Lost your password?</a>
 <?php } else { // If logged in: 
?>
  <style>
    .header-image {float: left;
    width: 100%;}
  </style>
            <?php $current_user = wp_get_current_user(); ?> 
           <div style="float:right;"><div>
             <p style="margin:0 0 0.75em"><b>Welcome, <?php echo $current_user->user_login; ?></b> </p>
             <a style="display: inline;color:green" href="http://23.253.119.145/naveed/venturelistings.com/?page_id=90">Update Your Profile</a> | <a style="display: inline;color:green" href="">Mentors</a> | <a style="display: inline;color:green" href="">Members</a> | <a style="display: inline;color:green" href="http://23.253.119.145/naveed/venturelistings.com/wp-login.php?action=logout&redirect_to=http%3A%2F%2F23.253.119.145%2Fnaveed%2Fventurelisting.com">Log out</a></div>
           <?php } ?>
          
          </div>
<style>
   .login-username {margin-bottom:5px}
   .login-password {margin-bottom:5px}
  #user_login {padding: 3px; width: 190px; }
  #user_pass  {margin-left: 4px;padding: 3px; width: 190px;}
  .login-remember {display:none}
  #wp-submit {    font-size: 12px;
    text-transform: none;
    padding: 5px;}
  #loginform {float: left;
    margin-right: 20px;
    margin-left: 20px;
}
</style>
				</div><!-- .header-image -->
			<?php endif; // End header image check. ?>
			<?php if ( has_nav_menu( 'primary' ) ) : ?>
							<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'twentysixteen' ); ?>">
								<?php
									wp_nav_menu( array(
										'theme_location' => 'primary',
										'menu_class'     => 'primary-menu',
									 ) );
								?>
                <div style="background:url(http://www.venturelistings.com/assets/img/site/search_bg.gif) repeat-x;    width: 260px;
    height: 40px;
    padding-top: 5px;
    float: right;
    top: -45px;
    position: relative;">
      <input style="    height: 30px;width: 210px;border: 1px solid #ededed;margin-left: 5px;" type="text" placeholder="Search">
      <img src="http://www.venturelistings.com/assets/img/site/btn_search.png" style="vertical-align: middle;margin-left:5px"></div>
							</nav><!-- .main-navigation -->
      
      <br/>
						<?php endif; ?>
      <?php if ( function_exists( "easingslider" ) ) { easingslider( 26 ); } ?>


		</header><!-- .site-header -->
</div>
    </div>
  <script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('.tabs .tab-links a').on('click', function(e)  {
        var currentAttrValue = jQuery(this).attr('href');
 
        // Show/Hide Tabs
        jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
 
        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
 
        e.preventDefault();
    });
});
</script>
  <div class="clear" style="height:20px"></div>
  <div class="site-inner">
		<div id="content" class="site-content">
