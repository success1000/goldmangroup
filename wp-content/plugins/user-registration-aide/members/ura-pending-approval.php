<?php
/*
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

if ( !class_exists( 'WP_Users_List_Table') ){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-users-list-table.php' );// CHECK!!! throwing errors in 1.5.2.0 
}
require_once(ABSPATH . 'wp-admin/includes/template.php' );
*/
/**
 * Class URA_USERS_LIST_TABLE_NUA
 *
 * @category Class
 * @since 1.5.2.0
 * @updated 1.5.2.0
 * @access public
 * @author Brian Novotny
 * @website http://creative-software-design-solutions.com
*/

class URA_USERS_LIST_TABLE_NUA extends WP_Users_List_Table
{

	public $screen;
	public $_args;
	public $total_count;
	public $do_action;
	/**
	 * Site ID to generate the Users list table for.
	 *
	 * @since 1.5.2.0
	 * @access public
	 * @var int
	 */
	public $site_id;

	/**
	 * Whether or not the current Users list table is for Multisite.
	 *
	 * @since 1.5.2.0
	 * @access public
	 * @var bool
	 */
	public $is_site_users;
	/**
	 * Constructor.
	 *
	 * @since 1.5.2.0
	 * @access public
	 *
	 * @see WP_List_Table::__construct() for more information on default arguments.
	 *
	 * @param array $args An associative array of arguments.
	 */
	public function __construct( $args = array() ) {
				
		$page = (String) '';
		if( isset( $_GET['page'] ) ){
			$page = $_GET['page'];
		}
		
		if( $page == 'pending-approval' ){
			$args['screen'] = 'pending-approval';
			parent::__construct( array(
				'singular' => 'approve user',
				'plural'   => 'approve users',
				'screen'   => isset( $args['screen'] ) ? $args['screen'] : 'pending-approval',
			) );
		}elseif( $page = 'pending-deletion' ){
			$args['screen'] = 'pending-deletion';
			parent::__construct( array(
				'singular' => 'delete user',
				'plural'   => 'delete users',
				'screen'   => isset( $args['screen'] ) ? $args['screen'] : 'pending-deletion',
			) );
		}elseif( $page = 'pending-verification' ){
			$args['screen'] = 'pending-verification';
			parent::__construct( array(
				'singular' => 'activate user',
				'plural'   => 'activate users',
				'screen'   => isset( $args['screen'] ) ? $args['screen'] : 'pending-verification',
			) );
		}
		
		//$this->is_site_users = 'site-users-network' == $this->screen->id;

		if ( $this->is_site_users ){
			$this->site_id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;
		}
		
	}
	
	/** 
	 * function prepare_items
	 * Prepares screen for new user approveal user list
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns 
	*/
	
	function prepare_items() {
        global $role, $usersearch, $screen;
		$screen = get_current_screen();
		$screen_id = $screen->id;
		//exit( print_r( $screen ) );
		
		if( isset( $_GET['action2'] ) ){
			
		}elseif( isset( $_POST['action2'] ) ){
			$this->process_bulk_action();
			
		}	
		
		$userspage = 'users_page_';
		$usersearch = isset( $_REQUEST['s'] ) ? wp_unslash( trim( $_REQUEST['s'] ) ) : '';
		$args = array();
		$role = isset( $_REQUEST['role'] ) ? $_REQUEST['role'] : '';

		$per_page = ( $this->is_site_users ) ? 'site_users_network_per_page' : 'users_per_page';
		$users_per_page = $this->get_items_per_page( $per_page );

		$paged = $this->get_pagenum();
		
		
		$args = array(
				'number'		=> $users_per_page,
				'offset' 		=> ( $paged-1 ) * $users_per_page,
				'role' 			=> $role,
				'meta_key'     	=> 'approval_status',
				'meta_value'   	=> 'pending',
				'meta_compare' 	=> '=',
				'orderby'		=> 'registered',
				'order'			=> 'DESC',
				'search' 		=> $usersearch,
				'fields' 		=> 'all_with_meta'
			);
		
		if( $screen->id == $userspage.'pending-approval' ){
			$args = array(
				'number'		=> $users_per_page,
				'offset' 		=> ( $paged-1 ) * $users_per_page,
				'role' 			=> $role,
				'meta_key'     	=> 'approval_status',
				'meta_value'   	=> 'pending',
				'meta_compare' 	=> '=',
				'orderby'		=> 'registered',
				'order'			=> 'DESC',
				'search' 		=> $usersearch,
				'fields' 		=> 'all_with_meta'
			);
		}elseif( $screen->id == $userspage.'pending-deletion' ){
			$args = array(
				'number'		=> $users_per_page,
				'offset' 		=> ( $paged-1 ) * $users_per_page,
				'role' 			=> $role,
				'meta_key'     	=> 'approval_status',
				'meta_value'   	=> 'denied',
				'meta_compare'	=> '=',
				'orderby'		=> 'registered',
				'order'			=> 'DESC',
				'search' 		=> $usersearch,
				'fields' 		=> 'all_with_meta'
			);
		}elseif( $screen->id == $userspage.'pending-verification' ){
			$args = array(
				'number'		=> $users_per_page,
				'offset' 		=> ( $paged-1 ) * $users_per_page,
				'role' 			=> $role,
				'meta_key'     	=> 'approval_status',
				'meta_value'   	=> 'approved',
				'meta_compare'	=> '=',
				'meta_key'		=> 'email_verification',
				'meta_value'   	=> 'unverified',
				'meta_compare'	=> '=',
				'orderby'		=> 'registered',
				'order'			=> 'DESC',
				'search' 		=> $usersearch,
				'fields' 		=> 'all_with_meta'
			);
		}
		
		if ( '' !== $args['search'] )
			$args['search'] = '*' . $args['search'] . '*';

		if ( $this->is_site_users )
			$args['blog_id'] = $this->site_id;

		if ( isset( $_REQUEST['orderby'] ) )
			$args['orderby'] = $_REQUEST['orderby'];

		if ( isset( $_REQUEST['order'] ) )
			$args['order'] = $_REQUEST['order'];

		// Query the user IDs for this page
		//$lph = new NEW_USER_APPROVE_CONTROLLER();
		$wp_user_search = new WP_User_Query( $args );

		$this->items = $wp_user_search->get_results();
		//$this->items = $lph->unapproved_user_list();
		$this->set_pagination_args( array(
			'total_items' => $wp_user_search->get_total(),
			'per_page' => $users_per_page,
		) );
		
		
    }
	
