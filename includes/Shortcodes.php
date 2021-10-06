<?php

namespace FFB;

/**
 * Shortcodes Handler
 */
class Shortcodes {
    public $current_requestId = '';

    public function __construct() {
        
        add_shortcode( 'fluent_features_board', [$this, 'ffb_shortcode'] );
        add_action( 'wp_ajax_ff_request_single_callback', [$this, 'ff_request_single_callback'] );
        add_action( 'wp_ajax_nopriv_ff_request_single_callback', [$this, 'ff_request_single_callback'] );
        
    }

	public function ffb_shortcode( $atts = []) {
        if (!is_admin()) {
            require_once FFB_INCLUDES . '/layout/user-login.php';
        }
        global $wpdb;
        $atts = array_change_key_case((array) $atts, CASE_LOWER);
        $ffb_atts = shortcode_atts( 
            array(
                'id'    => ''
            ), $atts
        );
    
        if(!empty($ffb_atts['id'])) {
            $current_feature_board = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."fluent_features_board WHERE id=".$ffb_atts['id']);

            // if(is_user_logged_in(  )) {
                global $current_user;
                wp_get_current_user();
                // $useremail = $current_user->user_email;
                // $username = $current_user->user_login;
                // $firstname = $current_user->user_firstname;
                // $lastname = $current_user->user_lastname;
                // $userid = $current_user->id;
                // $userrole = $current_user->roles;

            // }

            foreach($current_feature_board as $board) {
                if ($board->sort_by == 'upvotes') {
                    $sort_by = '';
                } elseif ($board->sort_by == 'alphabetical') {
                    $sort_by = ' ORDER BY title';
                } elseif ($board->sort_by == 'comments') {
                    $sort_by = ' ORDER BY comments_count';
                } else {
                    $sort_by = '';
                }
                $form = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ff_requests_list WHERE parent_id=".$ffb_atts['id'].$sort_by);
                $col = '<div class="ff-requests-list-home">';

                $col .= '<header>';
                $col .= '<div class="ffr-wrap">';
                $col .= '<div class="header-left">';
                $col .= '<img src="'.$board->logo.'" alt="">';
                $col .= '<div class="header-left-content">';
                $col .= '<h3><a href="">'.$board->title.'</a></h3>';
                $col .= '<div class="links">';
                $col .= '<a href="https://adreastrian.com/">'.esc_html__('AuthLab Homepage', 'fluent-features-board').'</a>';
                $col .= '</div>';
                $col .= '</div>';
                $col .= '</div>';
                $col .= '<div class="header-right">';

                $col .= '<ul>';
                if(!is_user_logged_in(  )) {
                    $col .= '<li><a class="user-login user-in" id="ffr-login-register-popup" href="#">'.esc_html__('Login', 'fluent-features-board').'</a></li>';
                } else {
                    $col .= '<li class="user-logout user-out">';
                    $col .= '<a href="#">';
                    $col .= esc_html__('Hi, ', 'fluent-features-board').$current_user->display_name.' <span class="downicon"></span>';
                    $col .= '</a>';
                    $col .= '<div class="user-logout-dropdown">';
                    $col .= '<a class="user-logout" href="'.wp_logout_url( home_url() ).'">';
                    $col .= '<span class="logout-power-icon"></span> '.esc_html__('Logout', 'fluent-features-board');
                    $col .= '</a>';
                    $col .= '</div>';
                    $col .= '</li>';
                }
                $col .= '</ul>';

                $col .= '</div>';
                $col .= '</div>';
                $col .= '</header>';
                
                $col .= '<div class="ff-request-list-inner">';
                $col .= '<div class="ff-requests-wrapper">';
                $col .= '<div class="ffr-wrap">';

                $col .= '<div class="ff-requests-header">';
                $col .= '<div class="d-flex">';
                $col .= '<button class="ff-addnewrequest">';
                $col .= esc_html__('New Feature Request', 'fluent-features-board');
                $col .= '</button>';
                $col .= '<div class="ff-requests-search">';
                $col .= '<input id="search-request" type="text" name="search" placeholder="'.esc_attr__('Search feature requests', 'fluent-features-board').'">';
                $col .= '</div>';
                $col .= '</div>';

                $col .= '<div class="ff-requests-form-wrap">';
                    $col .= '<form class="ff-requests-form" id="ff-request-frontend-form">';
                        if(is_user_logged_in(  )) {
                            $col .= '<p class="thankyou">Thank You for submitting!</p>';
                            $col .= '<h1>'.esc_html__('Suggest new feature', 'fluent-features-board').'</h1>';
                            $col .= '<div class="input-group">';
                            $col .= '<input id="search-request" type="text" name="title" placeholder="'.esc_attr__('Title', 'fluent-features-board').'" required>';
                            $col .= '</div>';
                            $col .= '<div class="input-group">';
                            $col .= '<textarea name="description" id="description" placeholder="'.esc_html__('Why do you want this', 'fluent-features-board').'" required></textarea>';
                            $col .= '</div>';
                            $col .= '<div class="input-group">';
                            $col .= '<button class="ff-request-submit">';
                            $col .= '<span class="loader"></span>'.esc_html__('Suggest Feature', 'fluent-features-board');
                            $col .= '</button>';
                            $col .= '</div>';
                            $col .= '<input type="hidden" value="'.$board->id.'" id="parent_board_id" />';
                        } else {
                            $col .= '<h2 class="user-not-loggedin">Login/Register to submit feature request. <a href="#" id="ffr-login-register-popup">Login/Register</a></h2>';
                        }
                        $col .= '</form>';
                    $col .= '</div>';
                $col .= '</div>';

                $col .= '<div class="ff-requests-list-box">';
                $col .= '<p>('.count($form).') '.esc_html__('feature requests', 'fluent-features-board').'</p> ';
                $col .= '<div class="ff-requests-list-body">';

                // Request Details Modal
                $col .= '<div class="ff-request-item-details-wrap" >';
                    $col .= '<div class="ff-request-item-details-content">';
                        $col .= '<h1 class="ff-request-title">1st title - UPD</h1>';
                        $col .= '<h2 class="ff-request-author">'.get_avatar( get_the_author_meta( 'ID' ), 32 ).get_the_author().'</h2>';
                        $col .= '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,</p>';

                        // Comments List
                        $col .= '<div class="ff-request-comments-list">';
                            $col .= '<ul class="ff-request-comment">';
                                $col .= '<li>';
                                    $col .= '<h2 class="ff-request-comment-author">';
                                        $col .= get_avatar( get_the_author_meta('ID'), 32).get_the_author();
                                    $col .= '</h2>';
                                    $col .= '<p class="ff-request-comment-content">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s
                                    </p>';
                                $col .= '</li>';
                            $col .= '</ul>';
                        $col .= '</div>';


                        $col .= '<form class="ff-request-comment-form" id="ff-request-comment-form">';
                            $col .= '<input type="hidden" name="comment_post_id" value="1"/>';
                            if(is_user_logged_in(  )) {
                                $col .= '<div class="input-group">';
                                    $col .= '<textarea name="comment" placeholder="Leave A Comment" required></textarea>';
                                $col .= '</div>';

                                $col .= '<div class="input-group submit-comment">';
                                    $col .= '<button>Submit</button>';
                                $col .= '</div>';
                            } else {
                                $col .= '<div class="not-loggedin">';
                                    $col .= '<h1>Login to submit a comment. <a id="ffr-login-register-popup" href="#">Login</a></h1>';
                                $col .= '</div>';
                            }
                        $col .= '</form>';
                    $col .= '</div>';
                $col .= '</div>';

                foreach($form as $item) {
                    $status = strtolower(str_replace(' ', '-', $item->status));
                    if($item->status == 'inprogress') {
                        $status_text = "In Progress";
                    } elseif($item->status == 'planned') {
                        $status_text = "Planned";
                    } elseif($item->status == 'closed') {
                        $status_text = "Closed";
                    } else {
                        $status_text = "Shipped";
                    }


                    $col .= '<div class="ff-request-item" data-name="'.$item->title.'">';


                        if($board->show_upvotes == 'yes') {
                            $col .= '<div class="ff-request-vote">';
                                $col .= '<span class="ff-request-vote-btn"></span>';
                                $col .= '<span class="ff-request-vote-count">10</span>';
                            $col .= '</div>';
                        }
                        $col .= '<div class="ff-request-content">';
                            $col .= '<h3>';
                                $col .= '<a href="#" data-id="'.$item->id.'">';
                                    $col .= esc_html($item->title);
                                $col .= '</a>';
                                if($item->post_author == $current_user->ID) {
                                    $col .= '<span class="user-action"><a href="">Edit</a>|<a id="delete-feature-request" href="#" data-id="'.$item->id.'">Delete</a></span>';
                                }
                            $col .= '</h3>';
                            if($item->status) {
                                $col .= '<p class="status"><span class="'.esc_attr($status).'">'.esc_html($status_text).'</span></p>';
                            }
                            $col .= '<p class="description">'.esc_html($item->description).'</p>';
                        $col .= '</div>';
                        $col .= '<a href="" class="ff-request-comment-count">';
                        $col .= '<span class="comment-icon"></span>';
                        $col .= '<span class="comment-number">10</span>';
                        $col .= '</a>';
                    $col .= '</div>';
                }

                $col .= '</div>';
                $col .= '</div>';
                            
                $col .= '</div>';
                $col .= '</div>';
                $col .= '</div>';
                $col .= '</div>';
            }
            return $col;
        }

    }

    public function ff_request_single_callback() {
        global $wpdb;
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $this->current_requestId = $id;

        
    }

}

