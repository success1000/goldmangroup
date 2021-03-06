<?php
/*
Plugin Name: Nice Login Widget
Plugin URI: http://www.superplug.in
Description: Add, build and manage login-register widget
Version: 1.3.10
Author: SuperPlugin Team
Author URI: http://superplug.in/team/
*/

add_action('init',  array('SP_Nice_Login_Widget', 'init'), 1);
//add_action('widgets_init', create_function('', 'register_widget( "Pw_Login_Widget" );'));
add_action('widgets_init', array('SP_Nice_Login_Widget', 'widgets_init'));
register_activation_hook(__FILE__, array('SP_Nice_Login_Widget', 'activate') );

class SP_Nice_Login_Widget
{
	
	
	//consts
	
	const PLUGIN_VERSION =	'1.3.10';
	const ADMIN_STYLE_VERSION = "1.3.10";
	const PLUGIN_SCRIPT_VERSION = "1.3.10";
	
	public static function widgets_init(){
		
		register_widget( "Pw_Login_Widget" );

		$args = array(
				'name'          => 'Nice Login Widget Shortcode',
				'id'            => 'sp_login_shortcode',
				'description'   => __( "This sidebar does not act as a normal sidebar. It is a stand-in used to make the shortcode for Nice Login Widget available. Just drag the Nice Login Widget into the sidebar, then you can use the [sp_login_shortcode] shortcode in any page or post.", 'pwLogWi' ),
				'class'         => 'sp-shortcode-sidebar',
				'before_widget' => '<div id="%1$s" class="widget %2$s" style="display: inline-block">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>'
				);
		
		$sidebar_id = register_sidebar($args);
		
	}
	
	
	public static function init(){
		
		wp_register_style('pwLogWi_style', plugins_url('css/pw-login-widget.css' , __FILE__), null, self::ADMIN_STYLE_VERSION);
		wp_register_script( 'pwLogWi_script', plugins_url('js/pw-login-widget.js', __FILE__), array("jquery"), self::PLUGIN_SCRIPT_VERSION, true);
		
		wp_register_script( 'pwLogWi_ajax_authentication', plugins_url('js/ajax-authentication.js', __FILE__), array("jquery"), self::PLUGIN_SCRIPT_VERSION, true);
		
		
		load_plugin_textdomain("pwLogWi", false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		
		add_shortcode( 'sp_login_shortcode', array( 'SP_Nice_Login_Widget', 'sp_login_shortcode' ) );
		
		if (is_admin()){
			
			if ( !defined('DOING_AJAX') || !DOING_AJAX )
				self::check_redirect_to_nlwteaser();
			
			add_action( 'admin_menu', array( 'SP_Nice_Login_Widget', 'admin_menus') );
			
			add_action('admin_enqueue_scripts', array('SP_Nice_Login_Widget', 'admin_enqueue_scripts') , 10 , 1);
			
			add_action('wp_ajax_nopriv_login', array('SP_Nice_Login_Widget', 'ajax_authenticate_users'));
			add_action('wp_ajax_login', array('SP_Nice_Login_Widget', 'ajax_authenticate_users'));
			add_action('wp_ajax_nopriv_register', array('SP_Nice_Login_Widget', 'ajax_authenticate_users'));
			add_action('wp_ajax_nopriv_lostpassword', array('SP_Nice_Login_Widget', 'ajax_authenticate_users'));
			
		}else{
			
			
			add_action( 'wp_enqueue_scripts', array('SP_Nice_Login_Widget', 'enqueue_scripts' ));
			
		}
		
		
	}
	
	public static function check_redirect_to_nlwteaser(){

		//If network do it only in network admin pages
		if ( is_multisite() && !is_network_admin() )		return;
		
		if ( get_transient('nlw_teaser_page_redirect') || get_option('nlw_version')!=self::PLUGIN_VERSION ){
			if( get_option('nlw_version') != self::PLUGIN_VERSION ){
				set_transient( 'nlw_teaser_page_redirect', 1, 60*60);
				update_option('nlw_version', self::PLUGIN_VERSION);
			}
			$location = admin_url( 'index.php?page=nice-login-register-widget/nlw-about.php' ) ;
			wp_safe_redirect($location);
		}
	}
	
	public static function admin_menus(){

		// About
		$dashboard_page_title = __('Upgrade To Login Widegt Pro', 'pwLogWi') ;
		$about = add_submenu_page( null , $dashboard_page_title, null, 'manage_options', 'nice-login-register-widget/nlw-about.php');
	}
	
	public static function activate(){
		
		if ( is_multisite() && !is_network_admin() )		return;
		
		//LWP teaser page
		set_transient( 'nlw_teaser_page_redirect', 1, 60*60);
		
	}
	
	public static function sp_login_shortcode(){
		ob_start();
		?><div class="nlw-shortcode-wrapper"><?php
		dynamic_sidebar('sp_login_shortcode');
		?></div><!-- .nlw-shortcode-wrapper --><?php
		return ob_get_clean();
	}
	
	public static function ajax_authenticate_users(){
		
		
		
		check_ajax_referer('sp-security-nonce', 'security');
		
		if (isset($_POST['action'])){
			require_once 'ajax-authenticate-users.php';
			$response = Ajax_Auth_users::authenticate_users($_POST['action']);
			echo json_encode($response);
		}
		die();
	}

	
	public static function admin_enqueue_scripts($hook){
		if ($hook=='widgets.php' || strstr($hook, 'sp_nice_login_widget')){
			wp_enqueue_style('pwLogWi_style' );
			wp_enqueue_script( 'pwLogWi_script' );
		}
	}
	
	
	public static function enqueue_scripts(){
		wp_enqueue_style('pwLogWi_style' );
		wp_enqueue_script( 'pwLogWi_script' );

		wp_enqueue_script( 'pwLogWi_ajax_authentication' );
		
		wp_localize_script('pwLogWi_script', 'ajax_object', array('ajax_url' => admin_url( 'admin-ajax.php' )));
		
		$pwLogWi_messages = array(
			'ajax_request_fails' => __( 'Ajax request fails', 'pwLogWi'),
			'ajax_unknown_error' => __( 'An unknown error occurred while trying to connect to the server.<br>Please refresh the page and try again.', 'pwLogWi')
		);
		wp_localize_script( 'pwLogWi_script', 'pwLogWi_messages', $pwLogWi_messages );
	
	}
	
	
	
}



class Pw_Login_Widget extends WP_Widget
{
	
	
	/**
	 * The class constructor
	 *
	 * This setup the class and generate
	 *
	 *
	 */
	public function __construct() {
	
		$widget_options = array();
		$control_options = array();
		parent::__construct(
				'pw_login_widget',
				'Nice Login Widget',
				array('description' => __('Add, build and manage login-register widget', 'pwLogWi'))
		);
	
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 *
	 */
	public function form( $instance ) {
	
		
		if ( !empty( $instance[ 'include_remember_me' ] ) ) {
			$checked = "checked";
		}
		if (!empty( $instance[ 'ajax_authentication' ] )){
			$ajax_auth = "checked";
		}
		if ( isset( $instance[ 'logged_in_text' ] ) ) {
			$logged_in_text = $instance[ 'logged_in_text' ];
		}
		
		if ( !empty( $instance[ 'default_form' ] )){
			if ($instance[ 'default_form' ]=='login_form'){
				$login_form = "selected";
			}else if ($instance[ 'default_form' ]=='register_form'){
				$register_form = "selected";
			}
		}
		
		if ( isset( $instance[ 'float' ] ) && $instance[ 'float' ]=='horizontal'){
			$horizontal = "selected";
		}else{
			$vertical = "selected";
		}
		
		if (isset($instance['css_class'])){
			$css_class = $instance['css_class'];
		}else{
			$css_class = "";
		}
		add_thickbox();
		?>
			<h3><?php _e('Widget Options', 'pwLogWi')?></h3>
			<p>  
    		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php _e('Title:', 'pwLogWi'); ?></strong></label>  
    		<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>
			<p><input type="checkbox" id="<?php echo $this->get_field_id('title_only_loggedout')?>" name="<?php echo $this->get_field_name('title_only_loggedout')?>" <?php checked('yes', $instance['title_only_loggedout'])?> />
			<label for="<?php echo $this->get_field_id('title_only_loggedout')?>"><?php _e('Show title only in logged-out mode', 'pwLogWi') ?></label></p>
			<p><label for="<?php echo $this->get_field_id("css_class"); ?>"><strong><?php _e('CSS class name: ', 'pwLogWi') ?></strong></label>
			<input type="text" id="<?php echo $this->get_field_id("css_class"); ?>" name="<?php echo $this->get_field_name("css_class"); ?>" value="<?php echo $css_class; ?>" >
			</p>
			
			<div class="nlw-widget-back-end-div">
				<h3 class="nlw-widget-options-nav-tabs nav-tab-wrapper">
					<a href="#logged-out-content-<?php echo $this->number ?>" class="nav-tab nav-tab-active"><?php _e('Logged Out', 'pwLogWi') ?></a>
					<a href="#logged-in-content-<?php echo $this->number ?>" class="nav-tab"><?php _e('Logged In', 'pwLogWi') ?></a>
				</h3>
				<div id="logged-out-content-<?php echo $this->number ?>" class="nav-tab-linked active">
					<ul>
						<li>
						<label for="<?php echo $this->get_field_id('default_form'); ?>" ><strong><?php _e('Default Form: ', 'pwLogWi') ?></strong></label>
						<select id="<?php echo $this->get_field_id("default_form"); ?>" name="<?php echo $this->get_field_name("default_form"); ?>" >
						<option value="login_form" <?php echo $login_form; ?>><?php _e('Login Form', 'pwLogWi') ?></option>
						<option value="register_form" <?php echo $register_form; ?>><?php _e('Register Form', 'pwLogWi') ?></option>
						</select>
						</li>
						<li>
						<label for="<?php echo $this->get_field_id('float'); ?>" ><strong><?php _e('Float: ', 'pwLogWi') ?></strong></label>
						<select id="<?php echo $this->get_field_id("float"); ?>" name="<?php echo $this->get_field_name("float"); ?>" >
						<option value="horizontal" <?php echo $horizontal; ?>><?php _e('Horizontal', 'pwLogWi') ?></option>
						<option value="vertical" <?php echo $vertical; ?>><?php _e('Vertical', 'pwLogWi') ?></option>
						</select>
						</li>
						<li><input type="checkbox" id="<?php echo $this->get_field_id( 'include_remember_me' ); ?>" title="Include Remember-me"  name="<?php echo $this->get_field_name( 'include_remember_me' ); ?>" <?php echo $checked; ?> />
						<label for="<?php echo $this->get_field_id( 'include_remember_me' ); ?>" >	<strong><?php _e('Include "Remember-Me"', 'pwLogWi') ?></strong></label>
							<p style="margin-left: 10px; <?php if (empty($checked)) echo 'display:none;"';?>" >
							<label><input type="radio" name="<?php echo $this->get_field_name("remember_me_def"); ?>" value="uncheck_by_default" <?php if ($instance['remember_me_def']=='uncheck_by_default') echo "checked='checked'"; ?>><?php _e('Uncheck by default ', 'pwLogWi') ?></label> <br>
							<label><input type="radio" name="<?php echo $this->get_field_name("remember_me_def"); ?>" value="check_by_default" <?php if ($instance['remember_me_def']=='check_by_default') echo "checked='checked'";?>><?php _e('Check by default ', 'pwLogWi') ?></label> 
							</p> 
						</li>
						
						<li>
						<label><input type="radio" name="<?php echo $this->get_field_name( 'ajax_authentication' ); ?>" value="1" <?php if (!empty($ajax_auth)) echo "checked='checked'";?>><strong><?php _e('Ajax Authentication', 'pwLogWi') ?></strong></label><br>
						<label><input type="radio" name="<?php echo $this->get_field_name( 'ajax_authentication' ); ?>" value="0" <?php if (empty($ajax_auth)) echo "checked='checked'";?>><strong><?php _e('Regular WP Authentication', 'pwLogWi') ?></strong></label>
						</li>
					</ul>
				</div>
				<div id="logged-in-content-<?php echo $this->number ?>" class="nav-tab-linked">
					<strong><?php _e('Add Logged-In message', 'pwLogWi') ?></strong><br>
					<select class="merge-tags-select"><?php self::print_merge_tags_options(); ?> </select>
					<textarea rows="" cols="" id="<?php echo $this->get_field_id("logged_in_text"); ?>" name="<?php echo $this->get_field_name("logged_in_text"); ?>" style="width: 90%;height: 100px;"><?php echo $logged_in_text; ?></textarea>
				</div>
			</div>
			
			<div class="lwp-banner" style="text-align: center;border: 1px #DFDFDF solid;border-radius: 4px;padding: 4px;margin: 4px 0 15px;">
			<a href="http://superplug.in/login-widget-pro/?utm_source=nice_login_widget__inSidebars_links&utm_medium=banner&utm_campaign=Nice+Login+Widget" target="_blank">
			<img src="<?php echo plugins_url("images/Banner.jpg", __FILE__) ?>" title="Login Widget Pro" style="width: 100%;max-width: 226px;height: auto;"></a>
			</div>
			<?php 
			wp_nonce_field(plugin_basename( __FILE__ ), 'pwLogWi_noncename');
			
		}
		
		static function print_merge_tags_options(){
			
			echo "<option value=''>" . __('Insert Merge Tag', 'pwLogWi') . "</option>";
			echo "<option value='display_name'>" . __('User display name', 'pwLogWi') . "</option>";
			echo "<option value='user_nicename'>" . __('User nice name', 'pwLogWi') . "</option>";
			echo "<option value='user_login'>" . __('User login', 'pwLogWi') . "</option>";
			echo "<option value='user_email'>" . __('User email', 'pwLogWi') . "</option>";
			echo "<option value='logout_link'>" . __('Log-out link', 'pwLogWi') . "</option>";
			echo "<option value='profile_link'>" . __('Profile link', 'pwLogWi') . "</option>";
			
		}
		
		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {

		
			if (wp_verify_nonce($_POST['pwLogWi_noncename'], plugin_basename( __FILE__ ))){
				
				$instance = array();
				$instance['title'] = strip_tags( $new_instance['title'] );
				$instance['title_only_loggedout'] = empty($new_instance['title_only_loggedout']) ? 'no' : 'yes' ;
				$instance['css_class'] = strip_tags( $new_instance['css_class'] );
				$instance['include_remember_me'] = strip_tags( $new_instance['include_remember_me'] );
				$instance['default_form'] = strip_tags($new_instance['default_form']);
				$instance['float'] = strip_tags($new_instance['float']);
				$instance['logged_in_text'] = $new_instance['logged_in_text'];
				$instance['remember_me_def'] = $new_instance['remember_me_def'];
				$instance['ajax_authentication'] = $new_instance['ajax_authentication'];
			
				return $instance;
			}
			
			return $old_instance;
		
		}
		
		static function interapt_merge_tags($input_text, $redirect_url){
			
			$return_text = $input_text;
			$user = wp_get_current_user();
			$user_data = get_object_vars($user->data);
			preg_match_all("/\{([^\}]+)\}/", $input_text, $matches);
			foreach ($matches[1] as $match){
				switch ($match){

					case "display_name":
						$replace = empty($user_data["display_name"]) ? $user_data["user_login"] : $user_data["display_name"];
						$return_text = str_replace("{".$match."}", $replace, $return_text);
						break;
					case "user_nicename":
						$replace = empty($user_data["user_nicename"]) ? $user_data["user_login"] : $user_data["user_nicename"];
						$return_text = str_replace("{".$match."}", $replace, $return_text);
						break;
					case "user_login":
						$return_text = str_replace("{".$match."}", $user_data["user_login"], $return_text);
						break;
					case "user_email":
						$return_text = str_replace("{".$match."}", $user_data["user_email"], $return_text);
						break;
					case "logout_link":
						$return_text = str_replace("{".$match."}", "<a href='".wp_logout_url($redirect_url)."'>". __('Log-Out', 'pwLogWi') ."</a>", $return_text);
						break;
					case "profile_link":
						$return_text = str_replace("{".$match."}", "<a href='".admin_url("profile.php")."'>". __('Profile', 'pwLogWi') ."</a>", $return_text);
						break;
					
					
				}
				
			}
			return $return_text;
		}
		
		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 *
		 */
		public function widget( $args, $instance ) {
		
			extract( $args );
			
			$defaults = array(
				'css_class'		=> '',
				'title_only_loggedout'	=> 'no',
				'title'					=> false,
				'include_remember_me'	=> '',
				'default_form'			=> 'login_form',
				'float'					=> 'vertical',
				'logged_in_text'		=> __("Welcome Back ", "pwLogWi") . "{user_login}. {logout_link}",
				'remember_me_def'		=> 'check_by_default',
				'border'				=> ''
			);
			$instance = wp_parse_args($instance, $defaults);

			$before_widget = preg_replace('/class="/', 'class="'.$instance['css_class'].' ', $before_widget, 1);
			
			echo $before_widget;
			
			if ( !is_user_logged_in() || $instance['title_only_loggedout']!='yes' ){
				if ($instance['title']){
					echo $before_title . $instance['title'] . $after_title;
				}	
			}
			
			$include_remember_me = !empty($instance['include_remember_me']);
			
			if ($instance['default_form']=='register_form' ){
				$hide_login_div = "style='display: none'";
			}else{
				$hide_register_div = "style='display: none'";
			}
			if ($instance['float']=='horizontal'){
	
				$main_div_class="sp-main-div-horizontal";
				
			}else{
				
				$main_div_class="sp-main-div-vertical";
				
			}
			
			if (is_user_logged_in()){
				
				$user = wp_get_current_user();
				
				$logged_in_text = self::interapt_merge_tags($instance['logged_in_text'], $_SERVER['REQUEST_URI']);
				
				echo $logged_in_text;
				
			}else{
					$is_user_can_register = $this->check_user_can_register();
					$ajax_nonce = wp_create_nonce("sp-security-nonce");
					//wp_clear_auth_cookie();
					?>
					<div id="<?php echo "sp-main-div-".$this->id; ?>" class="sp-main-div <?php echo $main_div_class?>" >
					<div class="sp-login-header">
					<?php if (force_ssl_login()) : 
						if ( 0 === strpos($_SERVER['REQUEST_URI'], 'http') ) {
							$redirect =  set_url_scheme( $_SERVER['REQUEST_URI'], 'https' ) ;
						} else {
							$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ;
						}
						?>
						<div class="sp-ssl-requires-msg sp-error" style="display:none"><?php _e(sprintf("Login to this site requires ssl communication.<br>Click <a href='%s'>here</a> to reload the page over ssl.", $redirect), "pwLogWi")?></div>
					<?php endif;?>
					</div>
					<div class='sp-widget-login-div' <?php echo $hide_login_div; ?>>
					<form method="post" action="<?php echo wp_login_url() ?>" class="wp-user-form">
					<p><label for='user_login-<?php echo $this->number;?>'><?php _e('Username: ', 'pwLogWi') ?></label>
					<input id='user_login-<?php echo $this->number;?>' type='text' name='log' required='required' /></p>
					<p><label for='user_pass-<?php echo $this->number;?>'><?php _e('Password: ', 'pwLogWi') ?></label>
					<input id='user_pass-<?php echo $this->number;?>' type='password' name='pwd' required='required' /></p>
					<?php if ($include_remember_me){?>
					<p><input id='rememberme-<?php echo $this->number; ?>' type='checkbox' name='rememberme' value='forever' <?php checked($instance['remember_me_def'], 'check_by_default'); ?> />
					<label for='rememberme-<?php echo $this->number; ?>' ><?php _e(' Remember me', 'pwLogWi') ?></label></p>
					<?php }?>
					<?php do_action('login_form'); ?>
					<p><input type="submit" name="user-submit" value="<?php _e('Login', 'pwLogWi')?>" /></p>
					<p>
					<input type="hidden" name="action" value="login">
					<input type="hidden" name="wp-submit" value="yes">
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
					<input type="hidden" name="testcookie" value="1" />
					<input type="hidden" class="force_ssl_login" value="<?php echo json_encode(force_ssl_login()); ?>"/>
					<input type="hidden" name="security" value="<?php echo $ajax_nonce?>"/>
					</p>
					</form>
					<ul>
					<?php if ($is_user_can_register) :?>
						<li><a class="sp-flipping-link" href='registration-user-profile'><?php _e('Don\'t have an account?', 'pwLogWi') ?></a></li>
					<?php  endif; ?>
					<li><a class="sp-flipping-link" href='#lost-pass' ><?php _e('Lost your password?', 'pwLogWi') ?></a></li>
					</ul>
					
					</div>
					
					<?php if ($is_user_can_register){?>
					<div class='sp-widget-register-div' <?php echo $hide_register_div; ?>>
				
					<form method="post" action="<?php echo add_query_arg( 'action' , 'register', wp_login_url() )  ?>" class="wp-user-form">
					<p><label for='reg_user_login-<?php echo $this->number;?>'><?php _e('Choose username: ', 'pwLogWi') ?></label>
					<input id='reg_user_login-<?php echo $this->number;?>' type='text' name='user_login' required='required' /></p>
					<p><label for="user_email-<?php echo $this->number;?>" ><?php _e('Your Email: ', 'pwLogWi') ?></label>
					<input id="user_email-<?php echo $this->number;?>" type="email" name="user_email" required="required" /></p>
					<?php do_action('register_form'); ?>
					<p><input type="submit" name="user-submit" value="Sign up!" /></p>
					<p>
					<input type="hidden" name="action" value="register">
					<input type="hidden" name="wp-submit" value="yes">
					<input type="hidden" name="redirect_to" value="<?php echo empty($_GET) ? $_SERVER['REQUEST_URI']."?register=true" : $_SERVER['REQUEST_URI']."&register=true" ; ?>" />
					<input type="hidden" name="testcookie" value="1" />
					<input type="hidden" name="security" value="<?php echo $ajax_nonce?>"/>
					</p>
					</form>
					<ul><li><a class="sp-flipping-link" href='#sp-login'><?php _e('Have an account?', 'pwLogWi') ?></a></li></ul>
					</div>
					<?php }?>
					
					<div class='sp-widget-lost_pass-div' style='display:none;'>
			
					<form method="post" action='<?php echo add_query_arg( 'action' , 'lostpassword', wp_login_url() ) ?>'>
					<p><label for='lost_user_login-<?php echo $this->number;?>'><?php _e('Enter your username or email: ', 'pwLogWi') ?></label>
					<input type="text" name="user_login" value="" size="20" id="lost_user_login-<?php echo $this->number;?>" /></p>
					<?php do_action('login_form', 'resetpass')?>
					<p><input type="submit" name="user-submit" value="<?php _e('Reset my password', 'pwLogWi') ?>"  /></p>
					<p>
					<input type="hidden" name="action" value="lostpassword">
					<input type="hidden" name="wp-submit" value="yes">
					<input type="hidden" name="redirect_to" value="<?php echo empty($_GET)? $_SERVER['REQUEST_URI']."?reset=true" : $_SERVER['REQUEST_URI']."&reset=true"; ?>" />
					<input type="hidden" name="testcookie" value="1" />
					<input type="hidden" name="security" value="<?php echo $ajax_nonce?>"/>
					<p>
					</form>
					<ul><li><a class="sp-flipping-link" href='#sp-login'><?php _e('Back to login', 'pwLogWi') ?></a></li></ul>
					</div>
					
					<input type="hidden"  class="is_ajax_authentication" value="<?php echo !empty($instance['ajax_authentication']) ? "1" : "0" ; ?>">
					
					<?php $reset = $_GET['reset']; if($reset == true) { echo '<p>' .  __('A message was sent to your email address', 'pwLogWi') . '</p>'; } ?>
					<div><?php $register = $_GET['register']; if($register == true) { echo '<p>' . __('Check your email for the password!', 'pwLogWi') . '</p>'; } ?></div>
					<div class="sp-loading-img" style="display:none; position: absolute;top: 50%;left: 50%;margin-left: -24px;margin-top: -24px;"><img src="<?php echo plugins_url("images/loading_transparent.gif", __FILE__)?>"  title="Loading" alt="Loading"></div>
					</div>
					<?php 
			}// end if user logged out state
				
				echo $after_widget;
			}
			
			function check_user_can_register(){
				$register_url = wp_register('', '', false);
				return !empty($register_url);
			}
	
}


 


?>