	/** 
	 * function extra_tablenav
	 * 
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params $which
	 * @returns 
	*/
	
	public function extra_tablenav( $which ) {
			return;
	}
	
	/** 
	 * function get_views
	 * Return an associative array listing all the views that can be used
	 * with this table.
	 *
	 * Provides a list of roles and user count for that role for easy
	 * filtering of the user table.
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params
	 * @returns array An array of HTML links, one for each view.
	*/
	
	public function get_views() {
		$views = parent::get_views();
		global $screen;
		
		$screen = get_current_screen();
		$userspage = 'users_page_';
		$class = ' class="current"';
		$nuac = new NEW_USER_APPROVE_CONTROLLER();
		//$count = (int) $nuac->un_count( 'approve' );
		$role = 'role';
		//exit( print_r( $screen ) );
		$page_role = (string) '';
		$default_role = get_option( 'default_role' );
		$title = ucfirst( $default_role );
		// Remove the 'current' class from the 'All' link
		$views['all'] = str_replace( 'class="current"', '', $views['all'] );
		$options = get_option( 'csds_userRegAide_Options' );
		$verify = $options['verify_email'];
		if( isset( $_GET['role'] ) ){
			$page_role = $_GET['role'];
			$rcount = (int) $nuac->role_count_2( $default_role );
			if( $page_role == $default_role ){
				$views[$default_role] = sprintf( '<a href="%1$s" class="current">%2$s</a>', esc_url( add_query_arg( 'role', $default_role, get_admin_url(  ).'users.php' ) ), sprintf( _x( $title .' %s', $default_role, 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $rcount ) . ')</span>' ) );
				//$views[$default_role] = "<a href='users.php?role=$default_role'$class>$title".'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
			}else{
				//$views[$default_role] = "<a href='users.php?role=$default_role'>$title".'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
				$views[$default_role] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'role', $default_role, get_admin_url(  ).'users.php' ) ), sprintf( _x( $title .' %s', $default_role, 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $rcount ) . ')</span>' ) );
			}
			$count = $nuac->un_count('approve');
			$url = '?page=pending-approval';
			$views['pending-approval'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-approval', get_admin_url().'users.php' ) ), sprintf( _x( 'Pending Approval %s', 'pending-approval', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
			//$views['pending-approval'] = '<a href="users.php">Pending Approval'.'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			$count = (int) $nuac->un_count( 'denied' );
			$views['pending-deletion'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-deletion', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Deletion %s', 'pending-deletion', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
			//$views['pending-deletion'] = "<a href='users.php?page=pending-deletion'>Pending Deletion".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			if( $verify == 1 ){
				$count = (int) $nuac->un_count( 'unverified' );
				$views['pending-verification'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-verification', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Verification %s', 'pending-verification', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
				//$views['pending-verification'] = "<a href='users.php?page=pending-verification'>Pending Verification".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			}
		}
		if( $screen->id == $userspage.'pending-approval' ){
			$rcount = (int) $nuac->role_count_2( $default_role );
			//$views[$default_role] = "<a href='users.php?role=$default_role'>$title".'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
			$views[$default_role] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'role', $default_role, get_admin_url(  ).'users.php' ) ), sprintf( _x( $title .' %s', $default_role, 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $rcount ) . ')</span>' ) );
			$count = $nuac->un_count('approve');
			$url = get_admin_url().'users.php';
			$views['pending-approval'] = sprintf( '<a href="%1$s" class="current">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-approval', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Approval %s', 'pending-approval', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
			//$views['pending-approval'] = "<a href='users.php?page=pending-approval'$class>Pending Approval".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			$count = (int) $nuac->un_count( 'denied' );
			//$views['pending-deletion'] = "<a href='users.php?page=pending-deletion'>Pending Deletion".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			$views['pending-deletion'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-deletion', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Deletion %s', 'pending-deletion', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
			if( $verify == 1 ){
				$count = (int) $nuac->un_count( 'unverified' );
				//$views['pending-verification'] = "<a href='users.php?page=pending-verification'>Pending Verification".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
				$views['pending-verification'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-verification', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Verification %s', 'pending-verification', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
			}
		}elseif( $screen->id == $userspage.'pending-deletion' ){
			$rcount = (int) $nuac->role_count_2( $default_role );
			$views[$default_role] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'role', $default_role, get_admin_url(  ).'users.php' ) ), sprintf( _x( $title .' %s', $default_role, 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $rcount ) . ')</span>' ) );
			//$views[$default_role] = "<a href='users.php?role=$default_role'>$title".'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
			$count = $nuac->un_count('approve');
			$views['pending-approval'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-approval', get_admin_url().'users.php' ) ), sprintf( _x( 'Pending Approval %s', 'pending-approval', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
			//$views['pending-approval'] = "<a href='users.php?page=pending-approval'>Pending Approval".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			$count = (int) $nuac->un_count( 'denied' );
			$views['pending-deletion'] = sprintf( '<a href="%1$s" class="current">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-deletion', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Deletion %s', 'pending-deletion', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
			//$views['pending-deletion'] = "<a href='users.php?page=pending-deletion'$class>Pending Deletion".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			if( $verify == 1 ){
				$count = (int) $nuac->un_count( 'unverified' );
				$views['pending-verification'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-verification', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Verification %s', 'pending-verification', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
			}
			//$views['pending-verification'] = "<a href='users.php?page=pending-verification'>Pending Verification".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
		}elseif( $screen->id == $userspage.'pending-verification' ){
			$rcount = (int) $nuac->role_count_2( $default_role );
			$views[$default_role] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'role', $default_role, get_admin_url(  ).'users.php' ) ), sprintf( _x( $title .' %s', $default_role, 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $rcount ) . ')</span>' ) );
			//$views[$default_role] = "<a href='users.php?role=$default_role'>$title".'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
			$count = $nuac->un_count('approve');
			$views['pending-approval'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-approval', get_admin_url().'users.php' ) ), sprintf( _x( 'Pending Approval %s', 'pending-approval', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
			//$views['pending-approval'] = "<a href='users.php?page=pending-approval'>Pending 
			//Approval".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			$count = (int) $nuac->un_count( 'denied' );
			$views['pending-deletion'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-deletion', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Deletion %s', 'pending-deletion', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
			//$views['pending-deletion'] = "<a href='users.php?page=pending-deletion'>Pending Deletion".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			if( $verify == 1 ){
				$count = (int) $nuac->un_count( 'unverified' );
				$views['pending-verification'] = sprintf( '<a href="%1$s" class="current">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-verification', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Verification %s', 'pending-verification', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
			}
			//$views['pending-verification'] = "<a href='users.php?page=pending-verification'$class>Pending Verification".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
		}else{
			$page = (string) '';
			$role = 'role';
			$page_role = (string) '';
			$default_role = get_option( 'default_role' );
			$title = ucfirst( $default_role );
			$rcount = (int) $nuac->role_count_2( $default_role );
			
			if( isset( $_GET['page'] ) ){
				$page = $_GET['page'];
				//exit( 'PAGE!!!' );
				$rcount = (int) $nuac->role_count_2( $default_role );
				if( $page == 'users.php' ){
					$views[$default_role] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'role', $default_role, get_admin_url(  ).'users.php' ) ), sprintf( _x( $title .' %s', $default_role, 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $rcount ) . ')</span>' ) );
					//$views[$default_role] = "<a href='users.php?role=$default_role'>$title".'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
				}
			}elseif( isset( $_GET['role'] ) ){
				$page_role = $_GET[$role];
				$rcount = (int) $nuac->role_count_2( $default_role );
				if( $page_role == $default_role ){
					$views[$default_role] = sprintf( '<a href="%1$s" class="current">%2$s</a>', esc_url( add_query_arg( 'role', $default_role, get_admin_url(  ).'users.php' ) ), sprintf( _x( $title .' %s', $default_role, 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $rcount ) . ')</span>' ) );
					//$views[$default_role] = "<a href='users.php?role=$default_role'$class>$title".'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
				}else{
					$views[$default_role] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'role', $default_role, get_admin_url(  ).'users.php' ) ), sprintf( _x( $title .' %s', $default_role, 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $rcount ) . ')</span>' ) );
					//$views[$default_role] = "<a href='users.php?role=$default_role'>$title".'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
				}
			}else{
				$views[$default_role] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'role', $default_role, get_admin_url(  ).'users.php' ) ), sprintf( _x( $title .' %s', $default_role, 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $rcount ) . ')</span>' ) );
				//$views[$default_role] = "<a href='users.php?role=$default_role'>$title".'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
			}
			
			$count = $nuac->un_count('approve');
			$views['pending-approval'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-approval', get_admin_url().'users.php' ) ), sprintf( _x( 'Pending Approval %s', 'pending-approval', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
			//$views['pending-approval'] = "<a href='users.php?page=pending-approval'>Pending 
			//Approval".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			$count = (int) $nuac->un_count( 'denied' );
			$views['pending-deletion'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-deletion', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Deletion %s', 'pending-deletion', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
			//$views['pending-deletion'] = "<a href='users.php?page=pending-deletion'>Pending Deletion".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
			if( $verify == 1 ){
				$count = (int) $nuac->un_count( 'unverified' );
				$views['pending-verification'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-verification', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Verification %s', 'pending-verification', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
			}
			//$views['pending-verification'] = "<a href='users.php?page=pending-verification'>Pending Verification".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
		}
		
		return $views;
	}
	
	/** 
	 * function column_default
	 * sets the column defaults for the user list table
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params OBJECT $item, string $column_name
	 * @returns OBJECT $item->$column_name
	*/
		
    public function column_default( $item, $column_name ){
		global $current_user;
		$field = new FIELDS_DATABASE();
		$sel_fields = $field->get_nua_fields();
		$wp_fields = get_option( 'csds_userRegAide_knownFields' );
		$user = wp_get_current_user();
		$user_defaults = get_user_meta( $user->ID, 'ura_users_column_defaults', true );
		if( $column_name == 'username' ){
			return $item->$column_name;
		}elseif( $column_name == 'user_email' ){
			return $item->$column_name;
		}elseif( $column_name == 'user_registered' ){
			return $item->$column_name;
		}elseif( $column_name == 'emails_sent' ){
			return $item->$column_name;
		}elseif( $column_name == 'email_verification' ){
			return $item->$column_name;
		}
		
		foreach( $wp_fields as $key	=> $title ){
			foreach( $user_defaults as $meta => $value ){
				if( $meta == $key ){
					if( $value = 1 ){
						return $item->$column_name;
					}
				}
				
			}
		}
		
		foreach( $sel_fields as $object ){
			$key = $object->meta_key;
			if( $column_name == $key ){
				return $item->$column_name;
			}else{
				//return print_r($item,true); //Show the whole array for troubleshooting purposes
				//echo 'WTF!';
			}
		}
    }
	
	/** 
	 * function column_cb
	 * sets the column checkboxes for the user list table
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params OBJECT $item column
	 * @returns OBJECT $item
	*/
		
    public function column_cb( $item ){
        return sprintf(
            '<input type="checkbox" name="approval[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item->user_login                //The value of the checkbox should be the record's id
        );
    }
	
	/** 
	 * function get_columns
	 * sets the column checkboxes for the user list table
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params 
	 * @returns array $columns
	*/
		
    public function get_columns(){
		global $current_user;
		$field = new FIELDS_DATABASE();
		$sel_fields = $field->get_nua_fields();
		$wp_fields = get_option( 'csds_userRegAide_knownFields' );
		$user = wp_get_current_user();
		$user_defaults = get_user_meta( $user->ID, 'ura_users_column_defaults', true );
		$columns = array(
			'cb'       				=> '<input type="checkbox" />', //Render a checkbox instead of text
            'user_login'			=>	__( 'User Login', 'csds_userRegAide' ),
			'user_email'			=>	__( 'E-mail', 'csds_userRegAide' ),
			'user_registered'		=>	__( 'User Registered', 'csds_userRegAide' ),
			'emails_sent'			=>	__( 'Emails Sent', 'csds_userRegAide' ),
			'email_verification'	=>	__( 'Email Verification', 'csds_userRegAide' ),
			
        );
		
		foreach( $wp_fields as $key	=> $title ){
			foreach( $user_defaults as $meta => $value ){
				if( $meta == $key ){
					if( !empty( $value ) || $value == 1 ){
						$columns[$key] = $title;
					}
				}
				
			}
		}
		
		foreach( $sel_fields as $object ){
			$key = $object->meta_key;
			$field = $object->field_name;
			$columns[$key] = $field;
			
		}
		return $columns;
    }
	
	/** 
	 * function get_sortable_columns
	 * sets the sortable columns for the user list table
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params 
	 * @returns array $sortable_columns
	*/
		
    public function get_sortable_columns() {
        $sortable_columns = array(
			'user_login'     		=> array( 'user_login', false ),//true means it's already sorted
		    'user_registered'     	=> array( 'user_registered', false ),//true means it's already sorted
			'user_email'     		=> array( 'user_email', false )//true means it's already sorted
            
        );
        return $sortable_columns;
    }
	
	/** 
	 * function get_bulk_actions
	 * sets the bulk actions for the user list table
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params 
	 * @returns array $actions
	*/
	
    public function get_bulk_actions() {
		
		global $screen;
		$screen = get_current_screen();
		$userspage = 'users_page_';
		if( $screen->id == $userspage.'pending-approval' ){
			$actions = array(
				'approve_user'    => __( 'Approve User', 'csds_userRegAide' ),
				'deny_user'    	  => __( 'Deny User', 'csds_userRegAide' ),
				'email_user'	  => __( 'Email User', 'csds_userRegAide' )
			);
			return $actions;
		}elseif( $screen->id == $userspage.'pending-deletion' ){
			$actions = array(
				'delete_user'    => __( 'Delete Denied User', 'csds_userRegAide' ),
				'approve_user'   => __( 'Approve User', 'csds_userRegAide' )
			);
			return $actions;
		}elseif( $screen->id == $userspage.'pending-verification' ){
			$actions = array(
				'activate_user'    => __( 'Activate User', 'csds_userRegAide' ),
				'deny_user'    	   => __( 'Deny User', 'csds_userRegAide' ),
				'email_user'   	   => __( 'Email User', 'csds_userRegAide' )
			);
			return $actions;
		}
    }

	/** 
	 * function process_bulk_action
	 * processes the bulk actions for the user list table
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params 
	 * @returns 
	*/
   
    function process_bulk_action() {
        //exit( 'PROCESS BULK ACTION' );
		$action = $_POST['action2'];
		//Detect when a bulk action is being triggered...
        if( 'approve_user' === $action ) {
			//exit( 'APPROVE USER!' );
            //wp_die('Nothing to do, List is for viewing only!');
			if( !empty( $_POST['approval'] ) ){
				if( is_array( $_POST['approval'] ) ){
					foreach( $_POST['approval'] as $approve ){
						$username = $approve;
						$nuac = new NEW_USER_APPROVE_CONTROLLER();
						$nuac->approve_user( $username );
					}
				}else{
					$username = $_POST['approval'];
					$nuac = new NEW_USER_APPROVE_CONTROLLER();
					$nuac->approve_user( $username );
				}
			}
        }elseif( 'deny_user' === $action ) {
			if( !empty( $_POST['approval'] ) ){
				if( is_array( $_POST['approval'] ) ){
					foreach( $_POST['approval'] as $approve ){
						$username = $approve;
						$nuac = new NEW_USER_APPROVE_CONTROLLER();
						$nuac->deny_user( $username );
					}
				}else{
					$username = $_POST['approval'];
					$nuac = new NEW_USER_APPROVE_CONTROLLER();
					$nuac->deny_user( $username );
				}
			}
		}elseif( 'email_user' === $action ) {
			if( !empty( $_POST['approval'] ) ){
				if( is_array( $_POST['approval'] ) ){
					foreach( $_POST['approval'] as $approve ){
						$username = $approve;
						$nuac = new NEW_USER_APPROVE_CONTROLLER();
						$nuac->email_user( $username );
					}
				}else{
					$username = $_POST['approval'];
					$nuac = new NEW_USER_APPROVE_CONTROLLER();
					$nuac->email_user( $username );
				}
			}
		}elseif( 'activate_user' === $action ) {
			foreach( $_POST['approval'] as $activate ){
				$username = $activate;
				$nuac = new NEW_USER_APPROVE_CONTROLLER();
				$nuac->activate_user( $username );
			}
		}elseif( 'delete_user' === $action ) {
			foreach( $_POST['approval'] as $delete ){
				$username = $delete;
				$nud = new NEW_USER_DENIED_CONTROLLER();
				$nud->denied_user_delete( $username );
			}
		}
        
    }
	
	/** 
	 * function display_rows
	 * Display signups rows.
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params 
	 * @returns 
	*/
   
	public function display_rows() {
		$style = '';
		foreach ( $this->items as $userid => $user_object ) {
			$style = ( ' class="alternate"' == $style ) ? '' : ' class="alternate"';
			echo "\n\t" . $this->single_row( $user_object, $style );
		}
	}
	
	/** 
	 * function single_row
	 * Display a signup row.
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params WP_User OBJECT $user_object, string $style, string $role, int $numposts
	 * @returns 
	*/
   
	public function single_row( $user_object, $style = '', $role = '', $numposts = 0 ) {
		$user_object->user_email = "<a href='mailto:$user_object->user_email'>$user_object->user_email</a>";
		echo '<tr' . $style . ' id="' . esc_attr( $user_object->ID ) . '">';
		echo $this->single_row_columns( $user_object );
		echo '</tr>';
	}
	
	/** 
	 * function current_action
	 * Capture the bulk action required, and return it.
	 * Overridden from the base class implementation to capture
	 * the role change drop-down.
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params 
	 * @returns string The bulk action required.
	*/
   
	public function current_action() {
		if ( isset($_REQUEST['changeit']) && !empty($_REQUEST['new_role']) )
			return 'promote';

		return parent::current_action();
	}
	
	/** 
	 * function current_action
	 * Display the list of views available on this table.
	 * @since 1.5.2.0
	 * @updated 1.5.2.0
	 * @access public
	 * @params 
	 * @returns string The bulk action required.
	*/
   
	public function views() {
		$views = $this->get_views();
		/**
		 * Filter the list of available list table views.
		 *
		 * The dynamic portion of the hook name, `$this->screen->id`, refers
		 * to the ID of the current screen, usually a string.
		 *
		 * @since 3.5.0
		 *
		 * @param array $views An array of available list table views.
		 */
		$views = apply_filters( "views_{$this->screen->id}", $views );
		
		if ( empty( $views ) )
			return;

		echo "<ul class='subsubsub'>\n";
		foreach ( $views as $class => $view ) {
			$views[ $class ] = "\t<li class='$class'>$view";
		}
		echo implode( " |</li>\n", $views ) . "</li>\n";
		echo "</ul>";
	}
	
	
}

