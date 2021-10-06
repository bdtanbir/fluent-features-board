<?php
/*
Plugin Name: Fluent Features Board
Plugin URI: 
Description: Fluent Features Board
Version: 0.1
Author: Tanbir Ahmed
Author URI: http://tanbirahmed.unaux.com/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: fluent-features-board
Domain Path: /languages
*/

// don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Fluent_Features_board class
 * @class Fluent_Features_board The class that holds the entire Fluent_Features_board plugin
 */
final class Fluent_Features_board {

    /**
     * Plugin version
     * @var string
     */
    public $version = '1.0.0';

    /**
     * Holds various class instances
     * @var array
     */
    private $container = array();
    public $columns = array();

    public $fluent_features_board = 'fluent_features_board';
    public $ff_requests_list = 'ff_requests_list';
    public $ffr_tags = 'ffr_tags';
    public $ffr_comments = 'ffr_comments';

    /**
     * Constructor for the Fluent_Features_board class
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     */
    public function __construct() {

        $this->define_constants();

        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        add_action( 'wp_enqueue_scripts', [$this, 'ffb_frontend_scripts'] );
        add_action( 'admin_enqueue_scripts', [$this, 'ffb_admin_scripts'] );
        add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
		add_action( 'set_logged_in_cookie', [$this, 'ffb_loggedin_cookie'] );
        add_action( 'wp_ajax_fluent_features_board_ajaxlogin', [$this, 'fluent_features_board_ajaxlogin'] );
        add_action( 'wp_ajax_nopriv_fluent_features_board_ajaxlogin', [$this, 'fluent_features_board_ajaxlogin'] );

        add_action( 'wp_ajax_fluent_features_board_ajaxregister', [$this, 'fluent_features_board_ajaxregister'] );
        add_action( 'wp_ajax_nopriv_fluent_features_board_ajaxregister', [$this, 'fluent_features_board_ajaxregister'] );
        add_filter( 'template_include', [$this, 'load_custom_ffrequest_route_template'] );
    }

    /**
     * Initializes the Fluent_Features_board() class
     *
     * Checks for an existing Fluent_Features_board() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new Fluent_Features_board();
        }

        return $instance;
    }

    /**
     * Magic getter to bypass referencing plugin.
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __get( $prop ) {
        if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
        }

        return $this->{$prop};
    }

    /**
     * Magic isset to bypass referencing plugin.
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __isset( $prop ) {
        return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
    }

    /**
     * Define the constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'FFB_VERSION', $this->version );
        define( 'FFB_FILE', __FILE__ );
        define( 'FFB_PATH', dirname( FFB_FILE ) );
        define( 'FFB_INCLUDES', FFB_PATH . '/includes' );
        define( 'FFB_URL', plugins_url( '', FFB_FILE ) );
        define( 'FFB_ASSETS', FFB_URL . '/assets' );
    }

    /**
     * Load the plugin after all plugins are loaded
     *
     * @return void
     */
    public function init_plugin() {
        $this->includes();
        $this->init_hooks();
        $this->ffb_wpdb_tables();
    }
    public function fluent_features_board_ajaxlogin() {
        // First check the nonce, if it fails the function will break
        check_ajax_referer( 'ajax-login-nonce', 'security' );

        // Nonce is checked, get the POST data and sign user on
        // Call auth_user_login
        $this->ffb_auth_user_login($_POST['username'], $_POST['password'], 'Login');

        die();
    }


    public function fluent_features_board_ajaxregister() {
        global $options; $options = get_option('ffb_register_login');

		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'ajax-register-nonce', 'security' );

		// Nonce is checked, get the POST data and sign user on
		$info = array();
		$info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'] = sanitize_user($_POST['username']) ;
		$info['user_pass']     = sanitize_text_field($_POST['password']);
		$info['user_email']    = sanitize_email( $_POST['email']);

		// Register the user

