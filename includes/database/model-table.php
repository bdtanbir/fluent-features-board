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
    }

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

    public function ffb_admin_scripts() {
        wp_enqueue_script( 'ffb', FFB_ASSETS .'/js/fluent-features-board.js', null, FFB_VERSION, true );
        wp_localize_script( 'ffb', 'ajax_url', array(
            'ajaxurl' => admin_url('admin-ajax.php')
        ));
    }


    public function action_ffb_callback() {
        global $wpdb;
        // Tables
        $table_name = $wpdb->prefix . $this->fluent_features_board;

        $title = (isset($_POST['title']) ? $_POST['title'] : '');
        $description = (isset($_POST['description']) ? $_POST['description'] : '');
        $tags = (isset($_POST['tags']) ? $_POST['tags'] : '');

        error_log($title . $description . $tags);
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
    

}
