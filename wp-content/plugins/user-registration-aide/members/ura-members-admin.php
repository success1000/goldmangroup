<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

if( !function_exists( 'wp_get_current_user' ) ) {
    include( ABSPATH . "wp-includes/pluggable.php" ); 
}

if ( !class_exists( 'URA_MEMBERS_ADMIN' ) ) {
 
 /**
 * Class URA_MEMBERS_ADMIN
 * Load Members admin area.
 * @category Class
 * @since 1.5.2.0
 * @updated 1.5.2.0
 * @access public
 * @author Brian Novotny
 * @website http://creative-software-design-solutions.com
*/

class URA_MEMBERS_ADMIN
{

	/** Directory *************************************************************/

	/**
	 * Path to the BP Members Admin directory.
	 *
	 * @var string $admin_dir
	 */
	public $admin_dir = '';

	/** URLs ******************************************************************/

	/**
	 * URL to the BP Members Admin directory.
	 *
	 * @var string $admin_url
	 */
	public $admin_url = '';

	/**
	 * URL to the BP Members Admin CSS directory.
	 *
	 * @var string $css_url
	 */
	public $css_url = '';

	/**
	 * URL to the BP Members Admin JS directory.
	 *
	 * @var string
	 */
	public $js_url = '';

	/** Other *****************************************************************/

	/**
	 * Screen id for edit user's profile page.
	 *
	 * @access public
	 * @var string
	 */
	public $user_page = '';
	
	public $capability = '';
	
	public $users_screen = '';
	
	public $do_action = '';
	/**
	 * Constructor method.
	 *
	 * @access public
	 * @since BuddyPress (2.0.0)
	 */
	public function __construct() {
		//$this->setup_globals();
		//$this->setup_actions();
	}

	/**
	 * Set admin-related globals.
	 *
	 * @access private
	 * @since BuddyPress (2.0.0)
	 */
	public function setup_globals() {
		global $current_user;
		
		// Capability depends on config
		$this->capability = 'edit_users';

		// The Edit Profile Screen id
		$this->user_page = '';

		// The Show Profile Screen id
		$this->user_profile = is_network_admin() ? 'users' : 'profile';

		// The current user id
		$this->current_user_id = get_current_user_id();

		// The user id being edited
		$this->user_id = 0;

		// Is a member editing their own profile
		$this->is_self_profile = false;

		// The screen ids to load specific css for
		$this->screen_id = array();

		// The stats metabox default position
		$this->stats_metabox = new StdClass();

		// Data specific to signups
		$this->users_page   = '';
		$this->pending_approval = 'pending-approval';
		$this->pending_deletion = 'pending-deletion';
		$this->pending_verification = 'pending-verification';
		$this->users_url    = get_admin_url( 'users.php' );
		
	}

	/**
	 * Set admin-related actions and filters.
	 *
	 * @access private
	 * @since BuddyPress (2.0.0)
	 */
	public function setup_actions() {
		global $current_user;
		$current_user = wp_get_current_user();
		//add_filter( 'set_screen_option', array( &$this, 'filter_test' ), 10, 3 );
		//add_settings_field( 'test', 'Test', 'testing', 'pending-approval', 'default', $args = array() );
		add_action( 'admin_menu',               array( $this, 'admin_menus'       ), 5     );
		
		// Process changes to member type.
		//add_action( 'bp_members_admin_load', array( $this, 'process_member_type_update' ) );

		/** Signups ***********************************************************/

		if ( current_user_can( 'manage_options' ) ){

			// Filter non multisite user query to remove sign-up users
			if ( ! is_multisite() ) {
				add_action( 'pre_user_query', array( $this, 'remove_ura_signups_from_user_query' ), 10, 1 );
			}

			// Reorganise the views navigation in users.php and signups page
			//if ( current_user_can( $this->capability ) ) {
				add_filter( "views_{$this->users_screen}", array( $this, 'signup_filter_view'    ), 10, 1 );
				add_filter( 'set-screen-option',           array( $this, 'signup_screen_options' ), 10, 3 );
			//}
		}
		
		if ( ! is_multisite() ) {
			//add_action( 'pre_user_query', array( $this, 'remove_count_from_user_query' ), 10, 1 );
		}
	}
	
	/**
	 * Get the user ID
	 *
	 * Look for $_GET['user_id']. If anything else, force the user ID to the
	 * current user's ID so they aren't left without a user to edit.
	 *
	 * @since BuddyPress (2.1.0)
	 *
	 * @return int
	 */
	private function get_user_id() {
		$user_id = get_current_user_id();

		// We'll need a user ID when not on the user admin
		if ( ! empty( $_GET['user_id'] ) ) {
			$user_id = $_GET['user_id'];
		}

		return intval( $user_id );
	}

	/** 
	 * function admin_menus
	 * Create the All Users / Profile > Edit Profile and All Users Signups submenus.
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @uses add_submenu_page() To add the Edit Profile page in Users/Profile section.
	 * @params
	 * @returns $message (registration form top message)
	*/
	
	public function admin_menus() {
		/*
		// Setup the hooks array
		$hooks = array();

		// Only show sign-ups where they belong
		if ( ! is_multisite() || is_network_admin() ) {

			// Manage signups
			
			$hooks['users'] = $this->pending_approval = add_users_page(
				__( 'Pending Approval',  'csds_userRegAide' ),
				__( 'Pending Approval',  'csds_userRegAide' ),
				$this->capability,
				'pending-approval',
				'new_user_pending_approval_wp_list_view'
				//array( $this, 'signups_admin_index' )
			);
			
			// Manage signups
			$hooks['users'] = $this->pending_deletion = add_users_page(
				__( 'Pending Deletion',  'csds_userRegAide' ),
				__( 'Pending Deletion',  'csds_userRegAide' ),
				$this->capability,
				'pending-deletion',
				'new_user_pending_approval_wp_list_view'
				//array( $this, 'signups_admin_index' )
			);
			
			// Manage signups
			$hooks['users'] = $this->pending_verification = add_users_page(
				__( 'Pending Verification',  'csds_userRegAide' ),
				__( 'Pending Verification',  'csds_userRegAide' ),
				$this->capability,
				'pending-verification',
				'new_user_pending_approval_wp_list_view'
				//array( $this, 'signups_admin_index' )
			);
			
		}
		*/
		$edit_page         = 'user-edit';
		$profile_page      = 'profile';
		$this->users_page  = 'users';

		// Self profile check is needed for this pages
		$page_head = array(
			$edit_page        . '.php',
			$profile_page     . '.php',
			$this->user_page,
			$this->users_page . '.php',
		);

		// Setup the screen ID's
		$this->screen_id = array(
			$edit_page,
			$this->user_page,
			$profile_page
		);
		/*
		// Loop through new hooks and add method actions
		foreach ( $hooks as $key => $hook ) {
			add_action( "load-{$hook}", array( $this, $key . '_admin_load' ) );
		}

		// Add the profile_admin_head method to proper admin_head actions
		foreach ( $page_head as $head ) {
			//add_action( "admin_head-{$head}", array( $this, 'profile_admin_head' ) );
		}
		*/
	}
	
	/** Signups Management ****************************************************/

	/** 
	 * function signup_screen_options
	 * Display the admin preferences about signups pagination.
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @uses add_submenu_page() To add the Edit Profile page in Users/Profile section.
	 * @params int $value, string $option, int $new_value
	 * @returns int the pagination preferences
	*/
	
	public function signup_screen_options( $value = 0, $option = '', $new_value = 0 ) {
		if ( 'users_page_ura_signups_network_per_page' != $option && 'lp_tableview_records_per_page' != $option ) {
			return $value;
		}

		// Per page
		$new_value = (int) $new_value;
		if ( $new_value < 1 || $new_value > 999 ) {
			return $value;
		}

		return $new_value;
	}

	/** 
	 * function remove_ura_signups_from_user_query
	 * Make sure no signups will show in users list.
	 * This is needed to handle signups that may have not been activated
	 * before the 1.5.2.0 upgrade.
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params WP_User_Query $query The users query.
	 * @returns WP_User_Query The users query without the signups.
	*/
	
	public function remove_ura_signups_from_user_query( $query = null ) {
		global $wpdb;

		// Bail if this is an ajax request
		if ( defined( 'DOING_AJAX' ) ) {
			return;
		}


		// Bail if there is no current admin screen
		if ( ! function_exists( 'get_current_screen' ) || ! get_current_screen() ) {
			return;
		}

		// Get current screen
		$current_screen = get_current_screen();
		
		//exit( print_r( $current_screen ) );
		// Bail if not on a users page
		if ( ! isset( $current_screen->id ) || $this->users_page !== $current_screen->id ) {
			return;
		}

		// Bail if already querying by an existing role
		if ( ! empty( $query->query_vars['role'] ) ) {
			if( $query->query_vars['role'] != 'subscriber' ){
				//return;
			}
		}
		
		$query->query_where .= " AND {$wpdb->users}.user_status != 2";
		
	}

	/** 
	 * function signup_filter_view
	 * Filter the WP Users List Table views to include 'bp-signups'.
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params array $views WP List Table views, 
	 * @returns array The views with the signup view added.
	*/
	
	public function signup_filter_view( $views = array() ) {
		global $screen;
		$screen = get_current_screen();
		//exit( print_r( $screen ) );
		$userspage = 'users_page_';
		// Remove the 'current' class from All if we're on the signups view
		if ( $this->signups_page == get_current_screen()->id ) {
			$views['all'] = str_replace( 'class="current"', '', $views['all'] );
			$class = ' class="current"';
		} else {
			$class        = '';
		}
		$options = get_option('csds_userRegAide_Options');
		$verify = $options['verify_email'];
		$nuac = new NEW_USER_APPROVE_CONTROLLER();
		$count = (int) $nuac->un_count();
		/*$url     = add_query_arg( 'page', 'pending-approval', get_admin_url( 'users.php' ) );
		$text    = sprintf( _x( 'Pending Approval', 'pending-approval', 'buddypress' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' );
		if( $screen->id == $userspage.'pending-approval' ){
		$views['registered'] = sprintf( '<a href="%1$s" class="%2$s">%3$s</a>', esc_url( $url ), $class, $text );
		*/
		if( isset( $_GET['role'] ) ){
			$page_role = $_GET['role'];
			$rcount = (int) $nuac->role_count_2( 'subscriber' );
			$views['subscriber'] = "<a href='users.php?role=subscriber'$class>". __( 'Subscriber', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
			$count = $nuac->un_count('approve');
			$views['pending-approval'] = "<a href='users.php?page=pending-approval'>". __( 'Pending Approval', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			$count = (int) $nuac->un_count( 'denied' );
			$views['pending-deletion'] = "<a href='users.php?page=pending-deletion'>". __( 'Pending Deletion', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			if( $verify == 1 ){
				$count = (int) $nuac->un_count( 'unverified' );
				$views['pending-verification'] = "<a href='users.php?page=pending-verification'>". __( 'Pending Verification', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			}
		}
		if( $screen->id == $userspage.'pending-approval' ){
			$rcount = (int) $nuac->role_count_2( 'subscriber' );
			$views['subscriber'] = "<a href='users.php?role=subscriber'>". __( 'Subscriber', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
			$count = $nuac->un_count('approve');
			$views['pending-approval'] = "<a href='users.php?page=pending-approval'$class>". __( 'Pending Approval', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			$count = (int) $nuac->un_count( 'denied' );
			$views['pending-deletion'] = "<a href='users.php?page=pending-deletion'>". __( 'Pending Deletion', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			if( $verify == 1 ){
				$count = (int) $nuac->un_count( 'unverified' );
				$views['pending-verification'] = "<a href='users.php?page=pending-verification'>". __( 'Pending Verification', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			}
		}elseif( $screen->id == $userspage.'pending-deletion' ){
			$rcount = (int) $nuac->role_count_2( 'subscriber' );
			$views['subscriber'] = "<a href='users.php?role=subscriber'$class>". __( 'Subscriber', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
			$count = $nuac->un_count('approve');
			$views['pending-approval'] = "<a href='users.php?page=pending-approval'>". __( 'Pending Approval', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			$count = (int) $nuac->un_count( 'denied' );
			$views['pending-deletion'] = "<a href='users.php?page=pending-deletion'$class>". __( 'Pending Deletion', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			if( $verify == 1 ){
				$count = (int) $nuac->un_count( 'unverified' );
				$views['pending-verification'] = "<a href='users.php?page=pending-verification'>". __( 'Pending Verification', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			}
		}elseif( $screen->id == $userspage.'pending-verification' ){
			$rcount = (int) $nuac->role_count_2( 'subscriber' );
			$views['subscriber'] = "<a href='users.php?role=subscriber'$class>". __( 'Subscriber', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
			$count = $nuac->un_count('approve');
			$views['pending-approval'] = "<a href='users.php?page=pending-approval'>". __( 'Pending Approval', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			$count = (int) $nuac->un_count( 'denied' );
			$views['pending-deletion'] = "<a href='users.php?page=pending-deletion'>". __( 'Pending Deletion', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			if( $verify == 1 ){
				$count = (int) $nuac->un_count( 'unverified' );
				$views['pending-verification'] = "<a href='users.php?page=pending-verification'$class>". __( 'Pending Verification', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			}
		}else{
			$rcount = (int) $nuac->role_count_2( 'subscriber' );
			$views['subscriber'] = "<a href='users.php?role=subscriber'$class>". __( 'Subscriber', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
			$count = $nuac->un_count('approve');
			$views['pending-approval'] = "<a href='users.php?page=pending-approval'>". __( 'Pending Approval', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			$count = (int) $nuac->un_count( 'denied' );
			$views['pending-deletion'] = "<a href='users.php?page=pending-deletion'>". __( 'Pending Deletion', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			if( $verify == 1 ){
				$count = (int) $nuac->un_count( 'unverified' );
				$views['pending-verification'] = "<a href='users.php?page=pending-verification'>". __( 'Pending Verification', 'csds_userRegAide' ).'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			}
		}
		return $views;
	}

	/** 
	 * function get_list_table_class
	 * Load the Signup WP Users List table.
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @param  string $class    The name of the class to use.
	 * @param  string $required The parent class.
	 * @return WP_List_Table    The List table.
	*/
	
	public static function get_list_table_class( $class = '', $required = '' ) {
		if ( empty( $class ) ) {
			return;
		}

		if ( ! empty( $required ) ) {
			require_once( ABSPATH . 'wp-admin/includes/class-wp-' . $required . '-list-table.php' );
			require_once( MEMBERS_PATH."ura-pending-approval.php"   );
		}

		return new $class();
	}
	/*
	function screen_options_fields(){

	}
	
	function show_meta_boxes( $screen, $context, $object ){
		$screen = get_current_screen();
		$screen = convert_to_screen('users');
		if ( $screen->id != 'users' ){
			exit( 'NOT USERS' );
			//return;
		}
		$object = (object) '';
		//do_accordion_sections( $screen, 'normal', all_users() );
		do_meta_boxes( $screen, $context, $object );
		//global $wp_meta_boxes;
		//$wp_meta_boxes[$screen->id]['normal'] = array();
		//$a = do_meta_boxes( $screen, $context, $object );
		//return $a;
	}
	*/
	/*
	function screen_options_demo($current, $screen){
		$desired_screen = convert_to_screen('users_page_pending-approval');
		if ( $screen->id == $desired_screen->id ){
			$current .= "Hello WordPress!";
		}
		return $current;
	}
	
	function show_screen_options( $show_screen, $screen ){
		meta_box_prefs( 'users' );
		return true;
	}
	*/
	
	/** 
	 * function users_admin_load
	 * Set up the signups admin page.
	 * Loaded before the page is rendered, this function does all initial
	 * setup, including: processing form requests, registering contextual
	 * help, and setting up screen options.
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @param
	 * @return 
	 * @global $bp_members_signup_list_table
	*/
	
	public function users_admin_load() {
		global $plugin_page, $ura_pending_approval_list_page, $parent_page, $title;
		$ura_pending_approval_list_page = new URA_USERS_LIST_TABLE_NUA();
		$doaction = $ura_pending_approval_list_page->get_bulk_actions();
		$title = __( 'Users') ;
		$parent_file = 'users.php';
		// Build redirection URL
		$redirect_to = remove_query_arg( array( 'action', 'error', 'updated', 'activated', 'notactivated', 'deleted', 'notdeleted', 'resent', 'notresent', 'do_delete', 'do_resend', 'do_activate', '_wpnonce', 'signup_ids' ), $_SERVER['REQUEST_URI'] );
		
		/**
		 * Fires at the start of the signups admin load.
		 *
		 * @since BuddyPress (2.0.0)
		 *
		 * @param string $doaction Current bulk action being processed.
		 * @param array  $_REQUEST Current $_REQUEST global.
		 */
		//do_action( 'ura_signups_admin_load', $doaction, $_REQUEST );

		/**
		 * Filters the allowed actions for use in the user signups admin page.
		 *
		 * @since BuddyPress (2.0.0)
		 *
		 * @param array $value Array of allowed actions to use.
		 */
		$allowed_actions =  array( 'approve_user', 'deny_user', 'email_user' );

		// Prepare the display of the Community Profile screen
		if ( ! in_array( $doaction, $allowed_actions ) || ( -1 == $doaction ) ) {

			
			// per_page screen option
			add_screen_option( 'per_page', array( 'label' => _x( 'Pending Accounts', 'Pending Accounts per page (screen options)', 'csds_userRegAide' ) ) );
		
		$screen = get_current_screen();
		//exit( print_r( $screen ) );
		
			get_current_screen()->add_help_tab( array(
				'id'      => 'pending-approval-overview',
				'title'   => __( 'Overview', 'csds_userRegAide' ),
				'content' =>
				'<p>' . __( 'This is the administration screen for pending accounts on your site.', 'csds_userRegAide' ) . '</p>' .
				'<p>' . __( 'From the screen options, you can customize the displayed columns and the pagination of this screen.', 'csds_userRegAide' ) . '</p>' .
				'<p>' . __( 'You can reorder the list of your pending accounts by clicking on the Username, Email or Registered column headers.', 'csds_userRegAide' ) . '</p>' .
				'<p>' . __( 'Using the search form, you can find pending accounts more easily. The Username and Email fields will be included in the search.', 'csds_userRegAide' ) . '</p>'
			) );

			get_current_screen()->add_help_tab( array(
				'id'      => 'pending-approval-actions',
				'title'   => __( 'Actions', 'csds_userRegAide' ),
				'content' =>
				'<p>' . __( 'Hovering over a row in the pending accounts list will display action links that allow you to manage pending accounts. You can perform the following actions:', 'csds_userRegAide' ) . '</p>' .
				'<ul><li>' . __( '"Email" takes you to the confirmation screen before being able to send the activation link to the desired pending account. You can only send the activation email once per day.', 'csds_userRegAide' ) . '</li>' .
				'<li>' . __( '"Delete" allows you to delete a pending account from your site. You will be asked to confirm this deletion.', 'csds_userRegAide' ) . '</li></ul>' .
				'<p>' . __( 'By clicking on a Username you will be able to activate a pending account from the confirmation screen.', 'csds_userRegAide' ) . '</p>' .
				'<p>' . __( 'Bulk actions allow you to perform these 3 actions for the selected rows.', 'csds_userRegAide' ) . '</p>'
			) );

			// Help panel - sidebar links
			get_current_screen()->set_help_sidebar(
				'<p><strong>' . __( 'For more information:', 'csds_userRegAide' ) . '</strong></p>' .
				'<p>' . __( '<a href="http://buddypress.org/support/">Support Forums</a>', 'csds_userRegAide' ) . '</p>'
			);
		} else {
			if ( ! empty( $_REQUEST['approval_ids' ] ) ) {
				$signups = wp_parse_id_list( $_REQUEST['approval_ids' ] );
			}
		}
		//do_action( 'ura_signups_admin_load', $doaction, $_REQUEST );
	}
	
	/** 
	 * function signups_admin
	 * Signups admin page router.
	 * Depending on the context, display
	 * - the list of signups
	 * - or the delete confirmation screen
	 * - or the activate confirmation screen
	 * - or the "resend" email confirmation screen
	 * Also prepare the admin notices.
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @param
	 * @return 
	*/
	
	public function signups_admin() {
		global $plugin_page, $ura_pending_approval_list_page;
		$ura_pending_approval_list_page = new URA_USERS_LIST_TABLE_NUA();
		$doaction = $ura_pending_approval_list_page->get_bulk_actions();
		$screen = 'users';
		$context = 'normal';
		$nua = new URA_USERS_LIST_TABLE_NUA();
		//$users_screen = WP_Screen();
		$object = OBJECT;
		//$a = $this->show_meta_boxes( $screen, $context, get_post() );
		$screen = get_current_screen();
		//exit( print_r( $screen ) );
		// Prepare notices for admin
		
		// Show the proper screen
		switch ( $doaction ) {
			case 'approve_user' :
			//exit( 'DO ACTION APPROVE USER' );
				$this->signups_admin_index();
				//$nua->process_bulk_action();
				//break;
			case 'deny_user' :
			//exit( 'DO ACTION DENY USER' );
				$this->signups_admin_index();
				break;
			case 'email_user' :
			//exit( 'DO ACTION EMAIL USER' );
				$this->signups_admin_index();
				break;

			default:
			//exit( 'DO ACTION DEFAULT' );
				$this->signups_admin_index();
				break;

		}
	}

	/** 
	 * function signups_admin_index
	 * This is the list of the Pending accounts (signups).
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @param
	 * @return
	 * @global $plugin_page
	 * @global $bp_members_signup_list_table
	*/
	
	public function signups_admin_index() {
		global $plugin_page, $ura_pending_approval_list_page, $screen, $doaction;
		$ura_pending_approval_list_page = new URA_USERS_LIST_TABLE_NUA();
		$usersearch = ! empty( $_REQUEST['s'] ) ? stripslashes( $_REQUEST['s'] ) : '';
		$screen = get_current_screen();
		//exit( $doaction );
		// Prepare the group items for display
		$ura_pending_approval_list_page->prepare_items();
		$page = (String) '';
		if( isset( $_GET['page'] ) ){
			$page = $_GET['page'];
		}
		if( $page == 'pending-approval' ){
			$form_url = add_query_arg(
			array(
				'page' => 'pending-approval',
			),
			get_admin_url().'users.php'
			);
		}elseif( $page = 'pending-deletion' ){
			$form_url = add_query_arg(
			array(
				'page' => 'pending-deletion',
			),
			get_admin_url().'users.php'
			);
		}
		

		$search_form_url = remove_query_arg(
			array(
				'action',
				'deleted',
				'notdeleted',
				'error',
				'updated',
				'delete',
				'activate',
				'activated',
				'notactivated',
				'resend',
				'resent',
				'notresent',
				'do_delete',
				'do_activate',
				'do_resend',
				'action2',
				'_wpnonce',
				'signup_ids'
			), $_SERVER['REQUEST_URI']
		);

		?>

		<div class="wrap">
			<?php screen_icon( 'users' ); ?>
			<h2><?php _e( 'Users', 'buddypress' ); ?>

				<?php// if ( current_user_can( 'create_users' ) ) : ?>

					<a href="user-new.php" class="add-new-h2"><?php echo esc_html_x( 'Add New', 'user', 'csds_userRegAide' ); ?></a>

				<?php /*elseif ( is_multisite() && current_user_can( 'promote_users' ) ) : ?>

					<a href="user-new.php" class="add-new-h2"><?php echo esc_html_x( 'Add Existing', 'user', 'buddypress' ); ?></a>

				<?php endif; */

				if ( $usersearch ) {
					printf( '<span class="subtitle">' . __( 'Search results for &#8220;%s&#8221;', 'csds_userRegAide' ) . '</span>', esc_html( $usersearch ) );
				}

				?>
			</h2>
			<?php
			if( isset( $_GET['action'] ) ){
				exit( 'ACTION IS SET!' );
			}
			?>
			<?php // Display each signups on its own row ?>
			<?php $ura_pending_approval_list_page->views(); ?>

			<form id="ura-approvals-search-form" action="<?php echo esc_url( $search_form_url ) ;?>">
				<input type="hidden" name="page" value="<?php echo esc_attr( $plugin_page ); ?>" />
				<?php //$bp_members_signup_list_table->search_box( __( 'Search Pending Users', 'buddypress' ), 'bp-signups' ); ?>
			</form>

			<form id="ura-approvals-form" action="<?php echo esc_url( $form_url );?>" method="post">
				<?php $ura_pending_approval_list_page->display(); ?>
			</form>
		</div>
	<?php
	}

	/** 
	 * function signups_admin_manage
	 * This is the confirmation screen for actions.
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @param string $action Delete, activate, or resend activation link.
	 * @return
	*/
	
	public function signups_admin_manage( $action = '' ) {
		//global $plugin_page, $ura_pending_approval_list_page, $screen, $doaction;
		//$ura_pending_approval_list_page = new URA_USERS_LIST_TABLE_NUA();
		//if ( ! current_user_can( $this->capability ) || empty( $action ) ) {
		//	die( '-1' );
		//}
		//$ura_pending_approval_list_page->prepare_items();
		//$page = (String) '';
		//exit( print_r( $action ) );
		// Get the user IDs from the URL
		$ids = false;
		if ( ! empty( $_POST['approval'] ) ) {
			$ids = wp_parse_id_list( $_POST['approval'] );
		} elseif ( ! empty( $_GET['signup_id'] ) ) {
			$ids = absint( $_GET['signup_id'] );
		}

		if ( empty( $ids ) ) {
			return false;
		}

		// Query for signups, and filter out those IDs that don't
		// correspond to an actual signup
		//$signups_query = BP_Signup::get( array(
		//	'include' => $ids,
		//) );

		//$signups    = $signups_query['signups'];
		//$signup_ids = wp_list_pluck( $signups, 'signup_id' );
		$signup_ids = $this->signups_ids();
		// Set up strings
		switch ( $action ) {
			case 'approve_user' :
				$header_text = __( 'Delete Pending Accounts', 'csds_userRegAide' );
				$helper_text = _n( 'You are about to delete the following account:', 'You are about to delete the following accounts:', count( $signup_ids ), 'csds_userRegAide' );
				break;

			case 'deny_user' :
				$header_text = __( 'Activate Pending Accounts', 'csds_userRegAide' );
				$helper_text = _n( 'You are about to activate the following account:', 'You are about to activate the following accounts:', count( $signup_ids ), 'csds_userRegAide' );
				break;

			case 'email_user' :
				$header_text = __( 'Resend Activation Emails', 'csds_userRegAide' );
				$helper_text = _n( 'You are about to resend an activation email to the following account:', 'You are about to resend activation emails to the following accounts:', count( $signup_ids ), 'csds_userRegAide' );
				break;
				
			case 'delete_user' :
				$header_text = __( 'Resend Activation Emails', 'csds_userRegAide' );
				$helper_text = _n( 'You are about to resend an activation email to the following account:', 'You are about to resend activation emails to the following accounts:', count( $signup_ids ), 'csds_userRegAide' );
				break;
		}

		// These arguments are added to all URLs
		$url_args = array( 'page' => 'pending-approval' );

		// These arguments are only added when performing an action
		$action_args = array(
			'action'     => 'do_' . $action,
			'approval_ids' => implode( ',', $signup_ids )
		);

		$cancel_url = add_query_arg( $url_args, get_admin_url().'users.php' );
		$action_url = wp_nonce_url(
			add_query_arg(
				array_merge( $url_args, $action_args ),
				get_admin_url().'users.php'
			),
			'approvals_' . $action
		);

		?>

		<div class="wrap">
			<?php screen_icon( 'users' ); ?>
			<h2><?php echo esc_html( $header_text ); ?></h2>
			<p><?php echo esc_html( $helper_text ); ?></p>

			<ol class="bp-signups-list">
			<?php foreach ( $signups as $signup ) :

				$last_notified = mysql2date( 'Y/m/d g:i:s a', $signup->date_sent ); ?>

				<li>
					<?php echo esc_html( $signup->user_name ) ?> - <?php echo sanitize_email( $signup->user_email );?>

					<?php if ( 'resend' == $action ) : ?>

						<p class="description">
							<?php printf( esc_html__( 'Last notified: %s', 'buddypress'), $last_notified ) ;?>

							<?php if ( ! empty( $signup->recently_sent ) ) : ?>

								<span class="attention wp-ui-text-notification"> <?php esc_html_e( '(less than 24 hours ago)', 'csds_userRegAide' ); ?></span>

							<?php endif; ?>
						</p>

					<?php endif; ?>

				</li>

			<?php endforeach; ?>
			</ol>

			<?php if ( 'delete' === $action ) : ?>

				<p><strong><?php esc_html_e( 'This action cannot be undone.', 'csds_userRegAide' ) ?></strong></p>

			<?php endif ; ?>

			<a class="button-primary" href="<?php echo esc_url( $action_url ); ?>"><?php esc_html_e( 'Confirm', 'csds_userRegAide' ); ?></a>
			<a class="button" href="<?php echo esc_url( $cancel_url ); ?>"><?php esc_html_e( 'Cancel', 'csds_userRegAide' ) ?></a>
		</div>

		<?php
	}
	
	/** 
	 * function signups_ids
	 * Gets all users that are not approved yet
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @param 
	 * @return OBJECT $ids Array of Users from users table that are not yet active
	*/
	
	function signups_ids(){
		global $wpdb;
		$table_name = $wpdb->prefix . "users";
		$status = 2;
		$sql = "SELECT * FROM $table_name WHERE user_status = %d";
		$select = $wpdb->prepare( $sql, $status );
		$ids = $wpdb->get_results( $select, OBJECT );
		return $ids;
	}
	
	/** 
	 * function signups_ids
	 * Add our panel to the "Screen Options" box
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @param 
	 * @return
	*/
	
	function add_panel(){
		$args = array(
			array( &$ura_admin, 'ura_users-default-settings' ),       //Panel ID
			'URA Users Defaults',              //Panel title. 
			array( &$ura_admin, 'ura_users_default_settings_panel' ), //The function that generates panel contents.
			array('users_page_pending-approval', 'users_page_pending-deletion'), //Pages/screens where the panel is displayed. 
			array( &$ura_admin, 'ura_users_save_new_defaults' ),      //The function that gets triggered when settings are submitted/saved.
			true                              //Auto-submit settings (via AJAX) when they change. 
		);
	 
	}
	
	/** 
	 * function ura_users_default_settings_panel
	 * Generate the "Raw HTML defaults" panel for Screen Options.
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @param 
	 * @return string $output
	*/
	
	function ura_users_default_settings_panel(){
		$defaults = ura_users_screen_options_default_settings();
		
		//Output checkboxes 
		$fields = array(
			'disable_wptexturize' 		=> 'Disable wptexturize',
			'disable_wpautop' 			=> 'Disable automatic paragraphs',
			'disable_convert_chars' 	=> 'Disable convert_chars',
			'disable_convert_smilies' 	=> 'Disable smilies',
		 );
		  
		$output = '';
		foreach( $fields as $field => $legend ){
			$esc_field = esc_attr( $field );
			$output .= sprintf(
				'<label for="ura_users_default-%s" style="line-height: 20px;">
					<input type="checkbox" name="ura_users_default-%s" id="ura_users_default-%s"%s>
					%s
				</label><br>',
				$esc_field,
				$esc_field,
				$esc_field,
				( $defaults[$field]?' checked="checked"':'' ),
				$legend
			);
		}
		 
		return $output;
		
	}
	
	/** 
	 * function ura_users_save_new_default
	 * Process the "Raw HTML defaults" form fields and save new settings
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @param array $params
	 * @return void
	*/
		
	function ura_users_save_new_defaults( $params ){
		//Get current defaults
		$defaults = ura_users_get_default_settings();
		 
		//Read new values from the submitted form
		foreach($defaults as $field => $old_value){
			if ( isset( $params['ura_users_default-'.$field] ) && ( $params['ura_users_default-'.$field] == 'on' ) ){
				$defaults[$field] = true;
			} else {
				$defaults[$field] = false;
			}
		}
		 
		//Store the new defaults
		ura_users_set_default_settings( $defaults );
	}
}
} // class_exists check

// Load the BP Members admin
//add_action( 'bp_init', array( 'BP_Members_Admin', 'register_members_admin' ) );
