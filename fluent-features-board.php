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

    /**
     * Include the required files
     *
     * @return void
     */
    public function includes() {

        require_once FFB_INCLUDES . '/database/model-table.php';
        require_once FFB_INCLUDES . '/Assets.php';
        require_once FFB_INCLUDES . '/Shortcodes.php';
        if (!is_admin()) {
            require_once FFB_INCLUDES . '/layout/user-login.php';
        }

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

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        // require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql2 );
        dbDelta( $sql3 );
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
