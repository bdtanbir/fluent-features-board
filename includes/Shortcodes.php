<?php

namespace FFB;

/**
 * Shortcodes Handler
 */
class Shortcodes {
    public $current_requestId = '';

    public function __construct() {
        
        add_shortcode( 'fluent_features_board', [$this, 'ffb_shortcode'] );
        
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

            global $current_user;

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
                if(is_user_logged_in() && $current_user->roles[0] == 'administrator') {
                    $show_all_requests = "";
                    $is_administrator = 'administrator';
                } else {
                    $show_all_requests = " and is_public='true' ";
                    $is_administrator = '';
                }

                $form = $wpdb->get_results(
                    "SELECT * FROM ".$wpdb->prefix."ff_requests_list WHERE parent_id=".$ffb_atts['id'].$show_all_requests.$sort_by
                );
                $col = '<div class="ff-requests-list-home">';

                $col .= '<header>';
                $col .= '<div class="ffr-wrap">';
                $col .= '<div class="header-left">';
                $col .= '<img src="'.$board->logo.'" alt="">';
                $col .= '<div class="header-left-content">';
                $col .= '<h3><a href="">'.esc_html($board->title).'</a></h3>';
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
                            $col .= '<input type="hidden" value="'.esc_attr($board->id).'" id="parent_board_id" />';
                        } else {
                            $col .= '<h2 class="user-not-loggedin">'.esc_html__('Login/Register to submit feature request. ', 'fluent-features-board').'<a href="#" id="ffr-login-register-popup">'.esc_html__('Login/Register', 'fluent-features-board').'</a></h2>';
                        }
                        $col .= '</form>';
                    $col .= '</div>';
                $col .= '</div>';

                $col .= '<div class="ff-requests-list-box">';
                $col .= '<p>('.count($form).') '.esc_html__('feature requests', 'fluent-features-board').'</p> ';
                $col .= '<div class="ff-requests-list-body">';
                $col .= '<span id="back-to-all-requests-list">Back</span>';

                foreach($form as $item) {
                    global $wpdb;
                    $user_info = get_userdata($item->post_author);
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
                    if($item->post_author == $current_user->ID) {
                        $is_current_user_loggedin = ' active';
                    } else {
                        $is_current_user_loggedin = '';
                    }
                    // $getVotes = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ffr_votes WHERE post_id={$item->id}");
                    $checkUserVoted = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ffr_votes WHERE post_id={$item->id} AND vote_user_id={$current_user->ID}");


                    $comments = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ffr_comments WHERE comment_post_ID={$item->id}");
                    $count_comments = count($comments);
                    $ffr_requests_list = $wpdb->prefix.'ff_requests_list';
                    $where = [ 'id' => $item->id ];
                    $wpdb->update(
                        $ffr_requests_list,
                        array(
                            'comments_count' => $count_comments
                        ),
                        $where                
                    );
                    
                    $col .= '<div class="ff-request-item'.esc_attr($is_current_user_loggedin). ' '.$is_administrator.'" data-name="'.esc_attr($item->title).'">';

                        if($item->post_author == $current_user->ID ) {
                            if($current_user->roles[0] == 'subscriber') {
                                $col .= '<span class="user-action"><a href="">'.esc_html__('Edit', 'fluent-features-board').'</a>|<a id="delete-feature-request" href="#" data-id="'.esc_attr($item->id).'">'.esc_html__('Delete', 'fluent-features-board').'</a></span>';
                            }
                        }

                        if($board->show_upvotes == 'yes') {
                            if(is_user_logged_in()) {
                                $notLoggedin = ' ';
                                if($checkUserVoted) {
                                    $disabled = ' removeVote ';
                                } else {
                                    $disabled = ' addVote ';
                                }
                            } else {
                                $notLoggedin = ' id="ffr-login-register-popup" ';
                                $disabled = '';
                            }
                                $col .= '<div '.$notLoggedin.' class="ff-request-vote '.esc_attr($disabled).'" data-postid="'.esc_attr($item->id).'">';
                                    $col .= '<span class="ff-request-vote-btn"></span>';
                                    
                                    $col .= '<input type="text" value="'.esc_attr($item->votes_count).'" class="ff-request-vote-count" readonly/>';
                                    // foreach($getVotes as $vote) {
                                    //     $allvotes = $vote->votes_count;
                                    //     error_log(print_r($allvotes, 1));
                                    //     $col .= '<input type="text" value="'.esc_attr($vote->votes_count).'" class="ff-request-vote-count" readonly/>';
                                    // }
                                $col .= '</div>';
                        }
                        $col .= '<div class="ff-request-content">';
                            $col .= '<h3>';
                                $col .= esc_html($item->title);
                            $col .= '</h3>';
                            if($item->status) {
                                $col .= '<p class="status"><span class="'.esc_attr($status).'">'.esc_html($status_text).'</span></p>';
                            }
                            $col .= '<p class="description">'.esc_html($item->description).'</p>';
                        $col .= '</div>';
                        $col .= '<div class="ff-request-comment-count">';
                        $col .= '<span class="comment-icon"></span>';
                        $col .= '<span class="comment-number" data-comments="'.esc_attr($item->comments_count).'">'.esc_html($item->comments_count).'</span>';
                        $col .= '</div>';



                        // Request Details Modal
                        $col .= '<div class="ff-request-item-details-wrap" >';
                            $col .= '<div class="ff-request-item-details-content">';
                                $col .= '<h2 class="ff-request-author"><img width="32" height="32" src="'.esc_url(get_avatar_url($item->post_author)).'" />'.esc_html($user_info->display_name).'</h2>';
                                $col .= '<p>'.esc_html($item->description).'</p>';
        
                                // Comments List
                                $col .= '<div class="ff-request-comments-list">';
                                    $col .= '<ul class="ff-request-comment">';
                                    
                                    $comments = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ffr_comments WHERE comment_post_ID={$item->id}");

                                    foreach($comments as $comment) {
                                        $col .= '<li>';
                                            $col .= '<h2 class="ff-request-comment-author">';
                                                $col .= '<img width="32" height="32" src="'.get_avatar_url($comment->comment_user_id).'"/>'.esc_html($comment->comment_author);
                                            $col .= '</h2>';
                                            $col .= '<p class="ff-request-comment-content">'.esc_html($comment->comment_content).'</p>';
                                        $col .= '</li>';
                                    }

                                    $col .= '';

                                    $col .= '</ul>';
                                $col .= '</div>';
        
        
                                $col .= '<form class="ff-request-comment-form" >';
                                    $col .= '<p class="success_message">'.esc_html__('Success!', 'fluent-features-board').'</p>';
                                    $col .= '<input type="hidden" name="comment_post_id" value="'.esc_attr($item->id).'"/>';
                                    if(is_user_logged_in(  )) {
                                        $col .= '<div class="input-group">';
                                            $col .= '<textarea name="comment" placeholder="'.esc_attr__('Leave A Comment', 'fluent-features-board').'" required></textarea>';
                                        $col .= '</div>';
        
                                        $col .= '<div class="input-group submit-comment">';
                                            $col .= '<button type="submit">'.esc_html__('Submit', 'fluent-features-board').'</button>';
                                        $col .= '</div>';
                                    } else {
                                        $col .= '<div class="not-loggedin">';
                                            $col .= '<h1>'.esc_html__('Login to submit a comment. ', 'fluent-features-board').'<a id="ffr-login-register-popup" href="#">'.esc_html__('Login', 'fluent-features-board').'</a></h1>';
                                        $col .= '</div>';
                                    }
                                $col .= '</form>';
                            $col .= '</div>';
                        $col .= '</div>';

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

}

