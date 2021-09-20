<?php
namespace FFB;
// if (!defined('ABSPATH')) {
//     exit; // Exit if accessed directly
// }

class FFB_Model_Table {
    public $table_name = 'ff_board';

    public function __construct()
    {
        add_action( 'plugins_loaded', [$this, 'ffb_list_table'] );
    }

    public function ffb_list_table() {
        global $wpdb;

        // Tables
        $table_name = $wpdb->prefix . "fluent_features_board";
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title tinytext NOT NULL,
        description text NOT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        $wpdb->insert( 
            $table_name, 
            array( 
                'title' =>  'title 2', 
                'description' => 'this is a short description', 
            ) 
        );
    }
    

}