		if(!is_email($info['user_email']) ){
			echo json_encode(array('loggedin'=>false, 'message'=>esc_html__("Please enter a valid email address","fluent-features-board")));
			die();
		}
		if(sanitize_text_field($_POST['password2'])!=$info['user_pass']){
			echo json_encode(array('loggedin'=>false, 'message'=>esc_html__("Please enter same password in both fields","fluent-features-board")));
			die();
		}
		if(!isset($info['user_pass'])|| !(strlen($info['user_pass']) >0 ) ){
			echo json_encode(array('loggedin'=>false, 'message'=>esc_html__("Password fields cannot be blank","fluent-features-board")));
			die();
		}

		$user_register = wp_insert_user( $info );
		if ( is_wp_error($user_register) ){
			$error  = $user_register->get_error_codes() ;

			if(in_array('empty_user_login', $error))
				echo json_encode(array('loggedin'=>false, 'message'=>$user_register->get_error_message('empty_user_login')));
			elseif(in_array('existing_user_login',$error))
				echo json_encode(array('loggedin'=>false, 'message'=>esc_html__('This username is already registered.','fluent-features-board')));
			elseif(in_array('existing_user_email',$error))
				echo json_encode(array('loggedin'=>false, 'message'=>esc_html__('This email address is already registered.','fluent-features-board')));
		} else {

			$this->ffb_auth_user_login($info['nickname'], $info['user_pass'], 'Registration');
		}

