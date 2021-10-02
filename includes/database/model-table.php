<?php
namespace FFB;

use Error;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class FFB_Model_Table {
    public $fluent_features_board = 'fluent_features_board';
    public $ff_requests_list = 'ff_requests_list';
    public $ffr_tags = 'ffr_tags';

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
        add_action( 'wp_ajax_submit_feature_request', [$this, 'submit_feature_request'] );
        add_action( 'wp_ajax_nopriv_submit_feature_request', [$this, 'submit_feature_request'] );
        add_action( 'wp_ajax_get_feature_requests_list', [$this, 'get_feature_requests_list'] );
        add_action( 'wp_ajax_nopriv_get_feature_requests_list', [$this, 'get_feature_requests_list'] );
        add_action( 'wp_ajax_getAllFeatureRequests', [$this, 'getAllFeatureRequests'] );
        add_action( 'wp_ajax_nopriv_getAllFeatureRequests', [$this, 'getAllFeatureRequests'] );
        
    }

    /**
     * Creating Table
     */
    public function ffb_tables_list() {
        
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
        $logo = (isset($_POST['logo']) ? $_POST['logo'] : '');
        $sort_by = (isset($_POST['sort_by']) ? $_POST['sort_by'] : '');
        $show_upvotes = (isset($_POST['show_upvotes']) ? $_POST['show_upvotes'] : '');
        $visibility = (isset($_POST['visibility']) ? $_POST['visibility'] : '');

        $wpdb->insert(
            $table_name,
            array( 
                'title' =>  $title,
                'logo' =>  $logo,
                'sort_by' => $sort_by,
                'show_upvotes' => $show_upvotes,
                'visibility' => $visibility,
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
        $logo = (isset($_POST['logo']) ? $_POST['logo'] : '');
        $sort_by = (isset($_POST['sort_by']) ? $_POST['sort_by'] : '');
        $show_upvotes = (isset($_POST['show_upvotes']) ? $_POST['show_upvotes'] : '');
        $visibility = (isset($_POST['visibility']) ? $_POST['visibility'] : '');
        $table_name = $wpdb->prefix . $this->fluent_features_board;
        $where = [ 'id' => $id ];
        $wpdb->update( 
            $table_name, 
            array( 
                'title'        => $title,
                'logo'         => $logo,
                'sort_by'      => $sort_by,
                'show_upvotes' => $show_upvotes,
                'visibility'   => $visibility,
            ), 
            $where 
        );
        die();
    }


    /**
     * Inserting New Feature Request
     */
    public function submit_feature_request() {
        global $wpdb;
        $table_tag  = $wpdb->prefix . $this->ffr_tags;
        $table_ffr  = $wpdb->prefix . $this->ff_requests_list;
        $id          = (isset($_POST['id']) ? $_POST['id'] : '');
        $title       = (isset($_POST['title']) ? $_POST['title'] : '');
        $description = (isset($_POST['description']) ? $_POST['description'] : '');
        $tags        = (isset($_POST['tags']) ? $_POST['tags'] : '');
        $status      = (isset($_POST['status']) ? $_POST['status'] : '');
        $is_public   = (isset($_POST['is_public']) ? $_POST['is_public'] : '');

        $wpdb->insert(
            $table_ffr,
            array( 
                'title'       =>  $title,
                'description' =>  $description,
                'status' =>  $status,
                'parent_id' => $id,
                'is_public' =>  $is_public,
            ) 
        );

        foreach( $tags as $tag) {
            $tagSlug = strtolower(str_replace(' ', '-', $tag));
            $wpdb->insert(
                $table_tag,
                array( 
                    'name'     =>  $tag,
                    'slug'     =>  $tagSlug,
                    'board_id' => $id,
                ) 
            );
        }
    }

    // Getting all requests list by related board
    public function get_feature_requests_list() {
        global $wpdb;
        $post_id          = (isset($_POST['id']) ? $_POST['id'] : '');
        $feature_request_lists = $wpdb->get_results(
            "SELECT * FROM {$wpdb->prefix}ff_requests_list WHERE parent_id = {$post_id}"
        );
        
        if( is_wp_error( $feature_request_lists ) ) {
            return false;
        }
        wp_send_json_success( $feature_request_lists, 200 ); 
        die();
    }


    /**
     * Getting All Feature Requests
     */
    public function getAllFeatureRequests() {
        global $wpdb;
        $requests = $wpdb->get_results(
            "SELECT * FROM {$wpdb->prefix}ff_requests_list"
        );
        if( is_wp_error( $requests ) ) {
            return false;
        }
        wp_send_json_success( $requests, 200 ); 
        die();
    }
    

}
