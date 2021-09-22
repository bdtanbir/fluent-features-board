<?php
namespace FFB;
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class FFB_Model_Table {
    public $fluent_features_board = 'fluent_features_board';

    public function __construct()
    {
        add_action( 'plugins_loaded', [$this, 'ffb_tables_list'] );
        add_action( 'admin_enqueue_scripts', [$this, 'ffb_admin_scripts'] );
        add_action( 'wp_ajax_action_ffb_callback', [$this, 'action_ffb_callback'] );
        add_action( 'wp_ajax_nopriv_action_ffb_callback', [$this, 'action_ffb_callback'] );
        add_action( 'wp_ajax_get_ffb_lists', [$this, 'get_ffb_lists'] );
        add_action( 'wp_ajax_nopriv_get_ffb_lists', [$this, 'get_ffb_lists'] );
        add_action( 'wp_ajax_delete_ffb_table_column', [$this, 'delete_ffb_table_column'] );
        add_action( 'wp_ajax_nopriv_delete_ffb_table_column', [$this, 'delete_ffb_table_column'] );
        add_action( 'wp_ajax_update_fluent_features_board', [$this, 'update_fluent_features_board'] );
        add_action( 'wp_ajax_nopriv_update_fluent_features_board', [$this, 'update_fluent_features_board'] );
    }

    /**
     * Creating Table
     */
    public function ffb_tables_list() {
        global $wpdb;

        // Tables
        $table_name = $wpdb->prefix . $this->fluent_features_board;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title text NOT NULL,
        tags text NOT NULL,
        description text NOT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

    /**
     * FFB Global Admin Scripts
     */
    public function ffb_admin_scripts() {
        wp_enqueue_script( 'ffb', FFB_ASSETS .'/js/fluent-features-board.js', null, FFB_VERSION, true );
        wp_localize_script( 'ffb', 'ajax_url', array(
            'ajaxurl' => admin_url('admin-ajax.php')
        ));
    }


    /**
     * Inserting Data
     */
    public function action_ffb_callback() {
        global $wpdb;
        // Tables
        $table_name = $wpdb->prefix . $this->fluent_features_board;

        $title = (isset($_POST['title']) ? $_POST['title'] : '');
        $description = (isset($_POST['description']) ? $_POST['description'] : '');
        $tags = (isset($_POST['tags']) ? $_POST['tags'] : '');

        $wpdb->insert(
            $table_name,
            array( 
                'title' =>  $title, 
                'description' => $description,
                'tags' => $tags,
            ) 
        );

        die();
    }

    /**
     * Fetching Table's data from mysql
     */
    public function get_ffb_lists() {
        global $wpdb;

        $request = $wpdb->get_results(
            "SELECT * FROM {$wpdb->prefix}fluent_features_board"
        );
        if( is_wp_error( $request ) ) {
            return false;
        }
        wp_send_json_success( $request, 200 ); 

        die();
    }

    /**
     * Deleting Table's row
     */
    public function delete_ffb_table_column() {
        global $wpdb;
        $table_name = $wpdb->prefix . $this->fluent_features_board;
        $id = $_POST['id'];
        $wpdb->delete( $table_name, array( 'id' => $id ) );
        die();
    }


    /**
     * Updating Table's row
     */
    public function update_fluent_features_board() {
        global $wpdb;
        $id = (isset($_POST['id']) ? $_POST['id'] : '');
        $title = (isset($_POST['title']) ? $_POST['title'] : '');
        $tags = (isset($_POST['tags']) ? $_POST['tags'] : '');
        $description = (isset($_POST['description']) ? $_POST['description'] : '');

        $table_name = $wpdb->prefix . $this->fluent_features_board;
        $data = [ 'title' => $title, 'tags' => $tags, 'description' => $description ]; // NULL value.
        $where = [ 'id' => $id ];
        $wpdb->update( $table_name, $data, $where );
        die();
    }
    

}