/** *************************** RENDER TEST PAGE ********************************
 *******************************************************************************
 * This function renders the admin page and the example list table. Although it's
 * possible to call prepare_items() and display() from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */

/** 
 * function modify_views_users
 * adds my views to user list table views
 * @since 1.5.2.0
 * @updated 1.5.2.0
 * @access public
 * @params array $views
 * @returns array $views
*/
     
function modify_views_users( $views ){
	//$views = parent::get_views();
	$nuac = new NEW_USER_APPROVE_CONTROLLER();
	$screen = get_current_screen();
	$class = ' class="current"';
	$userspage = 'users_page_';
	$default_role = get_option( 'default_role' );
	$title = ucfirst( $default_role );
	$page_role = (string) '';
	$options = get_option('csds_userRegAide_Options');
	$verify = $options['verify_email'];
	if( isset( $_GET['role'] ) ){
		$page_role = $_GET['role'];
		$rcount = (int) $nuac->role_count_2( $default_role );
		if( $page_role == $default_role ){
			$views[$default_role] = sprintf( '<a href="%1$s" class="current">%2$s</a>', esc_url( add_query_arg( 'role', $default_role, get_admin_url(  ).'users.php' ) ), sprintf( _x( $title .' %s', $default_role, 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $rcount ) . ')</span>' ) );
			//$views[$default_role] = "<a href='users.php?role=$default_role'$class>$title".'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
		}else{
			$views[$default_role] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'role', $default_role, get_admin_url(  ).'users.php' ) ), sprintf( _x( $title .' %s', $default_role, 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $rcount ) . ')</span>' ) );
			//$views[$default_role] = "<a href='users.php?role=$default_role'>$title".'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
		}
		$views['subscriber'] = "<a href='users.php?role=subscriber'$class>Subscriber".'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
		$count = $nuac->un_count('approve');
		$views['pending-approval'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-approval', get_admin_url().'users.php' ) ), sprintf( _x( 'Pending Approval %s', 'pending-approval', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
		//$views['pending-approval'] = "<a href='users.php?page=pending-approval'>Pending Approval".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
		$count = (int) $nuac->un_count( 'denied' );
		$views['pending-deletion'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-deletion', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Deletion %s', 'pending-deletion', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
		//$views['pending-deletion'] = "<a href='users.php?page=pending-deletion'>Pending Deletion".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
		if( $verify == 1 ){
			$count = (int) $nuac->un_count( 'unverified' );
			$views['pending-verification'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-verification', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Verification %s', 'pending-verification', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
			//$views['pending-verification'] = "<a href='users.php?page=pending-verification'>Pending Verification".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
		}
	}
	if( $screen->id == $userspage.'pending-approval' ){
		$rcount = (int) $nuac->role_count_2( $default_role );
		$views[$default_role] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'role', $default_role, get_admin_url(  ).'users.php' ) ), sprintf( _x( $title .' %s', $default_role, 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $rcount ) . ')</span>' ) );
		//$views[$default_role] = "<a href='users.php?role=$default_role'>$title".'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
		$count = $nuac->un_count('approve');
		$views['pending-approval'] = sprintf( '<a href="%1$s" class="current">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-approval', get_admin_url().'users.php' ) ), sprintf( _x( 'Pending Approval %s', 'pending-approval', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
		//$views['pending-approval'] = "<a href='users.php?page=pending-approval'$class>Pending Approval".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
		$count = (int) $nuac->un_count( 'denied' );
		$views['pending-deletion'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-deletion', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Deletion %s', 'pending-deletion', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
		//$views['pending-deletion'] = "<a href='users.php?page=pending-deletion'>Pending Deletion".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
		if( $verify == 1 ){
			$count = (int) $nuac->un_count( 'unverified' );
			$views['pending-verification'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-verification', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Verification %s', 'pending-verification', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
			//$views['pending-verification'] = "<a href='users.php?page=pending-verification'>Pending Verification".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
		}
	}elseif( $screen->id == $userspage.'pending-deletion' ){
		$rcount = (int) $nuac->role_count_2( $default_role );
		$views[$default_role] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'role', $default_role, get_admin_url(  ).'users.php' ) ), sprintf( _x( $title .' %s', $default_role, 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $rcount ) . ')</span>' ) );
		//$views[$default_role] = "<a href='users.php?role=$default_role'>$title".'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
		$count = $nuac->un_count('approve');
		$views['pending-approval'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-approval', get_admin_url().'users.php' ) ), sprintf( _x( 'Pending Approval %s', 'pending-approval', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
		//$views['pending-approval'] = "<a href='users.php?page=pending-approval'>Pending Approval".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
		$count = (int) $nuac->un_count( 'denied' );
		$views['pending-deletion'] = sprintf( '<a href="%1$s" class="current">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-deletion', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Deletion %s', 'pending-deletion', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
		//$views['pending-deletion'] = "<a href='users.php?page=pending-deletion'$class>Pending Deletion".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
		if( $verify == 1 ){
			$count = (int) $nuac->un_count( 'unverified' );
			$views['pending-verification'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-verification', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Verification %s', 'pending-verification', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
			//$views['pending-verification'] = "<a href='users.php?page=pending-verification'>Pending Verification".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
		}
	}elseif( $screen->id == $userspage.'pending-verification' ){
		$rcount = (int) $nuac->role_count_2( $default_role );
		$views[$default_role] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'role', $default_role, get_admin_url(  ).'users.php' ) ), sprintf( _x( $title .' %s', $default_role, 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $rcount ) . ')</span>' ) );
		//$views[$default_role] = "<a href='users.php?role=$default_role'>$title".'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
		$count = $nuac->un_count('approve');
		$views['pending-approval'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-approval', get_admin_url().'users.php' ) ), sprintf( _x( 'Pending Approval %s', 'pending-approval', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
		//$views['pending-approval'] = "<a href='users.php?page=pending-approval'>Pending 
		//Approval".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
		$count = (int) $nuac->un_count( 'denied' );
		$views['pending-deletion'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-deletion', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Deletion %s', 'pending-deletion', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
		//$views['pending-deletion'] = "<a href='users.php?page=pending-deletion'>Pending Deletion".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
		if( $verify == 1 ){
			$count = (int) $nuac->un_count( 'unverified' );
			$views['pending-verification'] = sprintf( '<a href="%1$s" class="current">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-verification', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Verification %s', 'pending-verification', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
			//$views['pending-verification'] = "<a href='users.php?page=pending-verification'$class>Pending Verification".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
		}
	}else{
		$page = (string) '';
		$role = 'role';
		$page_role = (string) '';
		$default_role = get_option( 'default_role' );
		$title = ucfirst( $default_role );
		$rcount = (int) $nuac->role_count_2( $default_role );
		if( isset( $_GET[$role] ) ){
			$page_role = $_GET[$role];
			if( $page_role == $default_role ){
				$views[$default_role] = sprintf( '<a href="%1$s" class="current">%2$s</a>', esc_url( add_query_arg( 'role', $default_role, get_admin_url(  ).'users.php' ) ), sprintf( _x( $title .' %s', $default_role, 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $rcount ) . ')</span>' ) );
				//$views[$default_role] = "<a href='users.php?role=$default_role'$class>$title".'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
			}else{
				$views[$default_role] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'role', $default_role, get_admin_url(  ).'users.php' ) ), sprintf( _x( $title .' %s', $default_role, 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $rcount ) . ')</span>' ) );
				//$views[$default_role] = "<a href='users.php?role=$default_role'>$title".'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
			}
		}else{
			$views[$default_role] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'role', $default_role, get_admin_url(  ).'users.php' ) ), sprintf( _x( $title .' %s', $default_role, 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $rcount ) . ')</span>' ) );
			//$views[$default_role] = "<a href='users.php?role=$default_role'>$title".'<span class="count"> (' . number_format_i18n( $rcount ) . ')</span>';
		}
		
		$count = $nuac->un_count('approve');
		$views['pending-approval'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-approval', get_admin_url().'users.php' ) ), sprintf( _x( 'Pending Approval %s', 'pending-approval', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
		//$views['pending-approval'] = "<a href='users.php?page=pending-approval'>Pending Approval".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
		$count = (int) $nuac->un_count( 'denied' );
		$views['pending-deletion'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-deletion', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Deletion %s', 'pending-deletion', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
		//$views['pending-deletion'] = "<a href='users.php?page=pending-deletion'>Pending Deletion".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
		if( $verify == 1 ){
			$count = (int) $nuac->un_count( 'unverified' );
			$views['pending-verification'] = sprintf( '<a href="%1$s" class="">%2$s</a>', esc_url( add_query_arg( 'page', 'pending-verification', get_admin_url(  ).'users.php' ) ), sprintf( _x( 'Pending Verification %s', 'pending-verification', 'csds_userRegAide' ), '<span class="count">(' . number_format_i18n( $count ) . ')</span>' ) );
			//$views['pending-verification'] = "<a href='users.php?page=pending-verification'>Pending Verification".'<span class="count"> (' . number_format_i18n( $count ) . ')</span>';
		}
	}
	return $views;
}
/** 
 * new_user_pending_approval_wp_list_view
 * adds my views to user list table views
 * @since 1.5.2.0
 * @updated 1.5.2.0
 * @access public
 * @params array $views
 * @returns array $views
*/