		die();
    }

    public function ffb_auth_user_login($user_login, $password, $login) {
		$info                  = array();
		$info['user_login']    = $user_login;
		$info['user_password'] = $password;


		$user_signon = wp_signon( $info, is_ssl() ? true : false);
		if ( is_wp_error($user_signon) ){
			echo json_encode(array('loggedin'=>false, 'message'=>esc_html__('Wrong username or password.','fluent-features-board')));
		} else {
			global $current_user;
			wp_set_current_user($user_signon->ID);
			if($login=="Login"){
				echo json_encode(array('loggedin'=>true, 'message'=>esc_html__('Login successful, redirecting...','fluent-features-board')));
			}
			else{
				echo json_encode(array('loggedin'=>true, 'message'=>esc_html__('Registration successful, redirecting...','fluent-features-board')));
			}

		}

		die();
    }

    public function ffb_loggedin_cookie( $logged_in_cookie ){
        $_COOKIE[LOGGED_IN_COOKIE] = $logged_in_cookie;
    }

    public function ffb_frontend_scripts() {
        wp_enqueue_style( 'fluent-features-board-global-frontend', FFB_ASSETS .'/css/fluent-features-board.frontend.css' );
        wp_enqueue_script( 'ff-request-frontend', FFB_ASSETS .'/js/ff-request-frontend.js', ['jquery'], true );
        wp_localize_script( 'ff-request-frontend', 'ajax_url', array(
            'ajaxurl'         => admin_url('admin-ajax.php'),
            'redirecturl'     => home_url(),
            'loadingmessage'  => esc_html__('Sending user info, please wait...','fluent-features-board')
        ));
    }

    public function ffb_admin_scripts() {
        wp_enqueue_style( 'fluent-features-board-admin', FFB_ASSETS .'/css/fluent-features-board.admin.css' );
    }

    /**
     * Placeholder for activation function
     *
     * Nothing being called here yet.
     */
    public function activate() {

        $installed = get_option( 'fluent_features_board_installed' );

        if ( ! $installed ) {
            update_option( 'fluent_features_board_installed', time() );
        }

        update_option( 'FFB_version', FFB_VERSION );
    }

    /**
     * Placeholder for deactivation function
     *
     * Nothing being called here yet.
     */
    public function deactivate() {

    }

    public function load_custom_ffrequest_route_template( $original_template ) {
        global $wp;
        $request = explode( '/', $wp->request );
        if ( is_page( 'ff_request' ) || current( $request ) == "ff_request" ) {
            return plugin_dir_path( __FILE__ ) . 'templates/single-ff_request.php';
        }
        return $original_template;
    }

    /**
     * Include the required files
     *
     * @return void
     */
    public function includes() {

        require_once FFB_INCLUDES . '/database/model-table.php';
        require_once FFB_INCLUDES . '/Assets.php';
        require_once FFB_INCLUDES . '/Shortcodes.php';
        require_once FFB_INCLUDES . '/custom_router.php';

        // if ( $this->is_request( 'admin' ) ) {
            require_once FFB_INCLUDES . '/Admin.php';
        // }
        if ( $this->is_request( 'frontend' ) ) {
            require_once FFB_INCLUDES . '/Frontend.php';
        }

        if ( $this->is_request( 'ajax' ) ) {}
    }

    /**
     * Initialize the hooks
     *
     * @return void
     */
    public function init_hooks() {

        add_action( 'init', array( $this, 'init_classes' ) );

        // Localize our plugin
        add_action( 'init', array( $this, 'localization_setup' ) );
    }

    public function ffb_wpdb_tables() {
        global $wpdb;

        // Tables
        $table_name = $wpdb->prefix . $this->fluent_features_board;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title text NOT NULL,
        logo text NOT NULL,
        sort_by text NOT NULL,
        show_upvotes text NOT NULL,
        visibility text NOT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate;";


        // Tables
        $ffr_table_name = $wpdb->prefix . $this->ff_requests_list;
        // $charset_collate = $wpdb->get_charset_collate();

        $sql2 = "CREATE TABLE $ffr_table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        post_author int NOT NULL,
        title text NOT NULL,
        description text NOT NULL,
        status text NOT NULL,
        parent_id int NOT NULL,
        is_public text NOT NULL,
        comments_count int NOT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate;";


        // Tables
        $ffr_tags_table = $wpdb->prefix . $this->ffr_tags;
        // $charset_collate = $wpdb->get_charset_collate();

        $sql3 = "CREATE TABLE $ffr_tags_table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name text NOT NULL,
        slug text NOT NULL,
        board_id int NOT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate;";


        // Tables
        $ffr_comments_table = $wpdb->prefix . $this->ffr_comments;

        $sql4 = "CREATE TABLE $ffr_comments_table (
        id bigint NOT NULL AUTO_INCREMENT,
        comment_post_ID bigint NOT NULL,
        comment_author tinytext NOT NULL,
        comment_author_email varchar(100) NULL,
        comment_author_url varchar(200) NULL,
        comment_author_IP varchar(100) NULL,
        comment_date datetime NOT NULL,
        comment_content text NOT NULL,
        comment_user_id bigint NOT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        // require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql2 );
        dbDelta( $sql3 );
        dbDelta( $sql4 );
    }

    /**
     * Instantiate the required classes
     *
     * @return void
     */
    public function init_classes() {

        // Model Table
        $this->container['model_table'] = new FFB\FFB_Model_Table();

        // Admin
        if ( $this->is_request( 'admin' ) ) {
            $this->container['admin'] = new FFB\FFB_Admin();
        }

        // Frontend Render
        if ( $this->is_request( 'frontend' ) ) {
            $this->container['frontend'] = new FFB\Frontend();
        }

        // Ajax
        if ( $this->is_request( 'ajax' ) ) {}

        // Assets
        $this->container['assets'] = new FFB\FFB_Assets();

        // Shortcodes
        $this->container['hooks'] = new FFB\Shortcodes();
    }

    /**
     * Initialize plugin for localization
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'fluent-features-board', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    private function is_request( $type ) {
        switch ( $type ) {
            case 'admin' :
                return is_admin();

            case 'ajax' :
                return defined( 'DOING_AJAX' );

            case 'rest' :
                return defined( 'REST_REQUEST' );

            case 'cron' :
                return defined( 'DOING_CRON' );

            case 'frontend' :
                return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );

        }
    }

} // Fluent_Features_board

$fluent_features_board = Fluent_Features_board::init();
