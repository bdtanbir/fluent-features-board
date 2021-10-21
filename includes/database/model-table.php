<?php
namespace FFB;


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class FFB_Model_Table {
    public $fluent_features_board = 'fluent_features_board';
    public $ff_requests_list      = 'ff_requests_list';
    public $ffr_tags              = 'ffr_tags';
    public $ffr_comments          = 'ffr_comments';
    public $ffr_votes             = 'ffr_votes';

    public function __construct()
    {
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
        add_action( 'wp_ajax_getAllBoardsList', [$this, 'getAllBoardsList'] );
        add_action( 'wp_ajax_nopriv_getAllBoardsList', [$this, 'getAllBoardsList'] );
        add_action( 'wp_ajax_sortFeaturesRequests', [$this, 'sortFeaturesRequests'] );
        add_action( 'wp_ajax_nopriv_sortFeaturesRequests', [$this, 'sortFeaturesRequests'] );        
        add_action( 'wp_ajax_getTagsByCurrentRequest', [$this, 'getTagsByCurrentRequest'] );
        add_action( 'wp_ajax_nopriv_getTagsByCurrentRequest', [$this, 'getTagsByCurrentRequest'] );
        add_action( 'wp_ajax_updateFeatureRequestList', [$this, 'updateFeatureRequestList'] );
        add_action( 'wp_ajax_nopriv_updateFeatureRequestList', [$this, 'updateFeatureRequestList'] );
        add_action( 'wp_ajax_action_deleteFeatureRequestRow', [$this, 'action_deleteFeatureRequestRow'] );
        add_action( 'wp_ajax_nopriv_action_deleteFeatureRequestRow', [$this, 'action_deleteFeatureRequestRow'] );
        add_action( 'wp_ajax_submit_new_comment_action', [$this, 'submit_new_comment_action'] );
        add_action( 'wp_ajax_nopriv_submit_new_comment_action', [$this, 'submit_new_comment_action'] );
        add_action( 'wp_ajax_addVotesOnRequestList', [$this, 'addVotesOnRequestList'] );
        add_action( 'wp_ajax_nopriv_addVotesOnRequestList', [$this, 'addVotesOnRequestList'] );
        add_action( 'wp_ajax_removeVotesOnRequestList', [$this, 'removeVotesOnRequestList'] );
        add_action( 'wp_ajax_nopriv_removeVotesOnRequestList', [$this, 'removeVotesOnRequestList'] );
        add_action( 'wp_ajax_ffr_deleteComment', [$this, 'ffr_deleteComment'] );
        add_action( 'wp_ajax_nopriv_ffr_deleteComment', [$this, 'ffr_deleteComment'] );
        add_action( 'wp_ajax_ffrEditFromFrontend', [$this, 'ffrEditFromFrontend'] );
        add_action( 'wp_ajax_nopriv_ffrEditFromFrontend', [$this, 'ffrEditFromFrontend'] );
        
        
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
        $table_name   = $wpdb->prefix . $this->fluent_features_board;
        $title        = sanitize_text_field((isset($_POST['title']) ? $_POST['title'] : ''));
        $logo         = (isset($_POST['logo']) ? $_POST['logo'] : '');
        $sort_by      = (isset($_POST['sort_by']) ? $_POST['sort_by'] : '');
        $show_upvotes = (isset($_POST['show_upvotes']) ? $_POST['show_upvotes'] : '');
        $visibility   = (isset($_POST['visibility']) ? $_POST['visibility'] : '');

        $wpdb->insert(
            $table_name,
            array( 
                'title'        =>  $title,
                'logo'         =>  $logo,
                'sort_by'      => $sort_by,
                'show_upvotes' => $show_upvotes,
                'visibility'   => $visibility,
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
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $wpdb->delete( $table_name, array( 'id' => $id ) );
        die();
    }


    /**
     * Updating Table's row
     */
    public function update_fluent_features_board() {
        global $wpdb;
        $id           = (isset($_POST['id']) ? $_POST['id'] : '');
        $title        = sanitize_text_field((isset($_POST['title']) ? $_POST['title'] : ''));
        $logo         = (isset($_POST['logo']) ? $_POST['logo'] : '');
        $sort_by      = (isset($_POST['sort_by']) ? $_POST['sort_by'] : '');
        $show_upvotes = (isset($_POST['show_upvotes']) ? $_POST['show_upvotes'] : '');
        $visibility   = (isset($_POST['visibility']) ? $_POST['visibility'] : '');
        $table_name   = $wpdb->prefix . $this->fluent_features_board;
        $where        = [ 'id' => $id ];
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
        // Check for nonce security      
        if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
            die ( 'Busted!');
        }
        global $wpdb;
        global $current_user;
        $table_ffr   = $wpdb->prefix . $this->ff_requests_list;
        $id          = (isset($_POST['id']) ? $_POST['id'] : '');
        $title       = sanitize_text_field((isset($_POST['title']) ? $_POST['title'] : ''));
        $description = sanitize_textarea_field((isset($_POST['description']) ? $_POST['description'] : ''));
        $status      = (isset($_POST['status']) ? $_POST['status'] : '');
        $is_public   = (isset($_POST['is_public']) ? $_POST['is_public'] : 'true');

        $wpdb->insert(
            $table_ffr,
            array( 
                'title'       => $title,
                'description' => $description,
                'status'      => $status,
                'parent_id'   => $id,
                'is_public'   => $is_public,
                'post_author' => $current_user->ID,
            ) 
        );
        die();

    }

    // Getting all requests list by related board
    public function get_feature_requests_list() {
        global $wpdb;
        $post_id = (isset($_POST['id']) ? $_POST['id'] : '');
        $sort_by = (isset($_POST['sort_by']) ? $_POST['sort_by'] : '');
        if ($sort_by == 'upvotes') {
            $sorting = 'ORDER BY votes_count DESC';
        } elseif ($sort_by == 'alphabetical') {
            $sorting = ' ORDER BY title';
        } elseif ($sort_by == 'comments') {
            $sorting = ' ORDER BY comments_count DESC';
        } else {
            $sorting = '';
        }
        $feature_request_lists = $wpdb->get_results(
            "SELECT * FROM {$wpdb->prefix}ff_requests_list WHERE parent_id = {$post_id} {$sorting}"
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


    /**
     * Get All Boards List
     */
    public function getAllBoardsList() {
        global $wpdb;
        $sort_by = isset($_POST['sort_by']) ? $_POST['sort_by'] : '';
        if($sort_by == 'all') {
            error_log('I am All');
        }
        error_log(print_r($sort_by, 1));
        
        $requests = $wpdb->get_results(
            "SELECT * FROM {$wpdb->prefix}fluent_features_board"
        );
        if(is_wp_error( $requests )) {
            return false;
        }

        wp_send_json_success( $requests, 200 );
        die();
    }

    /**
     * Sorting Requests List
     */
    public function sortFeaturesRequests() {
        global $wpdb;
        $sort_by = isset($_POST['sort_by']) ? $_POST['sort_by'] : '';

        if($sort_by == 'all') {
            $requests = $wpdb->get_results(
                "SELECT * FROM {$wpdb->prefix}ff_requests_list"
            );
            if(is_wp_error( $requests )) {
                return false;
            }
        } else {
            $requests = $wpdb->get_results(
                "SELECT * FROM {$wpdb->prefix}ff_requests_list WHERE parent_id={$sort_by}"
            );
            if(is_wp_error( $requests )) {
                return false;
            }
        }
        wp_send_json_success( $requests, 200 );
        die();
    }


    /**
     * Updating Feature Request List
     */
    public function updateFeatureRequestList() {
        global $wpdb;
        $table_tag   = $wpdb->prefix . $this->ffr_tags;
        $table_ffr   = $wpdb->prefix . $this->ff_requests_list;
        $id          = (isset($_POST['id']) ? $_POST['id'] : '');
        $parent_id   = (isset($_POST['parent_id']) ? $_POST['parent_id'] : '');
        $title       = sanitize_text_field((isset($_POST['title']) ? $_POST['title'] : ''));
        $description = sanitize_textarea_field((isset($_POST['description']) ? $_POST['description'] : ''));
        $status      = (isset($_POST['status']) ? $_POST['status'] : '');
        $is_public   = (isset($_POST['is_public']) ? $_POST['is_public'] : '');
        $tags        = (isset($_POST['tags']) ? $_POST['tags'] : '');
        $tagIdDelete = (isset($_POST['tagIdDelete']) ? $_POST['tagIdDelete'] : '');
        $where       = ['id' => $id];

        // Update ff_requests_list Table
        $wpdb->update( 
            $table_ffr,
            array( 
                'title'       => $title,
                'description' => $description,
                'status'      => $status,
                'parent_id'   => $parent_id,
                'is_public'   => $is_public,
                'parent_id'   => $parent_id
            ),
            $where
        );

        // Delete Tags
        if($tagIdDelete) {
            foreach($tagIdDelete as $tagid) {
                $wpdb->delete( $table_tag, array( 'id' => $tagid ) );
            }
        }


        // Insert New Tags
        if(!empty($tags)) {
            foreach( $tags as $tag) {
                $tagid = $tag['id'];

                $tagCheck = "SELECT * FROM `$table_tag` WHERE id='$tagid'";
                $result = $wpdb->query($tagCheck);

                if(!$result) {
                    $wpdb->insert(
                        $table_tag,
                        array( 
                            'name'     => sanitize_text_field($tag['name']),
                            'slug'     => $tag['slug'],
                            'board_id' => $id,
                        ) 
                    );
                }
            }
        }
        die();
        
    }


    /**
     * Getting Current Request List's Tags
     */
    public function getTagsByCurrentRequest() {
        global $wpdb;
        $post_id    = (isset($_POST['id']) ? $_POST['id'] : '');
        $table_tag  = $wpdb->prefix . $this->ffr_tags;
        $ffr_tags   = $wpdb->get_results(
            "SELECT * FROM {$table_tag} WHERE board_id = {$post_id}"
        );

        if( is_wp_error( $ffr_tags ) ) {
            return false;
        }
        wp_send_json_success( $ffr_tags, 200 );
        die();
    }


    /**
     * Deleting Feature Request Row
     */
    public function action_deleteFeatureRequestRow() {
        // Check for nonce security      
        if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
            die ( 'Busted!');
        }
        global $wpdb;
        $table_name = $wpdb->prefix . $this->ff_requests_list;
        $id    = (isset($_POST['id']) ? $_POST['id'] : '');
        if(is_wp_error( $id )) {
            echo json_encode(array(
                'status'  => false,
                'message' => esc_html__( 'Something went wrong!', 'fluent-features-board' )
            ));
            return false;
        }
        echo json_encode(array(
            'status'  => true,
            'message' => esc_html__( 'Request has been deleted', 'fluent-features-board' )
        ));
        $wpdb->delete( $table_name, array( 'id' => $id ) );
        die();
    }


    /**
     * Inserting Feature Requests Comments
     */
    public function submit_new_comment_action() {
        if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
            die ( 'Busted!');
        }
        global $wpdb;
        if(is_user_logged_in(  )) {
            global $current_user;
            $comment_post_id = isset($_POST['comment_post_id']) ? $_POST['comment_post_id'] : '';
            $comment_content = sanitize_textarea_field(isset($_POST['comment_content']) ? $_POST['comment_content'] : '');
            $comment_date    = date(get_option('date_format'));

            $data = [
                'content' => $comment_content,
                'message' => esc_html__('Success!', 'fluent-features-board')
            ];

            if(is_wp_error( $data) ) {
                return false;
            }
            echo json_encode( $data );

            $ffr_comments = $wpdb->prefix . $this->ffr_comments;
            $wpdb->insert(
                $ffr_comments,
                array( 
                    'comment_post_id'      =>  $comment_post_id,
                    'comment_author'       =>  $current_user->display_name,
                    'comment_content'      =>  $comment_content,
                    'comment_date'         =>  $comment_date,
                    'comment_author_email' =>  $current_user->user_email,
                    'comment_author_url'   =>  $current_user->user_url,
                    'comment_author_IP'    =>  '',
                    'comment_user_id'      =>  $current_user->ID,
                ) 
            );

        }
        die();
    }


    /**
     * Adding Votes
     */
    public function addVotesOnRequestList() {
        // Check for nonce security      
        if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
            die ( 'Busted!');
        }
        global $wpdb;
        global $current_user;
        $post_id = (isset($_POST['post_id'])) ? $_POST['post_id'] : '';
        $votes   = (isset($_POST['votes'])) ? $_POST['votes'] : '';

        $ffr_votes = $wpdb->prefix . $this->ffr_votes;

        $voteCheck = "SELECT * FROM `$ffr_votes` WHERE vote_user_id='$current_user->ID' AND post_id='$post_id'";
        $result    = $wpdb->query($voteCheck);
        if(!$result) {
            $sql = $wpdb->prepare("INSERT INTO `$ffr_votes` (`post_id`, `vote_user_id`, `votes_count`) values (%s, %s, %s)", $post_id, $current_user->ID, $votes);
            $wpdb->query($sql);


            $table_ffr  = $wpdb->prefix . $this->ff_requests_list;
            $where      = ['id' => $post_id];

            $wpdb->update( 
                $table_ffr,
                array( 
                    'votes_count' => $votes
                ),
                $where
            );
        }
        die();
    }


    /**
     * Remove Vote by ajax
     */
    public function removeVotesOnRequestList() {
        // Check for nonce security      
        if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
            die ( 'Busted!');
        }
        global $wpdb;
        global $current_user;
        $table_ffr = $wpdb->prefix . $this->ff_requests_list;
        $ffr_votes = $wpdb->prefix . $this->ffr_votes;
        $post_id   = isset($_POST['post_id']) ? $_POST['post_id'] : '';
        $votes     = isset($_POST['votes']) ? $_POST['votes'] : '';

        $where     = ['id' => $post_id];

        $wpdb->update( 
            $table_ffr,
            array( 
                'votes_count' => $votes
            ),
            $where
        );

        $wpdb->delete( $ffr_votes, array( 'vote_user_id' => $current_user->ID, 'post_id' => $post_id ) );
        die();
    }


    /**
     * Delete Comment
     */
    public function ffr_deleteComment() {
        // Check for nonce security      
        if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
            die ( 'Busted!');
        }
        global $wpdb;
        $comment_id    = isset($_POST['comment_id']) ? $_POST['comment_id'] : '';
        $table_name    = $wpdb->prefix . $this->ffr_comments;
        $deleteComment = $wpdb->get_results("SELECT * FROM `$table_name` WHERE id='$comment_id'");
        if(is_wp_error( $deleteComment )) {
            echo json_encode(
                array(
                    'status'  => false,
                    'message' => esc_html__('Something went wrong!', 'fluent-features-board')
                )
            );
            return false;
        } else {
            $wpdb->delete( $table_name, array( 'id' => $comment_id ) );
            echo json_encode(
                array(
                    'status'  => true,
                    'message' => esc_html__('Comment has been Deleted.', 'fluent-features-board')
                )
            );
        }
        die();
    }


    /**
     * Update Feature Request From Frontend
     */
    public function ffrEditFromFrontend() {
        // Check for nonce security      
        if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
            die ( 'Busted!');
        }
        global $wpdb;
        $table_ffr = $wpdb->prefix . $this->ff_requests_list;
        $boardId   = isset($_POST['board_id']) ? $_POST['board_id'] : '';
        $requestID = isset($_POST['request_id']) ? $_POST['request_id'] : '';
        $title     = sanitize_text_field( isset($_POST['title']) ? $_POST['title'] : '' );
        $content   = sanitize_textarea_field( isset($_POST['content']) ? $_POST['content'] : '' );
        $where     = ['id' => $requestID, 'parent_id' => $boardId];

        if(is_wp_error( $title ) || is_wp_error( $content )) {
            echo json_encode(array(
                'status'  => false,
                'message' => esc_html__('Something went wrong!', 'fluent-features-board')
            ));
            return false;
        }
        echo json_encode(array(
            'status'  => true,
            'message' => esc_html__('Request has been updated!', 'fluent-features-board')
        ));


        $wpdb->update( 
            $table_ffr,
            array( 
                'title'       => $title,
                'description' => $content
            ),
            $where
        );

        die();
    }
    
}