function new_user_pending_approval_wp_list_view(){
    
    //Create an instance of our package class...
    //$nuaListTable = new URA_USERS_LIST_TABLE_NUA();
    //Fetch, prepare, sort, and filter our data...
	global $plugin_page, $ura_pending_approval_list_page, $parent_page, $title;
	$ura_pending_approval_list_page = new URA_USERS_LIST_TABLE_NUA();
	$doaction = $ura_pending_approval_list_page->get_bulk_actions();
	//$title = __( 'Users') ;
	//$parent_file = 'users.php';
	// Build redirection URL
	//$redirect_to = remove_query_arg( array( 'action', 'error', 'updated', 'activated', 'notactivated', 'deleted', 'notdeleted', 'resent', 'notresent', 'do_delete', 'do_resend', 'do_activate', '_wpnonce', 'signup_ids' ), $_SERVER['REQUEST_URI'] );
	$screen = 'users';
	$context = 'normal';
	$ura_pending_approval_list_page->prepare_items();
	//$title = __( 'Users') ;
	//$parent_file = 'users.php';
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
	}elseif( $page = 'pending-verification' ){
		$form_url = add_query_arg(
		array(
			'page' => 'pending-verification',
		),
		get_admin_url().'users.php'
		);
	}
	//
	?>
		<div class="wrap">
		<?php screen_icon( 'users' ); ?>
		<h2><?php _e( 'Users', 'buddypress' ); ?></h2>
		<?php
		
		?>
		<div class="views">
		<?php // Display each signups on its own row ?>
		<?php $ura_pending_approval_list_page->views(); ?>
		</div>
		<form id="ura-approvals-form" action="<?php echo esc_url( $form_url );?>" method="post">
			<?php $ura_pending_approval_list_page->display(); ?>
		</form>
		</div>
<?php 
}


/*
function add_lp_ua_options(){
		global $userActivity;
		$option = 'per_page';
		$args = array(
			'label' => 'Records',
			'default' => 10,
			'option' => 'lp_tableview_records_per_page'
		);
		add_screen_option( $option, $args );
		
		$userActivity = new USER_ACTIVITY_VIEW();
}
	
function set_lp_tableview_ua_screen_options($status, $option, $value){
	return $value;
}*/
?>